<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeTraditionalController extends Controller
{
    //
    public function index(Request $request){
        $a = $request->input('hospital_id');
        //dd(5555555);

        $data = [];

        $data[0] = [
            'department_id' => '1',
            'department_name' => '内科',
            'category_items' => [
                [
                    'category_id' => '100',
                    'category_name' => '普通内科'
                ],
                [
                    'category_id' => '101',
                    'category_name' => '心脏内科'
                ],

            ]
        ];

        $data[1] = [
            'department_id' => '2',
            'department_name' => '外科',
            'category_items' => [
                [
                    'category_id' => '1001',
                    'category_name' => '普通外科'
                ],
                [
                    'category_id' => '1012',
                    'category_name' => '心胸内科'
                ],

            ]
        ];



        // 包装数据

        $department_categorys = [];

        $departments = DB::table('hos_dep_cat')->where("hospital_id",$a)->get();

        //查医院下的部门
        foreach ($departments as $k=> $department){
            $department =  DB::table('department')->where("id",$department->department_id)->first();

            $department_categorys[$k]['department_id'] = $department->id;
            $department_categorys[$k]['department_name'] = $department->department_name;

            //查医院和部门下面的分类

            $categorys = DB::table('hos_dep_cat')->where("hospital_id",1)->where("department_id",$department->id)->get();
            foreach ($categorys as $k1 => $category){
                $category =  DB::table('category')->where("id",$category->class_id)->first();
                //dd($category);
                $department_categorys[$k]['category_items'][$k1]['category_id'] = $category->id;
                $department_categorys[$k]['category_items'][$k1]['category_name'] = $category->class_name;
            }
        }

        return response($department_categorys);
    }
}
