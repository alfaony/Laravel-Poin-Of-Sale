@extends('tamplate.content')
@section('header')
    <link rel="stylesheet" href="{{ asset('tamplate/plugins/select2/css/select2.css') }} "/>
    <link rel="stylesheet" href="{{ asset('tamplate/plugins/select2-bootstrap4-theme/select2-bootstrap4.css') }}">
@endsection
@section('content')
<div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Sub Kategori {{ $categori->name }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('categori.index') }}">Kategori</a></li>
                            <li class="breadcrumb-item active">SubKategori</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
​
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        @component('components.card')
                            @slot('title')
                            Tambah
                            @endslot
                            
                            @if (session('error'))
                                <div class="alert alert-error">
                                    {!! session('error') !!}
                                </div>
                            @endif
​
                            <form role="form" action="{{ route('categori.update',$categori->id)}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Kategori</label>
                                    <input type="text" 
                                    name="name"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" required>
                                </div>
                            @slot('footer')
                                <div class="card-footer">
                                    <button class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                            @endslot
                        @endcomponent
                    </div>
                    <div class="col-md-8">
                        @component('components.card')
                            @slot('title')
                            List Kategori
                            @endslot
                            
                            @if (session('success'))
                                <div class="alert alert-success"> 
                                    {!! session('success') !!}
                                </div>
                            @endif
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>Kategori</td>
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @forelse ($subcategori as $row)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>
                                                <form action="{{ route('subcategori.destroy', $row->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button class="btn btn-danger btn-sm" onclick="return myFunction();"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @slot('footer')
​
                            @endslot
                        @endcomponent
                </div>
            </div>
        </section>
    </div>
@endsection
@section('footer')
    <script>
    function myFunction() {
        if(!confirm("Are You Sure to delete this"))
        event.preventDefault();
    }
    </script>
    <script src="{{ asset('tamplate/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{ asset('tamplate/plugins/select2/js/select2.js')}}"></script>
    <script>
    $(function () {
        $("#e2").select2();
    });
</script>   
@endsection