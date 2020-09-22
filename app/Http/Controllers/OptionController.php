<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Option;

class OptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function optionIndex()
    {
        // SELECT ALL DATA
        $option = Option::all();
        // DATA KOSONG
        $data = array();
        foreach($option as $datas)
        {
            $data[$datas->option_name] = $datas->option_value;
        } 
        return view('option.option',['data'=>$data]);
    }
    public function optionStore(Request $request)
    { 
        $this->validate($request,
        [
            'channel_secret'=>'required',
            'channel_access_token'=>'required'
        ]);
        $param = $request->all();
        $named =array('channel_secret','channel_access_token');
        foreach ($named as $a)
        {
            
            try {
                Option::create([
                    'option_name'=>$a,
                    'option_value'=>$param[$a]
                ]);
                $message=  array(['success'=>"Berhasil ditambahkan"]);
            }catch (\Throwable $th)
            {
                \DB::table('options')->where('option_name','=',$a)->update([
                    'option_value'=>$param[$a]
                ]);
                $message=  array(['success'=>"Berhasil ditambahkan"]);
            }
        }
        return redirect()->back()->with($message);
    }
}
