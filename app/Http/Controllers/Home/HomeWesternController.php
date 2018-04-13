<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/*class HomeWesternController extends Controller
{
    //
    public function index(Request $request){

        $user = DB::table('hospital')
            ->join('department', 1, '=', 'department'.'1')
            ->join('category', 1, '=', 'category'.'1')
            ->select(1, 'department.department_name', 'category.class_name')
            ->get();

        dd($user);
    }
}*/
