@extends('tamplate.content')
@section('head')
  <link rel="stylesheet" href="{{ asset('tamplate/plugins/bootstrap/dist/css/bootstrap.min.css') }} "/>
  <link rel="stylesheet" href="{{ asset('tamplate/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}"/>
@endsection
@section('content')
    <!-- Main content -->
    <div class="content-wrapper">
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="col-md-10">
            
              <div class="card-header">
                <h3 class="card-title">Tanggal Transaksi</h3>
              </div>
              <div class="card-body">
                <!-- Date range -->
                <form action="{{ route('transaksi.create') }}" method="post">
                  @csrf
                  <div class="form-group">
                  <label>Date range:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" name="date" class="form-control float-right" id="reservation">
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="submit" value="Submit" class="btn btn-success btn">
                    </div>
                  
                  </div>
                  
                  
                </form>
            <!-- /.card-bod
            y -->
          
          <!-- /.card -->

      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
@endsection
@section('footer')
<!-- Moment -->
<script type="text/javascript" src="{{ asset('tamplate/plugins/moment/moment.min.js') }}"></script>
<!-- jQuery -->
<script src="{{asset('/tamplate/plugins/jquery/jquery.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{asset('/tamplate/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- bootstrap color picker -->
<script src="{{asset('/tamplate/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js ') }}"></script>
<script>


$(function () {
    //Initialize Select2 Elements
    //Date range picker
    $('#reservation').daterangepicker(
      {
        locale : {
          format: 'YYYY/MM/DD'
        }
      }
    );
});
</script>
@endsection
