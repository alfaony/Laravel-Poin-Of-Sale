<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Komposisi Detail of ibaraki</title>
<style>
  div {
    -webkit-column-count: 3;
    -moz-column-count: 3;
    column-count: 3;
  
    -webkit-column-rule: 1px double black;
    -moz-column-rule: 1px double black;
    column-rule: 1px double black;
  }
</style>
</head>
<body>
<center><h2>KOMPOSISI MENU IBARAKI</h2></center>
<div>
@foreach($produk as $p)
            <p>
            <ul>
                <li>
                     {{ $p->name }}   
                </li>
            </ul>
            <ul>
                
                    @foreach($p->subcategori as $s)
                        <ul>
                            <li>
                                {{ $s->subcategori->name }}
                            </li>
                            
                                <ul>
                                    @foreach($s->produk_material as $m)
                                    <li>
                                        {{ $m->qty_pakai }} {{ $m->stok->stokcol }} 
                                    
                                    </li>
                                     @endforeach
                                </ul>
                            
                        </ul>
                    @endforeach
                
            </ul>
            </p>
        @endforeach 

</div>
</body>
</html>