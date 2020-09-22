<?php

namespace App\Http\Controllers;

use App\produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;
use Intervention\Image\ImageManager as Image;
use App\Categori;
use App\stok;
use App\produk_material;
use App\produk_subcategori;
use PDF;


use App\Imports\ProdukImport;
use App\Exports\ProdukExport;
use Maatwebsite\Excel\Facades\Excel;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
        public function __construct()
        {
            $this->middleware('auth');
        }
     public function index()
    {
        $categori = Categori::all();
        $produk = produk::with(['categori','subcategori'])->get();
        return view('produk.index',compact('produk','categori'));
    }

    public function import(Request $request)
    {
        // validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_produk',$nama_file);
 
		// import data
		Excel::import(new ProdukImport, public_path('/file_produk/'.$nama_file));
 
		// notifikasi dengan session
        $request->session()->flash('sukses','Data Produk Berhasil Diimport!');

		// alihkan halaman kembali
		return redirect('/produk');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categori = Categori::orderBy('name')->get();
        return view('produk.create',compact('categori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request,[
            'kode'=>'required',
            'name'=>'required',
            'categori_id'=>'required',
            'foto'=> 'mimes:jpeg,png,gif,webp|max:2048',
        ]);
        try {
            // Produk
            $produk = produk::find($request->kode);
            if($produk)
            {                  
                return redirect()->back()->with(['error'=>"Kode ".$produk->id." sudah ada dengan ".$produk->nama]);
            }
            
            if($request->foto == null)
            {
                produk::create([
                    'kode'=>$request->kode,
                    'name'=>$request->name,
                    'categori_id'=>$request->categori_id,
                    'foto'=>'ibaraki.Png',
                    'deskripsi'=>$request->deskripsi,
                    ]);
            }else
            {
                $file = $request->file('foto');
                $files = $file->getClientOriginalName();
                \Image::make($file)->resize(300, 200)->save(storage_path('app/produk/'. $files));
                produk::create([
                    'id'=>$request->kode,
                    'name'=>$request->name,
                    'categori_id'=>$request->categori_id,
                    'ketersediaan'=>$request->ketersediaan,
                    'foto'=>'ibaraki.Png',
                    'deskripsi'=>$request->deskripsi
                ]);
            }
            return redirect(route('produk.store'))->with(['success'=>'Berhasil memasukan data']);
        } catch (\Throwable $th)
        {
            dd($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\produks  $produks
     * @return \Illuminate\Http\Response
     */
    public function show(produks $produks)
    {
        return $produk;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\produks  $produks
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\produks  $produks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $this->validate($request,[
            'kode'=>'required',
            'name'=>'required',
            'categori_id'=>'required',
            'foto'=> 'mimes:jpeg,png,gif,webp|max:2048',
            
        ]);
        $produk = produk::find($id);
        
        // Produk
        if($request->foto == null)
        {
            $produk->update([
                'id'=>$request->kode,
                'name'=>$request->name,
                'categori_id'=>$request->categori_id,
                'foto'=>'ibaraki.Png',
                'deskripsi'=>$request->deskripsi
                ]);
            
        }else
        {
            $file = $request->file('foto');
            $files = $file->getClientOriginalName();
            \Image::make($file)->resize(300, 200)->save(storage_path('app/produk/'. $files));
            $produk->update([
                'id'=>$request->kode,
                'name'=>$request->nama,
                'categori_id'=>$request->categori_id,
                'foto'=>'ibaraki.Png',
                'deskripsi'=>$request->deskripsi
            ]);
        }
        return redirect(route('produk.index'))->with(['success'=>'Berhasil Di update']);
        
    }
    public function item($id)
    {
        $produk = Produk::find($id);
        switch ($produk->ketersediaan) {
            case 'kosong':
                $produk->update([
                    'ketersediaan'=>'ready'
                ]);
                $message = array('success'=>'Berasil mengubah ke tersedia');    
                break;
            case 'ready':
                $produk->update([
                    'ketersediaan'=>'kosong'
                ]);
                $message = array('success'=>'Berasil mengubah ke tidak tersedia');     
                break;
        }
        return redirect()->back()->with($message);
    }
    public function edit($id)
    {
        $produk['data'] = Produk::find($id);
        $produk['kategori'] = Categori::orderBy('name')->get();
        
        return view('produk.edit',compact('produk'));
    }
    public function destroy($id)
    {
        $produk = Produk::destroy($id);
        return redirect()->back()->with(['success'=>'Berhasil di hapus']);
    }
    public function showMaterial($id)
    {
        // Load Stok
        $data['stok'] = stok::all();
        // Stok Detail
        $data['produk'] = produk::with(['categori','categori.subcategori','subcategori','subcategori.subcategori'])->find($id);
        // Load
        $data['material'] = json_decode(request()->cookie('material'), true);
        // dd($data['material']);
        return view('material.edit',compact('data'));
    }
    public function updateMaterial(Request $request, $id)
    {
        $this->validate($request,[
        'stok_id'=>'required',
        'qty_pakai'=>'required|integer'
        ]);
        try {
            $stok = stok::find($request->stok_id);
            // // nilai ekonomis
            $nilai_ekonomis = $stok->harga_ekonomis*$request->qty_pakai;
            $carts = json_decode($request->cookie('material'), true);     
            if ($carts && array_key_exists($stok->id, $carts))
            {
                //MAKA UPDATE QTY-NYA BERDASARKAN PRODUCT_ID YANG DIJADIKAN KEY ARRAY
                $carts[$stok->id]['qty_pakai'] += $request->qty_pakai;
                $carts[$stok->id]['nilai_ekenomis_pakai'] += $nilai_ekonomis;
            } else {
                $carts[$stok->id] = [
                    'name'=>$stok->stokcol,
                    'stok_id'=>$request->stok_id,
                    'qty_pakai'=>$request->qty_pakai,
                    'nilai_ekenomis_pakai'=>$nilai_ekonomis
                ];            
            
            }
            $cookie = cookie('material', json_encode($carts), 288);
            // Store on cookies
            return redirect()->back()->cookie($cookie);
            // return redirect(route('produk_material.edit',['id'=>$id]))->with(['message'=>'Berhasil ditambahkan']);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function destroyMaterial($id)
    {
        
        // dd($id);
        // $material = produk_material::destroy($id);
        //AMBIL DATA DARI COOKIE
        $carts = json_decode(request()->cookie('material'), true);
        //KEMUDIAN LOOPING DATA PRODUCT_ID, KARENA NAMENYA ARRAY PADA VIEW SEBELUMNYA
        //MAKA DATA YANG DITERIMA ADALAH ARRAY SEHINGGA BISA DI-LOOPING
        unset($carts[$id]);
        //SET KEMBALI COOKIE-NYA SEPERTI SEBELUMNYA
        $cookie = cookie('material', json_encode($carts), 2880);
        //DAN STORE KE BROWSER.
        return redirect()->back()->with(['message'=>"Berhasil dihapus"])->cookie($cookie);
    }
    public function destroySubcategori($id)
    {
        $subcategori = produk_subcategori::find($id);
        $hapus = $subcategori->produk_material()->delete();
        
        $subcategori = produk_subcategori::destroy($id);
        return redirect()->back()->with(['success'=>"Berhasil dihapus"]);
    }
    public function editSubcategori($id)
    {
        \Cookie::forget('material');
        $subcategori = produk_subcategori::find($id);
        $collection = $subcategori->produk_material()->get();
        $carts = json_decode(request()->cookie('material'), true);      
        foreach ($collection as $a)
        {

            $stok = stok::find($a->stok_id);
            $carts[$a->stok_id] = [
                'name'=>$stok->stokcol,
                'stok_id'=>$a->stok_id,
                'qty_pakai'=>$a->qty_pakai,
                'nilai_ekenomis_pakai'=>$a->nilai_ekenomis_pakai
            ]; 
        }
        $subcategori = produk_subcategori::destroy($id);
        $cookie = cookie('material', json_encode($carts), 2880);
        //DAN STORE KE BROWSER.
        return redirect()->back()->with(['message'=>"Berhasil dihapus"])->cookie($cookie);
    }
    public function clearCookie()
    {
        $cookie = \Cookie::forget('material');
        return redirect()->back()->with(['message'=>"Berhasil dihapus"])->cookie($cookie);

    }
    public function storeProduk(request $request,$id)
    {
       
        $this->validate($request,[
            'harga'=>'required',
            'subcategori_id'=>'required'
        ]);
    
        // Create Subcategori
         //MENGAMBIL DATA DARI COOKIE
        $carts = json_decode(request()->cookie('material'), true);
        // HPP
        $hpp = collect($carts)->sum(function($q) {
            return $q['nilai_ekenomis_pakai']; //SUBTOTAL TERDIRI DARI QTY * PRICE
        });
        // LABA
        $laba = $request->harga - $hpp;
        // COOKIE
        $collection = collect($carts)->map(function ($name)
        {
           return 
           [
                "stok_id" =>$name['stok_id'],
                "qty_pakai" => $name['qty_pakai'],
                "nilai_ekenomis_pakai" => $name['nilai_ekenomis_pakai']
           ]; 
        })->all();
        // Produk has Subcategori
        $produk = produk::with(['subcategori'])->find($id); 
        // Insert
        try{
            // Membuat produk terdiri dari beberapa kategori
            $cek = $produk->subcategori()->where('subcategori_id',$request->subcategori_id)->first();
            if($cek)
            {
                return redirect()->back()->with(['error'=>"subcategori Telah ada "]);
            }else
            {
                $produk->subcategori()->create(
                    [
                    'subcategori_id'=>$request->subcategori_id,
                    'harga'=>$request->harga,
                    'hpp'=>$hpp,
                    'laba'=>$laba
                ]);
            }
            // Mencari categori yag dili[ilih]
            $getsubcategori = $produk->subcategori()->where('subcategori_id',$request->subcategori_id)->first();
            $subcategori = produk_subcategori::with(['produk_material'])->find($getsubcategori->id);
            // dd($subcategori->produk_material()->get());    
                foreach ($collection as $a)
                {
                    $subcategori->produk_material()->create([
                        'stok_id'=>$a['stok_id'],
                        'qty_pakai'=>$a['qty_pakai'],
                        'nilai_ekenomis_pakai'=>$a['nilai_ekenomis_pakai'],
                    ]);
                }
                return redirect()->back()->with(['success'=>"Berhasil dibuat ".$produk->name]);
            
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    // EXPORT GRAMASI
    public function export()
	{
        $produk = produk::with(['subcategori','subcategori.subcategori','subcategori.produk_material','subcategori.produk_material.stok'])
        ->orderBy('categori_id')
        ->orderBy('name')    
        ->get();
        return view('produk.pdf',compact('produk'));
    }
    
}
