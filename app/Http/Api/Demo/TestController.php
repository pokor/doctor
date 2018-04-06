<?php

namespace App\Http\Api\Demo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    //
    public function index(){
        echo json_encode([
           1
        ]);die();
    }
}
