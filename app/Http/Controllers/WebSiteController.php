<?php

namespace App\Http\Controllers;

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
    PDFUpload

};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebSiteController extends Controller
{
    public function index($gpname)
    {

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
        return view('website.index', compact('welcomenote','gallay_photos', 'gallay_videos', 'navbar', 'slider', 'marquee', 'famouslocations', 'AbhiyanAll', 'yojna_all','officerData','sadsyaAll','pdf_all'));
    }


public function dakhalaStore(Request $request)
{
    $data = $request->validate([
        'mobile_no'        => ['required', 'regex:/^[6-9]\d{9}$/'],
        'applicant_name'   => 'required|string|max:255',
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
