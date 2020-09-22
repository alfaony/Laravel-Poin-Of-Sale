<?php

namespace App\Http\View;

use Illuminate\View\View;
use App\Categori;

class CategoriComposer
{
    public function compose(View $view)
    {
        //JADI QUERY TADI KITA PINDAHKAN KESINI
        //$categories = Categori::with(['produk'])->withCount(['produk'])->getParent()->orderBy('name', 'ASC')->get();
      	//KEMUDIAN PASSING DATA TERSEBUT DENGAN NAMA VARIABLE CATEGORIES
        //$view->with('categories', $categories);
    }
}