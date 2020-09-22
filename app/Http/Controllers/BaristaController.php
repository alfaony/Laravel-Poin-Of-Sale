<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\Barista;
use App\Categori;
use App\Produk;


class BaristaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function produk()
    {
        $categori = Categori::all();
        $produk = produk::with(['categori','subcategori'])->get();
        return view('barista.produk',compact('produk','categori'));
    }
    public function index()
    {
        $data['user'] = \DB::table('profiles')
        ->whereNotExists(function($query){
            $query->select(\DB::raw(1))
            ->from('barista')
            ->whereRaw('profiles.user_id = barista.user_id');
        })
        ->get();

        $data['barista'] = \DB::table('barista')
        ->join('profiles','barista.user_id','=','profiles.user_id')
        ->select('barista.id','barista.username','barista.password','profiles.display_name','barista.created_at')
        ->get();
        
        return view('option.barista',['data'=>$data]);
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
       
        $this->validate($request,[

            'user_id'=> 'required',
            'username'=> 'required |max:8',
            'password'=>'required |max:8'
        ]);
        
         
        try 
        {
            $barista = Barista::create([
                'user_id'=>$request->user_id,
                'username'=>$request->username,
                'password'=>$request->password
            ]);
            
            return redirect()->back()->with(['sucess'=>"Berasil terdaftar"]);   
        
        
        } catch (\Throwable $th)
        {
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
        $profile = Profile::find($id);
        switch ($profile->status) {
            case 'customer':
                $profile->update([
                    'status'=>'service'
                ]);
                $message = array('success'=>'Berasil mengubah ke service');    
                break;
            case 'service':
                $profile->update([
                    'status'=>'customer'
                ]);
                $message = array('success'=>'Berasil mengubah ke customer');     
                break;
        }

        return redirect()->back()->with($message);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $destroy = Barista::destroy($id);
        return redirect()->back()->with(['sucess'=>'Barista Berhasil di hapus']);
    }


    // BARISTA DO
    public function layout()
    {
        return view('barista.index');
    }
    public function kerja()
    {
        $kerja = Kerja::all();
        
    }
}
