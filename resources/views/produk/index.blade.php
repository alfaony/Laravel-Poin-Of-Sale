@extends('tamplate.content')
@section('header')
<!-- DataTables -->

@endsection
@section('content')
    <div class="content-wrapper">
    <section class ="content">
          <div class="card">
                <div class="card-header">
                  <h5 class="card-title">Upload data</h5>
                  {{-- notifikasi form validasi --}}
                  @if ($errors->has('file'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('file') }}</strong>
                  </span>
                  @endif

                  {{-- notifikasi sukses --}}
                  @if ($sukses = Session::get('sukses'))
                  <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $sukses }}</strong>
                  </div>
                  @endif
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-center">
                        <strong>Upload data dengan excle</strong>
                      </p>
                      <p class="text-left">
                        Cara upload Stok
                      </p>
                      <ol>
                        <li>
                          <strong> Isilah kolom pada excle sesuai table dibawah ini </strong>
                          <table class="table table-border">
                            <tr>
                              <td>
                                  Kode
                              </td>
                              <td>
                                  Nama
                              </td>
                              <td>
                                  Kategori Produk
                                </td>
                            </tr>
                          </table>
                        </li>
                        <li>
                         <strong> Isi Semua form dan isi data kategori dengan angka dibawah ini </strong>
                          <ul>
                          @forelse($categori as $a)
                              <li>
                                 <strong> {{ $a->id }} {{ $a->name }} </strong>
                              </li>
                            @empty
                              <li>
                                  Data Kategori kosong
                              </li>
                          @endforelse
                          </ul>
                        </li>
                        <li>
                           <strong> Upload </strong>
                        </li>
                      </ol>
                      <form method="post" action="{{ route('produk.import') }}"  enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file">
                        <button class="btn btn-primary">Upload</button>
                      </form>
                      </div>
                      <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
          </section>
        <section class="content">
            <div class="row">
                <div class="col-12">
                <div class="card">
          <!-- /.card -->
          <div class="row">
                <div class="col-12">
                
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Produk</h3>
                    </div>
                      @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                      @endif
                    <!-- /.card-header -->
                    <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                         <tr>
                            <th> No </th>
                            <th>Kode Produk</th>
                            <th>Nama && BOM</th>
                            <th>Kategori</th>
                            
                            <th>Ketersediaan</th>
                            <th>
                                Aksi
                            </th>
                            <th>
                              status
                            </th>
                        </tr>
                        </thead>
                        
                    <tbody>
                    @php $no = 1 @endphp
                        @foreach($produk as $a)
                          <tr>
                            <td>
                                {{  $no++ }}
                            </td>
                            <td>
                              {{  $a->kode }}
                            </td>
                            <td>
                              <a href="{{route('produk_material.edit',['id'=>$a->id])}}" class="btn-btn primary"><span> {{  $a->name }} </span></a>
                            </td>
                            <td>
                              {{  $a->categori->name }}
                            </td>
                            
                            <td>
                            <form action="{{route('produk.item',['id'=>$a->id]) }}" method="POST">
                                                @csrf
                                                @switch($a->ketersediaan)
                                                    @case('ready')
                                                        <input type="hidden" name="_method" value="PUT" class="form-control">
                                                        <button class="btn btn-success btn-sm">Tersedia</button>
                                                    @break
                                                    @case('kosong')
                                                        <input type="hidden" name="_method" value="PUT" class="form-control">
                                                        <button class="btn btn-danger btn-sm">Kosong</button>
                                                    @break
                                                @endswitch
                                            </form>
                            </td>
                            </td>
                            <td>
                            <form action="{{route('produk.edit',['id'=>$a->id])}}" method="get">
                                  @csrf
                                  @method('PUT')
                                  <input type="hidden" name="_method" value="PUT">
                                      <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i></button>  
                                </form>
                              <form action="{{route('produk.destroy',['id'=>$a->id])}}" method="post">
                                  @csrf
                                  <input type="hidden" name="_method" value="DELETE">
                                      <button type="submit" class="btn btn-danger" onclick="return myFunction();"><i class="fa fa-trash"></i></button>  
                              </form>
                            </td>
                            <td>
                                  @php $subcategori1 = $a->subcategori()->first() @endphp
                                  @if(is_null($subcategori1))
                                  <button type="button" class="btn btn-danger" data-color="danger"><i class="fa fa-times" ></i></button>    
                                  @else
                                   <button type="button" class="btn btn-success" data-color="success"><i class="fa fa-check" ></i></button> 
                                  @endif
                            </td>
                        </tr>
                        @endforeach 
                  </tfoot> 
                </table>
                    </div>
                    <!-- /.card-body -->
                </div>
          <!-- /.card -->
        </section>
</div>
  <!-- /.content-wrapper -->
@endsection
@section('footer')
<!-- AdminLTE App -->
<script src="{{ asset('tamplate/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('tamplate/dist/js/demo.js') }}"></script>
<!-- page script -->
<!-- DataTables -->
<script src="{{ asset('tamplate/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('tamplate/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    function myFunction() {
        if(!confirm("Are You Sure to delete this"))
        event.preventDefault();
    }
    </script>
<script>
    $(function () {
      $('#dataTable').DataTable();
    });
</script>    

@endsection