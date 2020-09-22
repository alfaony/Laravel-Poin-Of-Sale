<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categori;
use App\subcategori;

class CategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categori = Categori::orderBy('name','Desc')->get();
        return view('categori.index', compact('categori'));  
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
        //validasi form
        $this->validate($request, [
            'name' => 'required|string|max:50'
        ]);
            try {
                $categories = Categori::firstOrCreate(
                    [
                    'name' => $request->name
                    ]);
                return redirect()->back()->with(['success' => 'Kategori: ' . $categories->name . ' Ditambahkan']);
            } catch (\Exception $e) 
            {
                return redirect()->back()->with(['error' => $e->getMessage()]);
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
        $categori = Categori::find($id);
        $subcategori = $categori->subcategori()->get(); 
        
        return view('categori.edit',compact('categori','subcategori'));
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
            'name' => 'required|string|max:50|'
        ]);
            try {
                $categori = Categori::find($id);
                $subcategori = $categori->subcategori()->insert([
                    'name'=>$request->name,
                    'categori_id'=>$categori->id
                ]);
                return redirect()->back()->with(['success' => 'Sub Kategori  ' . $request->name . ' Ditambahkan']);
            } catch (\Exception $e) 
            {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function subdestroy($id)
    {
        try {
            $subcategori = Subcategori::destroy($id);
            return redirect()->back()->with(['success' => 'Sub Kategori Dihapus']);
        } catch (\Exception $e) 
        {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $categori = Categori::find($id);
            $delete = $categori->subcategori()->delete();
            $categori = Categori::destroy($id);
            return redirect()->back()->with(['success' => 'Kategori Dihapus']);
        } catch (\Exception $e) 
        {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    
}
