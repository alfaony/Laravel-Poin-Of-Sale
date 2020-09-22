<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\stok;
use App\Imports\StokImport;
use Maatwebsite\Excel\Facades\Excel;

class StokController extends Controller
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
        $stok['kategori'] = \DB::table('kategori_stok')->get();
        $stok['stok'] = stok::all();
        return view('stok.index',['stok'=>$stok]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = \DB::table('kategori_stok')->get();
        return view('stok.create',['kategori'=>$kategori]);
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
            'stokcol'=>'required',
            'harga'=>'required',
            'berat'=>'required'
        ]);
        // dd($request->all());
        $harga_ekonomis = $request->harga/$request->berat;
        try {
            $update = stok::create([
                'stokcol'=>$request->stokcol,
                'kategori_stok_id'=>$request->kategori,
                'harga'=>$request->harga,
                'berat'=>$request->berat,
                'harga_ekonomis'=> $harga_ekonomis
            ]);
            return redirect(route('stok.index'))->with(['message'=>'Stok berhasil diperbarui']);
        } catch (\Throwable $th) {
            dd($th);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['a'] = stok::find($id);
        $data['kategori'] = \DB::table('kategori_stok')->get();
        return view('stok.edit',['data'=>$data]);
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
            'stokcol'=>'required',
            'harga'=>'required',
            'berat'=>'required'
        ]);
        
        $stok = stok::find($id);
        $harga_ekonomis = $request->harga/$request->berat;
        try {
            $update = $stok->update([
                'stokcol'=>$request->stokcol,
                'kategori_stok_id'=>$request->kategori_stok_id,
                'harga'=>$request->harga,
                'berat'=>$request->berat,
                'harga_ekonomis'=> $harga_ekonomis
            ]);
            return redirect(route('stok.index'))->with(['message'=>'Stok berhasil diperbarui']);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Stok::destroy($id);
        return redirect()->back()->with(['success'=>'Berhasil dihapus']);
    }

    // IMPORT
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
		$file->move('file_stok',$nama_file);
 
		// import data
		Excel::import(new StokImport, public_path('/file_stok/'.$nama_file));
 
		// notifikasi dengan session
        $request->session()->flash('sukses','Data Stok Berhasil Diimport!');

		// alihkan halaman kembali
		return redirect('/stok');
    }
}
