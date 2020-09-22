@extends('tamplate.content')
@section('header')
<!-- DataTables -->

@endsection
@section('content')
    <div class="content-wrapper">
        <section class ="content">
        <div class="card">
              <div class="card-header">
                <h5 class="card-title">Produk</h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <p class="text-center">
                      <strong>Penjualan pada bulan ini</strong>
                    </p>
                    <div class="chart">
                      <!-- Sales Chart Canvas -->
                      <!-- <canvas id="chartBulan" height="180" style="height: 180px;"></canvas> -->
                      <div id="container" height="200" style="height: 285px;"></div>
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
                    <h3 class="card-title">Transaksi</h3>
                    </div>
                    @if (session('success'))
                            <div class="alert alert-success">
                                {{ dd(session('success')) }}
                            </div>
                      @endif
                    <!-- /.card-header -->
                    <div class="card-body">
                    <table id="dataTable1" class="table table-bordered table-hover">
                    <thead>
                         <tr>
                            <th> No </th>
                            <th>Tanggal</th>
                            <th>No Nota</th>
                            <th>Total</th>
                            <th>Laba</th>
                            <th>Antrian</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>
                                Hapus
                            </th>
                        </tr>
                        </thead>
                  <tbody>
                  @php $no = 1 @endphp
                  @foreach($data['transaksi'] as $a)
                          <tr>
                            <td>
                              {{ $no++ }}
                            </td>
                            <td>
                                {{$a->tanggal}}
                            </td>
                            <td>
                                <a href="{{route('transaksi.edit',['id'=>$a->code])}}">{{$a->code}}</a>
                            </td>
                            <td>
                                {{$a->total}}
                            </td>
                            <td>
                                {{$a->laba}}
                            </td>
                            <td>
                                {{$a->antrian}}
                            </td>
                            <td>
                                {{$a->pembayaran}}
                            </td>
                            <td>
                                {{$a->status}}
                            </td>
                            <td>
                                <form action="{{route('transaksi.forceDelete')}}" method="post">
                                  @csrf
                                  <input type="hidden" name="date" value="{{ $data['date']}}">
                                  <input type="hidden" name="code" value="{{ $a->code }}">
                                  <button class="btn btn-danger btn-sm">Hapus</button>
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
 Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Stacked column chart'
    },
    xAxis: {
        categories: {!! json_encode($data['tanggal']) !!}
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total fruit consumption'
        }
    },
    tooltip: {
        pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
        shared: true
    },
    plotOptions: {
        column: {
            stacking: 'percent'
        }
    },
    series: {!! json_encode($data['produk']) !!}
});
</script>
<script>
    $(function () {
      $('#dataTable1').DataTable();
    });
</script>    

@endsection