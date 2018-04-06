<?php

namespace App\Http\Api\Media;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PictureController extends Controller
{
    //
    public function index(Request $request){
        //dd(558585);

        return view('media.picture');
    }
}
