<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;



use App\produk_subcategori;
use App\produk;
use App\kerja;
use App\to_order;
use App\total_order;



class ApiController extends Controller
{
    // API
    public function produkSubcategori()
    {  
        
        $produk = produk::with(['categori','subcategori','subcategori.subcategori'])
        ->where('ketersediaan','ready')
        ->orderBy('categori_id')
        ->orderBy('name')
        ->get();
        return response()->json($produk, 200);
    }
    
    public function addToCart(Request $request)
    {   
        $this->validate($request, [
            'produk_subcategori_id' => 'required|exists:produk_subcategori,id',
            'qty' => 'required|integer'
        ]);
        
        //mengambil data product berdasarkan id
        $produk_subcategori = produk_subcategori::with(['subcategori','produk'])->findOrFail($request->produk_subcategori_id);
        
        //mengambil cookie cart dengan $request->cookie('cart')
        $getCart = json_decode($request->cookie('cart'), true);
        if ($getCart) 
        {
            //jika key nya exists berdasarkan product_id
            if (array_key_exists($request->produk_subcategori_id, $getCart)) {
                //jumlahkan qty barangnya
                $getCart[$request->produk_subcategori_id]['qty'] += $request->qty;
                //dikirim kembali untuk disimpan ke cookie
                return response()->json($getCart, 200)->cookie('cart', json_encode($getCart), 120);
            }
        }
        //jika cart kosong, maka tambahkan cart baru
        $getCart[$request->produk_subcategori_id]=
        [
            'id'=> $request->produk_subcategori_id,
            'id_produk'=> $produk_subcategori->produk_id,
            'produk' => $produk_subcategori->produk->name,
            'subcategori' => $produk_subcategori->subcategori->name,
            'harga' => $produk_subcategori->harga,
            'laba'=>$produk_subcategori->laba,
            'qty'=>$request->qty
        ];

        //kirim responsenya kemudian simpan ke cookie
        return response()->json($getCart, 200)
            ->cookie('cart', json_encode($getCart), 120); 
    }
    public function getCart()
    {
        //mengambil cart dari cookie
        $cart = json_decode(request()->cookie('cart'), true);
        //mengirimkan kembali dalam bentuk json untuk ditampilkan dengan vuejs
        return response()->json($cart, 200);
    }
    // CART
    public function plusCart($id)
    {
        $cart = json_decode(request()->cookie('cart'), true);

        $cart[$id]['qty'] += 1;

        return response()->json($cart, 200)->cookie('cart', json_encode($cart), 120);
         
    }
    public function minusCart($id)
    {
        $cart = json_decode(request()->cookie('cart'), true);
        
        if($cart[$id]['qty'] == 1)
        {
            unset($cart[$id]);
        }else{
            $cart[$id]['qty'] = $cart[$id]['qty'] -  1;
        }

        return response()->json($cart, 200)->cookie('cart', json_encode($cart), 120);
    }
    public function removeCart($id)
    {
        $cart = json_decode(request()->cookie('cart'), true);
        //menghapus cart berdasarkan product_id
        unset($cart[$id]);
        //cart diperbaharui
        return response()->json($cart, 200)->cookie('cart', json_encode($cart), 120);
    }
    // END CART
    public function generateTotal()
    {
        
        //Antrian
        $kerja =  kerja::orderBy('tanggal','ASC')->get();
        $getKerja = $kerja->last();
        
        if($getKerja->status == 'tutup')
        {
            $cart = json_decode(request()->cookie('cart'), true);
            $identitas = [
                'kondisi'=>'TUTUP'
            ];
            
            return response()->json($identitas, 200)->cookie(Cookie::forget('cart'));;
        }
        // IDENTITAS
        

        $antrian = $getKerja->antrian;
        $getKerja->update([
            'antrian'=> $antrian +1
        ]);
        $code = "ibrk-".rand(0,10000)."-".date('Ymd');
        
        $identitas= 
        [
            'antrian'=>$antrian,
            'code'=> $code,
            'status' => "waiting",
            'tanggal' => $getKerja->tanggal,
            'kondisi'=>'OPEN'
        ];
        return response()->json($identitas, 200)->cookie('identitas', json_encode($identitas), 120);
    }
    public function insertToOrder(Request $request)
    {             
        // return $request;
        to_order::create($request->all());
        return response()->json([
            'message'=> 'success'
        ], 200);
    }
    public function antrian(Request $request)
    {
        $this->validate($request,[
            'antrian'=>'required|integer'
        ]);
        //Antrian
        $kerja =  kerja::orderBy('tanggal','ASC')->get();
        $getKerja = $kerja->last(); 
        
        $total_order = total_order::where('tanggal',$getKerja->tanggal)->where('antrian',$request->antrian)->first();
        $to_order = to_order::where('total_order_code',$total_order->code)->get();
        $to_orderlast = $to_order->last();
        $identitas = [
            'id_to'=> $to_orderlast->id_to + 1,
            'user_id'=> $total_order->user_id,
            'antrian' => $total_order->antrian,
            'tanggal' => $total_order->tanggal,
            'code'=> $total_order->code,
            'tota' => $total_order->total,
            'status' => 'waiting'
        ];
        return response()->json($identitas);
    }
    public function insertTotalOrder(Request $request)
    {     
        $total_order = total_order::where('code',$request->code)->first();
        $total_order->update([
            'user_id'=> $request->user_id,
            'pembayaran'=>'cash',
            'total' =>$request->total            
        ]);
        return response()->json([
            'message'=> 'tunggu robot kami memberitahu melalui whatsapp'
        ], 200)->cookie(Cookie::forget('cart'));
    }
    // BARISTA #BARISTA
    public function pembelian()
    {
        // COOKIE KERJA
        $cookie = json_decode(request()->cookie('kerja'), true);

        // COOKIE BILL
        $pembelian = Total_order::with(['to_order','to_order.produkSubcategori'
                                        ,'to_order.produkSubcategori.subcategori'
                                        ,'to_order.produkSubcategori.produk'])
                                        ->where('status','waiting')
                                        ->where('tanggal',$cookie['kerja']['tanggal'])
                                        ->orderBy('antrian')
                                        ->get();
                                
    
        return $pembelian;
    }
    public function checkout(Request $request)
    {        
        //mengambil list cart dari cookie
        $cart = json_decode($request->cookie('cart'), true);
        $identitas = json_decode($request->cookie('identitas'), true);
        //memanipulasi array untuk menciptakan key baru yakni result dari hasil perkalian price * qty
        
        $result = collect($cart)->map(function($value) {
            return [
                'id'=> $value['id'],
                'id_produk'=> $value['id_produk'],
                'produk' => $value['produk'],
                'subcategori' => $value['subcategori'],
                'total_harga' => $value['harga'] * $value['qty'],
                'total_laba'=>$value['laba'] * $value['qty'],
                'qty'=>$value['qty']
            ];

        })->all();
        
        //database transaction
        DB::beginTransaction();

        $harga = array_sum(array_column($result,'total_harga'));
        $tax= ($harga*$request->tax)/100;
        try {
            $total_order = Total_order::create([
                'code'=>$identitas['code'],
                'user_id'=>$request->user_id,
                'total'=> array_sum(array_column($result,'total_harga')) + $tax,
                'laba'=>array_sum(array_column($result,'total_laba')),
                'status'=> $identitas['status'],
                'antrian'=> $identitas['antrian'],
                'pembayaran'=>'cash',
                'tanggal'=>$identitas['tanggal']
            ]);
            
            foreach ($result as $key)
            {
                // return $identitas;
                to_order::create([
                        'produk_subcategori_id'=>$key['id'],
                        'qty'=>$key['qty'],
                        'total_order_code'=> $identitas['code'],
                        'harga'=>$key['total_harga'],
                        'laba'=>$key['total_laba'],
                        'status'=>'waiting',
                        'antrian'=> $identitas['antrian'],
                        'tanggal'=>$identitas['tanggal']
                ]);

            }
            
             //apabila tidak terjadi error, penyimpanan diverifikasi
            DB::commit();
    
            //me-return status dan message berupa code invoice, dan menghapus cookie
            return response()->json([
                'status' => 'success'
            ], 200)->cookie(Cookie::forget('cart'));
        } catch (\Exception $e) {
            //jika ada error, maka akan dirollback sehingga tidak ada data yang tersimpan 
            DB::rollback();
            //pesan gagal akan di-return
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }
    public function kerja(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");
    
        // PEMASANGAN COOKIE
        $cookie = json_decode(request()->cookie('kerja'), true);
        
        switch ($request->kondisi) {
            case "open": 
                $cookie['kerja'] = 
                        [
                            'tanggal'=>date('Y-m-d')
                        ];
                try {
                    kerja::create([
                        'status'=>'ready',
                        'user_id'=>'12341213',
                        'tanggal'=>$cookie['kerja']['tanggal'],
                        'jam_buka'=>date('h:i:s'),
                        'jam_tutup'=>'00:00:00',
                        'antrian'=>1,
                        'total'=>0,
                        'profit'=>0,
                        'sales'=>0
                    ]);

                    return response()->json($cookie, 200)->cookie('kerja', json_encode($cookie), 120);
                } catch (\Throwable $th) {
                    kerja::where('tanggal',$cookie['kerja']['tanggal'])->update([
                        'status'=>'ready',
                        'jam_buka'=>date('h:i:s'),
                        'jam_tutup'=>'00:00:00',
                    ]);

                    return response()->json($cookie, 200)->cookie('kerja', json_encode($cookie), 120);
                }
            
                return response()->json($cookie, 200)->cookie('kerja', json_encode($cookie), 120);
                break;
            case "close":
                $kerja = Kerja::where('tanggal',$cookie['kerja']['tanggal'])->update([
                    'status'=>'tutup',
                    'jam_tutup'=>date('h:i:s')
                ]);
                return response()->json([
                    'message'=> 'Tutup'
                ], 200)->cookie(Cookie::forget('kerja'));
        }
    }


    public function updateBuy(Request $request)
    {   
        
        // TOT
        $total = Total_order::find($request->code);
        
        $total->to_order()->update([
            'status'=>'done'
        ]);

        Total_order::where('code',$request->code)->update([
            'status'=>'done'
        ]);
        return "Sucess";
    }
    public function getTimeWork()
    {
        $kerja =  kerja::orderBy('tanggal','ASC')->get();
        $getKerja = $kerja->last(); 
        switch ($getKerja->status)
        {
            case 'tutup':
                return "false";
                break;
            case 'ready':
                return "true";
                break;
        }
    }
    public function pembelianToday()
    {
        $cookie = json_decode(request()->cookie('kerja'), true);
        
        $pembelianToday = Total_order::where('status','done')
                                        ->where('tanggal',$cookie['kerja']['tanggal'])
                                        ->orderBy('antrian')
                                        ->get();

        return response()->json($pembelianToday,200);
    }
    public function cookie(){
        try {
            kerja::where('tanggal',date('Y-m-d'))->update([
                'status'=>'ready',
                'user_id'=>'12341213',
                'jam_buka'=>date('h:i:s'),
                'jam_tutup'=>'00:00:00',
                'total'=>0,
                'profit'=>0,
                'sales'=>0
            ]); 

            return "sukses";
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
    }
    public function getBil(Request $request)
    {

        $pembelian = Total_order::with(['to_order','to_order.produkSubcategori'
                                        ,'to_order.produkSubcategori.subcategori'
                                        ,'to_order.produkSubcategori.produk'])
                                        ->where('code',$request->code)
                                        ->orderBy('antrian')
                                        ->first();
        return $pembelian;
        // return response()->json($pembelian,200);

        // return Total_order::find($request->code);
    }
    public function bayar(Request $request)
    {
        
    }
}