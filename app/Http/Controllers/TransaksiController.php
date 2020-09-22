<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

use App\total_order;
use App\to_order;
use App\produk;
use App\produk_material;
use App\stok;
use App\Kerja;
use App\Categori;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $this->validate($request,
        [
            'date'=> 'required'
        ]);

        $data['date'] = $request->date;

        $date = explode('-',$request->date,2);
        $startDate = str_replace('/', '-',trim($date[0]));
        $endDate = str_replace('/', '-',trim($date[1]));
        
        // Tanggal
        $tanggal = \DB::table('to_order')
        ->select('tanggal')
        ->whereBetween('tanggal',[$startDate,$endDate])
        ->groupBy('tanggal')
        ->get();
        

        $tgl = array();
        foreach ($tanggal as $x)
        {
            if($x == null){
                $tgl[] = "Kosong";
            }else
            {
                $tgl[] = $x->tanggal;
            }
        }
        $data['tanggal'] = $tgl;

    
        // Produk
        $produk = \DB::table('categori')->get();
        
        $colJenis = array();
        foreach($produk as $p)
        {
            $jenis = \DB::table('to_order')
            ->join('produk','to_order.id_produk','=','produk.id')
            ->select([
                \DB::raw('count(id_produk) as jumlah')
            ])
            ->where('produk.categori_id','=',$p->id)
            ->whereBetween('to_order.tanggal',[$startDate,$endDate])
            ->groupBy('to_order.tanggal')
            ->get();
            
            $dumy = array();
            $dumy['name'] = $p->name;
            foreach($jenis as $j)
            {
                $dumy['data'][] = $j->jumlah;
            }
            $colJenis[] = $dumy;
        }

        $data['produk'] = $colJenis;
        // Transaksi
        $data['transaksi'] = total_order::whereBetween(\DB::raw('DATE(tanggal)'),
        array($startDate,$endDate))
        ->get();
        
        return view('transaksi.index',['data'=>$data]);        
    }
    
    public function create()
    {
        //
    }

    // produk categori
    public function categoryProduct($slug)
    {
       //JADI QUERYNYA ADALAH KITA CARI DULU KATEGORI BERDASARKAN SLUG, SETELAH DATANYA DITEMUKAN
       //MAKA SLUG AKAN MENGAMBIL DATA PRODUCT YANG BERELASI MENGGUNAKAN METHOD PRODUCT() YANG TELAH DIDEFINISIKAN PADA FILE CATEGORY.PHP SERTA DIURUTKAN BERDASARKAN CREATED_AT DAN DI-LOAD 12 DATA PER SEKALI LOAD
        $products = Categori::where('slug', $slug)->first()->product()->orderBy('created_at', 'DESC')->paginate(12);
        //LOAD VIEW YANG SAMA YAKNI PRODUCT.BLADE.PHP KARENA TAMPILANNYA AKAN KITA BUAT SAMA JUGA
        dd($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'date'=> 'required | max: 10 | min: 10'
        ]);
        // Get No antrian terakhir
        $today = total_order::where('tanggal',$request->date)->get();
        // Generate No Nota
        $code = "ibrk-".rand(0,10000)."-".date('Ymd');

        try{
           if($today->last() != null)
           {
                $newAntrian = $today->last()->antrian+1;
                total_order::create(
                    [
                        'code' => $code,
                        'user_id' => 'U1ce722b8407b007ef1cf356b3b9196ce',
                        'status' =>'done',
                        'total' =>0,
                        'laba' =>0,
                        'antrian' => $newAntrian,
                        'pembayaran' =>'cash',
                        'tanggal' => $request->date
                ]);
           }else{
                 total_order::create(
                     [
                         'code' => $code,
                         'user_id' => 'U1ce722b8407b007ef1cf356b3b9196ce',
                         'status' =>'done',
                         'total' =>0,
                         'laba' =>0,
                         'antrian' => '1',
                         'pembayaran' =>'cash',
                         'tanggal' => $request->date
                 ]);
           }
           return redirect(route('transaksi.edit',['id'=>$code]));
        } catch (\Throwable $th)
        {
            dd($th);
            return redirect()->back()->with(['error'=>$th->e]);
        }
        

        // Create total_order
        try {
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd($id);
    }

    public function edit($id)
    {
        // dd($id);
        $data['to_order'] = \DB::table('to_order')->where('code','=',$id)->get();
        $data['total'] = \DB::table('total_order')
        ->join('profiles','profiles.user_id','=','total_order.user_id')
        ->select('antrian','total_order.status','pembayaran','profiles.display_name','total','code','total_order.tanggal')
        ->where('code','=',$id)->first();

        $data['produk'] = produk::all();
            
        return view('transaksi.edit',['data'=>$data]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'produk'=>'required',
            'tanggal'=>'required'   
        ]);
        

        // Menampilkan pesanan sebelumnya
        $to_order = to_order::where('code',$id)->get();
        // Menampilkan pesanan
        $produk = produk::find($request->produk);
        // Menampilkan Nota
        $total = total_order::where('code',$id)->first();
        // Make ID
        $last = $to_order->last();
        // menampilkan material

        try {
            $material = produk_material::where('produk_id',$produk->id)->get();
            foreach ($material as $a)
            {
                $stok = stok::find($a->stok_id);
                $cek_gram = $stok->berat - $a->qty_pakai;
                if($cek_gram < 0)
                {
                    return redirect()->back()->with(['error'=>'Produk telah habis']);
                }
            }
            if($last == null )
            {
                to_order::create([
                    'id_to'=> '1',
                    'id_produk'=>$request->produk,
                    'idproduk'=>$produk->nama,
                    'harga'=>$produk->harga,
                    'laba'=>$produk->laba,
                    'code'=>$id,
                    'antrian'=>'1',
                    'tanggal'=> $request->tanggal
                ]);
            }else
            {
                $newid = (string)$last->id_to+1;
                to_order::create([
                    'id_to'=>$newid,
                    'id_produk'=>$request->produk,
                    'idproduk'=>$produk->nama,
                    'harga'=>$produk->harga,
                    'laba'=>$produk->laba,
                    'code'=>$id,
                    'antrian'=>'1',
                    'tanggal'=> $request->tanggal
                ]);
            }

        return redirect()->back()->with(['success'=>'Berhasil terinput']);
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with(['error'=>$th->e]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $to_order = \DB::table('to_order')
        ->where('id_total','=',$request->code)
        ->where('id_to','=',$id)
        ->first();

        $this->generateStokBaru($to_order->id_produk);
        try {
            $to_order = to_order::where('id_total',$request->code)
            ->where('id_to',$id)
            ->delete();
            
            $to_order = to_order::where('id_total',$request->code)->get();
            if($to_order != null)
            {
                $no = 1;
                foreach ($to_order as $x)
                {
                    to_order::where('id_total',$x->code)
                    ->where('id_to',$x->id_to)
                    ->update(
                        [
                            'id_to'=>$no
                    ]);
                $no++;
                }
            }

            // total
            $total = $to_order->sum(function($i)
            {
                return $i->harga;
            });
            

            $laba = $to_order->sum(function($i)
            {
                return $i->laba;
            });

            //Update total Pemesanan
            $total_order = total_order::where('code',$request->code)
            ->update([
                'total'=> $total,
                'laba'=>$laba
            ]);
            return redirect()->back()->with(['success'=> 'Berhasil dihapus']);
        } catch (\Throwable $th) 
        {
            dd($th);
            return redirect()->back()->with(['error'=> $th->e]);
        }   
    }

    // For Delelete transaksi
    public function forceDelete(Request $request)
    {
        
        total_order::where('code',$request->code)->delete();
        to_order::where('code',$request->code)->delete();
        
        return $this->index($request);
    }
    private function generateStokBaru($toOrder)
    {        
        // Stok
        $material = produk_material::where('produk_id',$toOrder)->get();
        foreach ($material as $a)
        {
            $stok = stok::find($a->stok_id);
            $cek_gram = $stok->berat + $a->qty_pakai;
            $stok->update([
                'berat'=>$cek_gram
                ]);
        }  
    }
    public function transaksiFront()
    {
        $categori = Categori::orderBy('name')->get();
        return view('transaksis.index',compact('categori'));
    }
}
