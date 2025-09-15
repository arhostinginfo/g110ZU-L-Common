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
    Gallary

};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebSiteController extends Controller
{
    public function index()
    {

        $welcomenote = WelcomeNote::where('is_deleted', 0)
                ->where('is_active', 1)
                ->orderBy('id', 'desc')
                ->first();

        $officers = Officers::where('is_deleted',0)
                ->where('is_active', 1)
                ->orderBy('id', 'desc')
                ->get();

        $officerData = $officers->where('type', 'Officer')->sortBy('sequence_officer');
        $sadsyaAll  = $officers->where('type', 'Sadsya')->sortBy('sequence_sadsya');



        $gallaries = Gallary::where('is_deleted',0)
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


        $navbar =  Navbars::where('is_deleted',0)
                ->where('is_active', 1)
                ->orderBy('id', 'desc')
                ->first();

        $slider = Slider::where('is_deleted',0)
                ->where('is_active', 1)        
                ->orderBy('id', 'desc')
                ->get();

       $marquee = Marquees::where('is_deleted', 0)
                    ->where('is_active', 1)       
                    ->orderBy('id', 'asc')
                    ->pluck('message')   // get only the message column
                    ->implode(' | ');    // join with |

        $yojna_all = Yojna::where('is_deleted',0)
                ->where('is_active', 1)
                ->orderBy('id', 'desc')
                ->get();


        $AbhiyanAll = Abhiyans::where('is_deleted',0)
                ->where('is_active', 1)        
                ->orderBy('id', 'desc')
                ->get();

         $famouslocations = Famouslocations::where('is_deleted',0)
                ->where('is_active', 1)
                ->orderBy('id', 'desc')
                ->get();                    
        return view('website.index', compact('welcomenote','gallay_photos', 'gallay_videos', 'navbar', 'slider', 'marquee', 'famouslocations', 'AbhiyanAll', 'yojna_all','officerData','sadsyaAll'));
    }

    
}
