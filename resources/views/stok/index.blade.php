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
                          <strong> Isi tabel tersebut dengan excle </strong>
                          <table class="table table-border">
                            <tr>
                              <td>
                                  Nama
                              </td>
                              <td>
                                Kategori Stok
                              </td>
                              <td>
                                  Harga
                                </td>
                              <td>
                                  Berat
                              </td>
                            </tr>
                          </table>
                        </li>
                        <li>
                         <strong> Isi Semua form dan isi data kategori dengan angka dibawah ini </strong>
                          <ul>
                          @forelse($stok['kategori'] as $a)
                              <li>
                                 <strong> {{ $a->id }} {{ $a->kategori_stokcol }} </strong>
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
                      <form method="post" action="{{ route('stok.import') }}"  enctype="multipart/form-data">
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
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga (Rp)</th>
                            <th>Berat (Gram)</th>
                            <th>Harga Ekonomis (Rp)</th>
                            <th>
                                DEL
                            </th>
                        </tr>
                        </thead>
                        
                    <tbody>
                    
                    @php $no = 1 @endphp
                        @foreach($stok['stok']   as $a)
                          <tr>
                            <td>
                                {{  $no++ }}
                            </td>
                            <td>
                                <form method="get" action="{{route('stok.edit',['id'=>$a->id])}}">
                                    @csrf
                                      <button type="submit" class="btn btn-primary">{{  $a->stokcol }}</button>  
                                </form>
                            </td>
                            <td>
                              {{  $a->kategori_stok->kategori_stokcol }}
                            </td>
                            <td>
                              {{ number_format($a->harga) }}
                            </td>
                            <td>
                              {{  $a->berat }}
                            </td>
                            <td>
                              {{  $a->harga_ekonomis }}
                            </td>
                            <td>
                              <form action="{{route('stok.destroy',['id'=>$a->id])}}" method="post">
                                  @csrf
                                  <input type="hidden" name="_method" value="DELETE">
                                      <button type="submit" class="btn btn-danger" onclick="return myFunction();"><i class="fa fa-trash"></i></button>  
                              </form>
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