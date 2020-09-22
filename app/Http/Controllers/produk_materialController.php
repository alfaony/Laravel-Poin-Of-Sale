<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\produk;


class produk_materialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $id;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        'stok_id'=>'required',
        'qty_pakai'=>'required|integer'
        ]);
        // Produk
        $stok = stok::find($request->stok_id);
        try {
            $nilai_ekonomis = $stok->harga_ekonomis*$request->qty_pakai;
            produk_material::create([
                'produk_id'=>$id,
                'stok_id'=>$request->stok_id,
                'qty_pakai'=>$request->qty_pakai,
                'nilai_ekenomis_pakai'=>$nilai_ekonomis
            ]);
            return redirect(route('produk_material.edit',['id'=>$id]))->with(['message'=>'Berhasil ditambahkan']);
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
        $material = produk_material::destroy($id);
        return redirect()->back()->with(['message'=>"Berhasil dihapus"]);
    }
}
