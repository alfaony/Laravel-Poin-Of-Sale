@extends('tamplate.content')
@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Bahan Penyusun {{ $data['material']->name }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Bahan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content" id="dw">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        @component('components.card')
                            @slot('title')
                                Bahan
                            @endslot
​
                            <div class="row">
                                <div class="col-md-9">
                                    <!-- SUBMIT DIJALANKAN KETIKA TOMBOL DITEKAN -->
                                    <form action="{{route('produk_material.update',['id'=>$data['material']->id])}}" method="post">
                                        @csrf
                                        @method('put')
                                        <div class="form-group">
                                            <label for="">Produk</label>
                                            <select name="stok_id"  v-model="cart.stok_id"
                                            required width="100%" id="e1">
                                                    @foreach($data['stok'] as $a)
                                                        <option value="{{ $a->id }}">{{ $a->stokcol }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Qty</label>
                                            <input type="number" name="qty_pakai"
                                                id="qty_pakai" value="1" 
                                                min="1" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-sm"
                                                :disabled="submitCart">
                                                <i class="fa fa-shopping-cart"></i> Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
    
                                <!-- MENAMPILKAN DETAIL PRODUCT -->
                                
                                <!-- MENAMPILKAN IMAGE DARI PRODUCT -->
                            </div>
                            @slot('footer')
​
                            @endslot
                        @endcomponent
                    </div>
                    <!-- MENAMPILKAN LIST PRODUCT YANG ADA DI KERANJANG -->
                    <div class="col-md-8">
                    @component('components.card')
                            @slot('title')
                                Keranjang
                            @endslot
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Qty</th>
                                        <th>Harga Ekonomis</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- MENGGUNAKAN LOOPING VUEJS -->
                                    @forelse($data['material']->material as $a)
                                    <tr>
                                        <td>{{ $a->stok->stokcol }}</td>
                                        <td> {{ $a->qty_pakai }} </td>
                                        <td>Rp. {{ number_format($a->nilai_ekenomis_pakai) }} </td>
                                        <td>
                                            <!-- EVENT ONCLICK UNTUK MENGHAPUS CART -->
                                            <form action="{{ route('produk_material.delete',['id'=>$a->id])}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button 
                                                @click.prevent="removeCart(index)"    
                                                class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            </form>
                                            
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td rowspan="4">
                                            Data Kosong
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @slot('footer')
                            <form action="{{ route('storeProduk',['id'=>$data['material']->id])}}" method="post">
                                @csrf
                                <div class="card-footer text-muted">
                                    <div class="form-group">
                                        <label>Harga</label> 
                                        <input type="number" min="1" name="harga" class="form-control" id="" placeholder="0">
                                    </div>
                                    <div class="form-group">
                                        <label>Produk</label>
                                        <select class="form-control" name="subcategori_id">
                                            @foreach($data['material']->categori->subcategori as $a)
                                                <option value="{{ $a->id }}"> {{ $a->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button class="btn btn-info btn-sm float-right">
                                        Submit Material Produk
                                    </button>
                                </div>
                            </form>
                            @endslot
                        @endcomponent
                    </div>
                    <div class="col-md-12">
                    @component('components.card')
                            @slot('title')
                                Subcategori
                            @endslot
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Subcategori</th>
                                        <th>Harga</th>
                                        <th>Hpp</th>
                                        <th>Laba</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @forelse($data['material']->subcategori as $a)
                                    <tr>
                                        <td>{{ $a->subcategori->name }}</td>
                                        <td>{{ $a->harga }}</td>
                                        <td>{{ $a->hpp }}</td>
                                        <td>{{ $a->laba }}</td>
                                        <td>
                                            <form action="{{ route('produk_material.delete',['id'=>$a->id])}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button 
                                                    @click.prevent="removeCart(index)"    
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td rowspan="4">
                                            Data Kosong
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @slot('footer')
                                
                            @endslot
                    @endcomponent
                </div>
            </div>
        </section>
    </div>
@endsection
@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/accounting.js/0.4.1/accounting.min.js"></script>
    <script src="{{ asset('js/transaksi.js')}}"></script>
    <script>
        $(function (){
            $("#e1").select2();
        });
    </script>    
@endsection