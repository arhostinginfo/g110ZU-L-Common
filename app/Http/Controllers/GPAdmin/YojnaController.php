<?php

namespace App\Http\Controllers\GPAdmin;
use App\Http\Controllers\Controller;
use App\Models\Yojna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class YojnaController extends Controller
{
    protected $gp_name_in_url;
    protected $gp_name;
    protected $gp_user_id;

    public function __construct()
   {
		$this->gp_name_in_url = Session::get('gp_name_in_url');
        $this->gp_name = Session::get('gp_name');
        $this->gp_user_id = Session::get('gp_user_id');
   }

    public function list()
    {
        $yojna = Yojna::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$this->gp_name_in_url,
					'gp_user_id'=>$this->gp_user_id,
				])
                ->orderBy('id', 'desc')
                ->get();
        return view('gpadmin.yojna.list', compact('yojna'));
    }

    public function add()
    {
        return view('gpadmin.yojna.create');
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type_attachment' => 'required|max:255', //Sadsya or officer
            'attachment' => 'nullable|mimes:jpeg,jpg,png,pdf,doc,docx,xls,xlsx|max:3072',
            'attachment_link'  => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('attachment')) {
            // Save file to storage/app/public/officers

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'type_attachment' => 'required|max:255', //Sadsya or officer
                'attachment' => 'nullable|mimes:jpeg,jpg,png,pdf,doc,docx,xls,xlsx|max:3072',
            ]);

            $data['attachment'] = $request->file('attachment')->store($this->gp_name_in_url.'/yojna', 'public');
        }
        $data['gp_name_in_url']= $this->gp_name_in_url;
        $data['gp_user_id']= $this->gp_user_id;
        $data['is_active'] = $request->input('is_active', 1);

        Yojna::create($data);

        return redirect()->route('gpadmin.yojna.list')->with('success', 'Officer added successfully.');
    }

    public function edit($encodedId)
    {
        $id = base64_decode($encodedId);
        $yojna = Yojna::where('id', $id)
            ->where('gp_user_id', $this->gp_user_id)
            ->firstOrFail();
        return view('gpadmin.yojna.edit', compact('yojna','encodedId'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'encodedId' => 'required',
            'name' => 'required|string|max:255',
            'type_attachment' => 'required|max:255', //Sadsya or officer
        ]);


            $id = base64_decode($request->encodedId);
            $data = [
                'designation' => $request->input('designation'),
                'name' => $request->input('name'),
                'type_attachment' => $request->input('type_attachment'), 
                'attachment_link' => $request->input('attachment_link'), 
                'is_active' => $request->input('is_active', 1),
                'gp_name_in_url'=>$this->gp_name_in_url,
				'gp_user_id'=>$this->gp_user_id,
            ];

        $officer = Yojna::where('id', $id)
            ->where('gp_user_id', $this->gp_user_id)
            ->firstOrFail();
        if ($request->hasFile('attachment')) {
            // remove old if exists
            if ($officer->attachment && Storage::disk('public')->exists($officer->attachment)) {
                Storage::disk('public')->delete($officer->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store($this->gp_name_in_url.'/yojna', 'public');
        }

        $officer->update($data);

        return redirect()->route('gpadmin.yojna.list')->with('success', 'Officer updated successfully.');
    }

    public function delete(Request $request)
    {
        $id = base64_decode($request->encodedId);
        $officer = Yojna::where('id', $id)
            ->where('gp_user_id', $this->gp_user_id)
            ->firstOrFail();
        if ($officer->attachment && Storage::disk('public')->exists($officer->attachment)) {
            Storage::disk('public')->delete($officer->attachment);
        }
        Yojna::where('id', $id)->update(['is_deleted' => 1]);
        return redirect()->route('gpadmin.yojna.list')->with('success', 'Yojana deleted successfully.');
    }

    public function updateStatus(Request $request)
    {
        try {
            $id = base64_decode($request->id);
            Yojna::where('id', $id)
                ->where('gp_user_id', $this->gp_user_id)
                ->update(['is_active' => $request->is_active]);
            return redirect()->route('gpadmin.yojna.list')->with('success', 'Status updated successfully.');
        } catch (\Exception $e) {
            \Log::error('YojnaController@updateStatus: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update status. Please try again.');
        }
    }
}
