@extends('tamplate.content')
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
                                        <td width="30%">Nama</td>
                                        <td>:</td>
                                        <td>{{ $data['produk']->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jenis</td>
                                        <td>:</td>
                                        <td>{{ $data['produk']->jenis }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kode</td>
                                        <td>:</td>
                                        <td> {{ $data['produk']->id }} </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-12 mt-3">
                                <form action="{{ route('produk_material.update',['id'=>$data['produk']->id ]) }}" method="post" >
                                <input type="hidden" name="_method" value="PUT" >
                                @csrf
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>Produk</td>
                                            <td>Gram</td>
                                            <td>Harga Ekonomis</td>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <!-- MENAMPILKAN PRODUK YANG TELAH DITAMBAHKAN -->
                                    <tbody>
                                        @php $no = 1 @endphp
                                    </tbody>
                                    <!-- MENAMPILKAN PRODUK YANG TELAH DITAMBAHKAN -->
                                    <!-- FORM UNTUK MEMILIH PRODUK YANG AKAN DITAMBAHKAN -->
                                    
                                    <tfoot>
                                        @foreach($data['stok_detail'] as $a)
                                        <tr>
                                            <td>
                                                {{ $no++}}
                                            </td>
                                            <td>
                                                {{ $a->stokcol }}
                                            </td>
                                            <td>
                                                {{ $a->qty_pakai }}
                                            </td>
                                            <td>
                                             {{ $a->nilai_ekenomis_pakai }}
                                            </td>
                                            <td>
                                                <a href="{{ url('produk/material/delete',['id'=>$a->id]) }}" class="btn btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                        
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td>
                                                <input type="hidden" name="_method" value="PUT" class="form-control">
                                                <select name="stok_id" class="form-control" >
                                                    @foreach($data['stok'] as $a)
                                                        <option value="{{ $a->id }}">{{ $a->stokcol }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" min="1" value="1" name="qty_pakai" class="form-control" required>
                                            </td>
                                            <td colspan="3">
                                                <button class="btn btn-primary btn-sm">Tambahkan</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <!-- FORM UNTUK MEMILIH PRODUK YANG AKAN DITAMBAHKAN -->
                                </table>
                                </form>
                            </div>
                            
                            <!-- MENAMPILKAN TOTAL & TAX -->
                            <div class="col-md-4 offset-md-8">
                                <table class="table table-hover table-bordered">
                                    <tr>
                                        <td>Harga</td>
                                        <td>:</td>
                                        <td>Rp {{ $data['produk']->harga }}</td>
                                    </tr>
                                    <tr>
                                        <td>Harga Pokok</td>
                                        <td>:</td>
                                        <td>Rp {{ $data['produk']->hpp }}</td>
                                    </tr>
                                    <tr>
                                        <td>Laba</td>
                                        <td>:</td>
                                        <td>Rp {{ $data['produk']->laba }}</td>
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
        $("#e3").select2();
    });
</script>   
@endsection