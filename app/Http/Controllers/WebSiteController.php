<?php

namespace App\Http\Controllers;

use App\Models\Gpdetails;
use App\Models\
{
    WelcomeNote,
    Officers,
    Navbars,
    Slider,
    Marquees,
    Famouslocations,
    Yojna,
    Abhiyans,
    Gallary,
    ContactDakhala,
    PDFUpload,
    TaxDemand,
    TaxDocument,
    TaxTip

};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class WebSiteController extends Controller
{
    public function index($gpname)
    {
        $gp = \DB::table('gpdetails')
            ->where('gp_name_in_url', $gpname)
            ->where('is_deleted', '!=', 1)
            ->first();

        // GP does not exist
        if (!$gp) {
            return view('website.not-found', ['gpname' => $gpname]);
        }

        // Check 1: GP is_active must be 1
        if ((int)$gp->is_active !== 1) {
            return view('website.inactive', ['gpname' => $gpname]);
        }

        // Check 2: GP validity must not be expired
        if (!empty($gp->gp_valid_till) && Carbon::parse($gp->gp_valid_till)->lt(Carbon::today())) {
            return view('website.inactive', ['gpname' => $gpname]);
        }

        $welcomenote = WelcomeNote::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$gpname,
					
				])
                                ->where('is_active', 1)
                                ->orderBy('id', 'desc')
                                ->first();

        // $officers = Officers::where([
					// 'is_deleted'=>0,
					// 'gp_name_in_url'=>$gpname,
					// 
				// ])
        //         ->where('is_active', 1)
        //         ->orderBy('id', 'desc')
        //         ->get();

        $officerData =  Officers::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$gpname,
					
				])
                ->where('is_active', 1)
                ->where('type', '=',  'Officer')
                ->orderBy('sequence_officer', 'asc')
                ->get();
        $sadsyaAll  =Officers::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$gpname,
					
				])
                ->where('is_active', 1)
                ->where('type', '=',  'Sadsya')
                ->orderBy('sequence_general', 'asc')
                ->get();



        $gallaries = Gallary::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$gpname,
					
				])
                ->where('is_active', 1)
                ->orderBy('id', 'desc')
                ->get();

        $gallay_photos = $gallaries->where('type_attachment', 'Image');
        if($gallay_photos) {
                $gallay_photos =$gallay_photos;
        } else {
            $gallay_photos = [
                        [
                                'name' => 'Test',
                                'attachment' => asset('storage/default.jpg'),
                        ],
                ];
        }
        $gallay_videos  = $gallaries->where('type_attachment', 'Video');


        $navbar =  Navbars::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$gpname,
					
				])
                                ->where('is_active', 1)
                                ->orderBy('id', 'desc')
                                ->first();

        $slider = Slider::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$gpname,
					
				])
                                ->where('is_active', 1)        
                                ->orderBy('id', 'desc')
                                ->get();

       $marquee = Marquees::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$gpname,
					
				])
                                ->where('is_active', 1)       
                                ->orderBy('id', 'asc')
                                ->pluck('message')   // get only the message column
                                ->implode(' | ');    // join with |

        $yojna_all = Yojna::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$gpname,
					
				])
                                ->where('is_active', 1)
                                ->orderBy('id', 'desc')
                                ->get();
        $pdf_all = PDFUpload::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$gpname,
					
				])
                ->where('is_active', 1)
                ->orderBy('id', 'desc')
                ->get();

        $AbhiyanAll = Abhiyans::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$gpname,
					
				])
                                ->where('is_active', 1)        
                                ->orderBy('id', 'desc')
                                ->get();

         $famouslocations = Famouslocations::where([
					'is_deleted'=>0,
					'gp_name_in_url'=>$gpname,
					
				])
                                ->where('is_active', 1)
                                ->orderBy('id', 'desc')
                                ->get();                    
        $gharPattiDemands = TaxDemand::where('gp_name_in_url', $gpname)
            ->where('tax_type', 'ghar_patti')
            ->get()
            ->keyBy('period');

        $paaniPattiDemands = TaxDemand::where('gp_name_in_url', $gpname)
            ->where('tax_type', 'paani_patti')
            ->get()
            ->keyBy('period');

        $taxDocuments = TaxDocument::where('gp_name_in_url', $gpname)
            ->where('is_active', true)
            ->get()
            ->groupBy(['tax_type', 'document_type']);

        $taxTip = TaxTip::where('gp_name_in_url', $gpname)
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->orderBy('id', 'desc')
            ->first();

        return view('website.index', compact('welcomenote','gallay_photos', 'gallay_videos', 'navbar', 'slider', 'marquee', 'famouslocations', 'AbhiyanAll', 'yojna_all','officerData','sadsyaAll','pdf_all','gharPattiDemands','paaniPattiDemands','taxDocuments','taxTip'));
    }


public function dakhalaStore(Request $request)
{
    $data = $request->validate([
        'mobile_no'        => ['required', 'regex:/^[6-9]\d{9}$/'],
        'applicant_name'   => 'required|string|max:255',
        'applicant_email'   => 'required|email|max:255',
        'print_name'       => 'required|string|max:255',
        'address'          => 'required|string',
        'certificate_type' => 'required|string',
        'gp_name_in_url'   => 'required|string',
    ]);

    try {
        ContactDakhala::create($data);

        return redirect()->back()
            ->with('dakhala_success', 'आपला अर्ज यशस्वीरित्या सबमिट झाला आहे.')
            ->withFragment('dakhala');

    } catch (\Exception $e) {

        \Log::error($e);

        return redirect()->back()
            ->with('dakhala_error', 'काहीतरी चूक झाली. कृपया पुन्हा प्रयत्न करा.')
            ->withFragment('dakhala');
    }
}
}
