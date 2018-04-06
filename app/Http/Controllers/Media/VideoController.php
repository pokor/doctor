<?php

namespace App\Http\Controllers\Media;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    //
    public function index(){
        return view('media.video');
    }
    public function uploadVideo(Request $request){
        dd($request->all());
    }
}
