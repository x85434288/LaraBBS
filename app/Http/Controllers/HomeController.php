<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('home');
        $month=date('m');  //获取当月月份
        $year=date('Y');  //获取当年年份
        if($month%2==1){
            $month=date('Y-m-d',strtotime('-2 month'));                  //奇数减2
            $year=date('Y',strtotime('-2 month'));
        }else{
            $month=date('Y-m-d',strtotime('-1 month'));               //偶数减1
            $year=date('Y',strtotime('-1 month'));
        }
        $key_1=date('n',strtotime($month));
        //$url = "http://jk.jznews.com.cn/ww/js/data/yj_".$year."_".$key_1.".js?callback=DataCallback";
        $url = "http://jk.jznews.com.cn/ww/js/data/yj_2018_7.js?callback=DataCallback";
        if($dataCallBack = @file_get_contents($url)){

            $num = substr_count($dataCallBack,'"id"');

            if($num<10){

                if($month%2==1){
                    $month=date('Y-m-d',strtotime('-2 month'));                  //奇数减2
                    $year=date('Y',strtotime('-2 month'));
                }else{
                    $month=date('Y-m-d',strtotime('-3 month'));               //偶数减3
                    $year=date('Y',strtotime('-3 month'));
                }

            }

        }else{

            if($month%2==1){
                $month=date('Y-m-d',strtotime('-2 month'));                  //奇数减2
                $year=date('Y',strtotime('-2 month'));
            }else{
                $month=date('Y-m-d',strtotime('-3 month'));               //偶数减3
                $year=date('Y',strtotime('-3 month'));
            }

        }


        dd($month);

    }


    }
