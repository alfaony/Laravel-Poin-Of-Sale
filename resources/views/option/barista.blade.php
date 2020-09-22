@extends('tamplate.content')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Barista</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Option</a></li>
              <li class="breadcrumb-item active">Barista</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @elseif(session('success'))
                        <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form  method="post" action="{{ route('barista.store') }}">

                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <img src="" alt="" width="350px" height="150px">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                
                                    <table>
                                        <tr>
                                            <td width="30%">Nama</td>
                                            <td>:</td>
                                            <td>
                                             <select name="user_id" class="form-control">
                                                    @foreach($data['user'] as $b)
                                                        <option value="{{ $b->user_id }}">{{ $b->display_name }}</option>
                                                    @endforeach
                                            </select>

                                            </td>
                                        </tr>
                                        <tr>
                                        
                                            <td>usename</td>
                                            <td>:</td>
                                            <td> <input type="text" name="username" class="form-control"> </td>
                                        </tr>
                                        <tr>
                                            <td>Password</td>
                                            <td>:</td>
                                            <td> <input type="password" name="password" class="form-control"> </td>
                                        </tr>
                                        <td colspan="3">
                                            <button class="btn btn-primary btn-sm">Tambahkan</button>
                                        </td>
                                        
                                    </table>
                                </div>
                            </form>
                            <div class="col-md-12 mt-3">    
                                <table class="table table-hover ">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>Nama</td>
                                            <td>Username</td>
                                            <td>Password</td>
                                            <td>Tanggal</td>
                                        </tr>
                                    </thead>
                                    
                                    @foreach($data['barista'] as $a)
                                    
                                    <tbody>
                                        <td>
                                        
                                        </td>
                                        <td>
                                            {{ $a->display_name }}
                                        </td>
                                        <td>
                                            {{ $a->username }}
                                        </td>
                                        <td>
                                            {{ $a->password }}
                                        </td>
                                        <td>
                                            {{ $a->created_at }}
                                        </td>
                                        <td>
                                            <form action="{{route('barista.destroy',['id'=>$a->id]) }}" method="POST">
                                              
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE" class="form-control">
                                                <button class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                            
                                            
                                    </tbody>
                                    
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Service</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Option</a></li>
              <li class="breadcrumb-item active">Barista</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                    <!-- search -->
                            <div class="col-md-12 mt-3">    
                                <table class="table table-hover ">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>Nama</td>
                                            <td>Tanggal</td>
                                        </tr>
                                    </thead>
                                    
                                    @foreach($data['user'] as $a)
                                    
                                    <tbody>
                                        <td>
                                        
                                        </td>
                                        <td>
                                            {{ $a->display_name }}
                                        </td>
                                        <td>
                                            {{ $a->joined }}
                                        </td>
                                        
                                            
                                        <td>
                                            <form action="{{route('barista.edit',['id'=>$a->id]) }}" method="POST">
                                                @csrf
                                                @switch($a->status)
                                                    @case('customer')
                                                        <input type="hidden" name="_method" value="PUT" class="form-control">
                                                        <button class="btn btn-success btn-sm">Customer</button>
                                                    @break
                                                    @case('service')
                                                        <input type="hidden" name="_method" value="PUT" class="form-control">
                                                        <button class="btn btn-danger btn-sm">Service</button>
                                                    @break

                                                @endswitch
                                            </form>  
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection