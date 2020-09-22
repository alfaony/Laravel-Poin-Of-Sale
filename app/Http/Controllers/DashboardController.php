<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\produk;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        // TODAY
        $data['today'] = \DB::table('kerja')
        ->join('barista','kerja.userid','=','barista.user_id')
        ->join('profiles','kerja.userid','=','profiles.user_id')
        ->select('profiles.display_name','barista.username','kerja.antrian','kerja.jam_buka','kerja.jam_tutup','kerja.tanggal')
        ->orderBy('tanggal','DESC')
        ->first();

        // Best 10 Produk
        $data['produk'] = \DB::table('to_order')
        ->join('produk','to_order.id_produk','=','produk.id')
        ->select('produk.name as name',\DB::raw('count(to_order.id_produk) as y'))
        // ->whereRaw("yearweek(tanggal) = ?",array($tanggal))
        ->where('tanggal',$data['today']->tanggal)
        ->groupBy('produk.name')
        ->orderBy('y','DESC')
        ->limit('5')
        ->get();
        // 
        
        // DAILY
        $week =  \DB::table('to_order')
        ->select([ 
                \DB::raw('yearweek(tanggal) as minggu')
        ])
        ->whereMonth('tanggal',date('m',strtotime($data['today']->tanggal)))
        ->groupBy('minggu')
        ->orderBy('minggu')
        ->limit('5')
        ->get();

        $data['daily'] = array();
        $qty = array();
        $hari = array();
        $noWeek = 1;
        
        foreach ($week as $key)
        {   
            $minggu = $key->minggu;   
            // $data['monthly'] = $minggu;
            
            $day = \DB::table('to_order')
            ->select([ 
                    \DB::raw('dayname(tanggal) as hari'),
                    \DB::raw('count(id_produk) as TotalQty'),
                    'tanggal'
            ])
            ->whereRaw('yearweek(tanggal) ='.$minggu)
            ->whereMonth('tanggal',date('m',strtotime($data['today']->tanggal)))
            ->orderBy('tanggal')
            ->groupBy('tanggal')
            ->get();

            $dumy = array();
            $qty = array();
            $hari = array();
            foreach($day as $d)
            { 
                
                $dumy['hari'][] = $d->hari;
                $dumy['qty'][] = $d->TotalQty;
            }   
                $week = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
            
                $x = false;
                while ($x != true)
                {
                    $no = 0;
                    $a = 0;
                    $hitung = count($dumy['hari']);
                    
                    while ($a <= 6)
                    {
                            if($no == $hitung)
                            {
                                $no = $no - 1;
                            }
                        
                            if($week[$a] != $dumy['hari'][$no])
                            {
                                array_push($hari,$week[$a]);
                                array_push($qty,'0'); 
                            }else
                            {
                                array_push($hari,$week[$a]);
                                array_push($qty,$dumy['qty'][$no]);
                                $no++;   
                            } 
                        $a++;
                    }
                    $x = true;
                }
            

                $weekly['name'] = " Minggu ".$noWeek;
                $weekly['data'] = $qty;
                $data['daily'][] = $weekly;

                $noWeek++;
        }
        // MONTHLY
        $data['monthly'] = \DB::table('to_order')
        ->select([
            \DB::raw('monthname(tanggal) as bulan'),
            \DB::raw('sum(laba) as EstimateGP')
        ])
        ->whereYear('tanggal',$data['today']->tanggal)
        ->groupBy('bulan')
        ->orderBy('bulan','DESC')
        ->get();

        $data['bulan'] = array();
        $data['EstimateGP'] = array();

        foreach($data['monthly'] as $a)
        {
            
            $data['bulan'][] = $a->bulan;
            $data['EstimateGP'][] = $a->EstimateGP;
        }
        
        // MONEYMONTH
        $data['money'] = \DB::table('total_order')
        ->select([
            \DB::raw('sum(total) as cashflow'),
            \DB::raw('sum(laba) as profit')
        ])
        ->whereMonth('tanggal',date('m',strtotime($data['today']->tanggal)))->first();
        
        
        // MONETHTODAY
        $data['moneyDay'] = \DB::table('total_order')
        ->select([
            \DB::raw('sum(total) as cashflow'),
            \DB::raw('sum(laba) as profit')
        ])
        ->whereDate('tanggal',$data['today']->tanggal)->first();
        
        return view('dashboard',['data'=>$data]);
    }
    public function cookie(){
        \Cookie::queue(Cookie::forget('material'));
        return redirect()->back();
    }
}
