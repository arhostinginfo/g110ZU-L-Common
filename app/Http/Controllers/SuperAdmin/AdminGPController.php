<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Gpdetails;
use App\Models\District;
use App\Models\Taluka;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class AdminGPController extends Controller
{
    public function list()
    {
        $gpdetails = Gpdetails::leftJoin('districts', 'gpdetails.gp_under_district', '=', 'districts.id')
            ->leftJoin('talukas', 'gpdetails.gp_under_taluka', '=', 'talukas.id')
            ->leftJoin('navbars', 'gpdetails.gp_name_in_url', '=', 'navbars.gp_name_in_url')
            ->where('gpdetails.is_deleted', 0)
            ->orderBy('gpdetails.id', 'desc')
            ->select(
                'gpdetails.*',
                'districts.district_name',
                'talukas.taluka_name',
                'navbars.name'
            )
            ->get();



        $gpdetails->map(function ($gp) {
            $gp->employee_password = Crypt::decryptString($gp->employee_password);


            $validTill = Carbon::parse($gp->gp_valid_till);
            $today = Carbon::today();

            if ($validTill->greaterThanOrEqualTo($today)) {
                $gp->days_pending = $validTill->diffInDays($today);
            } else {
                $gp->days_pending = 0; // Or negative or expired
            }

            return $gp;
        });

        $districts = District::where('is_active', 1)->orderBy('district_name')->get();
        $talukas   = Taluka::with('district')->where('is_active', 1)->orderBy('taluka_name')->get();

        return view('superadmin.grampanchayat.list', compact('gpdetails', 'districts', 'talukas'));
    }

    public function export()
    {
        $rows = Gpdetails::leftJoin('districts', 'gpdetails.gp_under_district', '=', 'districts.id')
            ->leftJoin('talukas',   'gpdetails.gp_under_taluka',   '=', 'talukas.id')
            ->leftJoin('navbars',   'gpdetails.gp_name_in_url',    '=', 'navbars.gp_name_in_url')
            ->where('gpdetails.is_deleted', 0)
            ->orderBy('gpdetails.id', 'desc')
            ->select('gpdetails.*', 'districts.district_name', 'talukas.taluka_name', 'navbars.name as navbar_name')
            ->get();

        // Decrypt passwords and calculate days before passing to closure
        $today = Carbon::today();
        $data = $rows->map(function ($gp) use ($today) {
            try {
                $password = Crypt::decryptString($gp->employee_password);
            } catch (\Exception $e) {
                $password = $gp->employee_password;
            }

            $validTill = Carbon::parse($gp->gp_valid_till);
            // positive = days remaining, negative = days expired
            $daysLeft  = $today->diffInDays($validTill, false);

            return [
                'district_name'  => $gp->district_name  ?? '',
                'taluka_name'    => $gp->taluka_name     ?? '',
                'gp_name_in_url' => $gp->gp_name_in_url ?? '',
                'navbar_name'    => $gp->navbar_name     ?? '',
                'gp_name'        => $gp->gp_name         ?? '',
                'email'          => $gp->employee_email  ?? '',
                'password'       => $password,
                'valid_till'     => $validTill->format('d-m-Y'),
                'days_left'      => (int)$daysLeft . ' days',
                'status'         => (int)$gp->is_active === 1 ? 'Active' : 'Inactive',
            ];
        })->values()->toArray();

        $filename = 'gp-list-' . now()->format('d-m-Y') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $columns = [
            '#', 'District', 'Taluka', 'GP Name In URL', 'GP Name (Navbar)',
            'GP Name', 'GP Name In URL', 'Email', 'Password',
            'Valid Till', 'Days Left', 'Status',
        ];

        $callback = function () use ($data, $columns) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM — required for Excel to render Marathi/Devanagari correctly
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, $columns);

            foreach ($data as $i => $row) {
                fputcsv($file, [
                    $i + 1,
                    $row['district_name'],
                    $row['taluka_name'],
                    $row['gp_name_in_url'],
                    $row['navbar_name'],
                    $row['gp_name'],
                    $row['gp_name_in_url'],
                    $row['email'],
                    $row['password'],
                    $row['valid_till'],
                    $row['days_left'],
                    $row['status'],
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function add()
    {
        $districts = District::all();
        $talukas = Taluka::all();

        return view('superadmin.grampanchayat.create', compact('districts', 'talukas'));
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'employee_email' => 'required|email|max:255',
            'employee_password' => 'required|string|min:6|max:255',
            'gp_under_district' => 'required|string|max:255',
            'gp_under_taluka' => 'required|string|max:255',
            'gp_name' => 'required|string|max:255',
            // 'gp_name_in_url' => 'required|string|max:255',
            'gp_name_in_url' => 'required|string|max:255|unique:gpdetails,gp_name_in_url',

            'gp_valid_till' => 'required|date',
            'is_active' => 'sometimes|boolean',
        ]);

        // Hash password before saving
        // $data['employee_password'] = bcrypt($data['employee_password']);
        $data['employee_password'] = Crypt::encryptString($data['employee_password']);

        // Set defaults for missing fields
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['is_deleted'] = 0;

        Gpdetails::create($data);

        return redirect()->route('superadmin.admin-gp.list')->with('success', 'GP Details added successfully.');
    }

    public function edit($encodedId)
    {
        $id = base64_decode($encodedId);
        $gpdetail = Gpdetails::findOrFail($id);
        $districts = District::all();
        $talukas = Taluka::all();

        return view('superadmin.grampanchayat.edit', compact('gpdetail', 'districts', 'talukas', 'encodedId'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'encodedId' => 'required',
            'employee_email' => 'required|email|max:255',
            'employee_password' => 'nullable|string|min:6|max:255', // optional on update
            'gp_under_district' => 'required|string|max:255',
            'gp_under_taluka' => 'required|string|max:255',
            'gp_name' => 'required|string|max:255',
            // 'gp_name_in_url' => 'required|string|max:255',
             'gp_name_in_url' => [
        'required',
        'string',
        'max:255',
        Rule::unique('gpdetails', 'gp_name_in_url')->ignore(base64_decode($request->encodedId)),
    ],

            'gp_valid_till' => 'required|date',
            'is_active' => 'sometimes|boolean',
        ]);

        $id = base64_decode($request->encodedId);
        $gpdetail = Gpdetails::findOrFail($id);

        $data = [
            'employee_email' => $request->employee_email,
            'gp_under_district' => $request->gp_under_district,
            'gp_under_taluka' => $request->gp_under_taluka,
            'gp_name' => $request->gp_name,
            'gp_name_in_url' => $request->gp_name_in_url,
            'gp_valid_till' => $request->gp_valid_till,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        // If password provided, hash and update it
        if ($request->filled('employee_password')) {
            // $data['employee_password'] = bcrypt($request->employee_password);
            $data['employee_password'] = Crypt::encryptString($request->employee_password);
        }

        $gpdetail->update($data);

        return redirect()->route('superadmin.admin-gp.list')->with('success', 'GP Details updated successfully.');
    }

    public function delete(Request $request)
    {
        $id = base64_decode($request->encodedId);
        $gpdetail = Gpdetails::findOrFail($id);
        $gpdetail->update(['is_deleted' => 1]);

        return redirect()->route('superadmin.admin-gp.list')->with('success', 'GP Details deleted successfully.');
    }

    public function updateStatus(Request $request)
    {
        $id = base64_decode($request->encodedId);
        $gpdetail = Gpdetails::findOrFail($id);
        $newStatus = ((int)$gpdetail->is_active === 1) ? 0 : 1;

        \DB::table('gpdetails')->where('id', $id)->update(['is_active' => $newStatus]);

        $status = $newStatus ? 'Active' : 'Inactive';
        return redirect()->route('superadmin.admin-gp.list')->with('success', "GP \"{$gpdetail->gp_name_in_url}\" status updated to {$status}.");
    }
}
