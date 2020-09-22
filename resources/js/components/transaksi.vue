@extends('tamplate.content')
@section('header')
    <link rel="stylesheet" href="{{ asset('tamplate/plugins/select2/css/select2.css') }} "/>
    <link rel="stylesheet" href="{{ asset('tamplate/plugins/select2-bootstrap4-theme/select2-bootstrap4.css') }}">
@endsection
@section('content')
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <img src="{{ asset('laravel.png') }}" alt="" width="350px" height="150px">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <table>
                                    <tr>
                                        <td width="30%">Pemesan</td>
                                        <td>:</td>
                                        <td>{{$data['total']->display_name}}</td>
                                    </tr>
                                    <tr>
                                    
                                        <td>No Nota</td>
                                        <td>:</td>
                                        <td> {{$data['total']->code}} </td>
                                    </tr>
                                    <tr>
                                        <td>Antrian</td>
                                        <td>:</td>
                                        <td>{{$data['total']->antrian}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>:</td>
                                        <td>{{$data['total']->status}}</td>
                                    </tr>
                                        
                                </table>
                            </div>
                            
                            <div class="col-md-6" id="app">
                                <form action="{{ route('transaksi.update',[ 'id'=>$data['total']->code ]) }}" method="post" >
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT" >
                                    <table>
                                        <tr>
                                            <td>
                                                Tanggal
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                {{$data['total']->tanggal}}<input type="hidden" name="tanggal" value="{{$data['total']->tanggal}}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Pesanan Tambahan
                                                </td>
                                            </td>
                                            <td>
                                                :   
                                            </td>
                                        
                                                <td>
                                                    <select name="produk_id" required width="100%" id="e2">
                                                        @foreach($data['produk'] as $a)     
                                                            <option value="{{$a->id}}">{{$a->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                        </tr>
                                        <tr>
                                            <td> Subcategori</td>
                                            <td></td>
                                            <td>
                                                    <select name="produk_id" required width="100%" id="e2">
                                                        @foreach($data['produk'] as $a)     
                                                            <option value="{{$a->id}}">{{$a->name}}</option>
                                                        @endforeach
                                                    </select>
                                            </td>
                                        <tr>
                                        </tr>
                                            <td>
                                                <button class="btn btn-primary btn-sm">Tambahkan</button>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                                
                            </div>
                            
                            <div class="col-md-12 mt-3">
                                @csrf
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <td>id pembelian</td>
                                            <td>Kode Produk</td>
                                            <td>Produk</td>
                                            <td>Harga</td>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <!-- MENAMPILKAN PRODUK YANG TELAH DITAMBAHKAN -->
                                    <tbody>
                                        @forelse($data['to_order'] as $x)

                                        <tr>
                                            <td>{{$x->id_to}}</td>
                                            <td>{{$x->id_produk}}</td>
                                            <td>{{$x->idproduk}}</td>
                                            <td>Rp {{ number_format($x->harga) }}</td>
                                            <td>
                                                <form action="{{ route('transaksi.destroy',['id'=>$x->id_to] )}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="code" value="{{ $x->code }}" class="form-control">
                                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5">
                                                <center>Data kosong</center> 
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                    <!-- MENAMPILKAN PRODUK YANG TELAH DITAMBAHKAN -->
                                    
                                    <!-- FORM UNTUK MEMILIH PRODUK YANG AKAN DITAMBAHKAN -->
                                    
                                    <!-- FORM UNTUK MEMILIH PRODUK YANG AKAN DITAMBAHKAN -->
                                    </table>
                            </div>
                            
                            <!-- MENAMPILKAN TOTAL & TAX -->
                            <div class="col-md-4 offset-md-8">
                                <table class="table table-hover table-bordered">
                                    <tr>
                                        <td>Pembayaran</td>
                                        <td>:</td>
                                        <td>{{$data['total']->pembayaran}} </td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td>:</td>
                                        <td>Rp {{number_format( $data['total']->total )}} </td>
                                    </tr>
                                </table>
                            </div>
                            <!-- MENAMPILKAN TOTAL & TAX -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
    <script src="{{ asset('tamplate/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{ asset('tamplate/plugins/select2/js/select2.js')}}"></script>
    <script>
    $(function () {
        $("#e2").select2();
    });
    </script>
@endsection