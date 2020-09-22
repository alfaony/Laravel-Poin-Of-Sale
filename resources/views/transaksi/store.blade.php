@extends('tamplate.content')
@section('content')
    <!-- Main content -->
    <div class="content-wrapper">
    <section class="content">
      <div class="row">
        
        <div class="col-md-8">
          <div class="card">
            <!-- /.card-header -->
            <div class="col-md-10">
            
              <div class="card-header">
                <h3 class="card-title">Tanggal Transaksi</h3>
              </div>
              <div class="card-body">
                <!-- Date range -->
                <form action="{{ route('transaksi.store') }}" method="post">
                  @csrf
                  <div class="form-group">
                  <label>Date range:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" name="date" class="form-control float-right" id="make">
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
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
@endsection
@section('footer')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script>
$(function () {
    //Initialize Select2 Elements
    //Date range picker
    $('#make').datepicker({
        format: 'yyyy-mm-dd',
        endDate: 'd'
    });
});
</script>



@endsection
