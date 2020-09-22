@extends('front.tamplate')
@section('content')
<section class="header-main">
	<div class="container">
	<div class="row align-items-center">
	<div class="col-lg-3">
	<div class="brand-wrap">
		<h2 class="logo-text">BARISTA</h2>
	</div> <!-- brand-wrap.// -->
	</div>
	<div class="col-lg-3 col-sm-6">
		<div class="widgets-wrap d-flex justify-content-end">
			<div class="widget-header">
				<a href="" class="icontext">
					<a href="{{ route('barista.layout') }}" class="btn btn-primary m-btn m-btn--icon m-btn--icon-only">
															<i class="fa fa-home"></i>
														</a>
					</a>
			</div> <!-- widget .// -->
		</div>	<!-- widgets-wrap.// -->	
	</div> <!-- col.// -->
</div> <!-- row.// -->
	</div> <!-- container.// -->
</section>
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
@endsection
@section('footer')
    <!-- DataTables -->
    <script src="{{ asset('tamplate/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('tamplate/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script>
    $(function () {
      $('#dataTable').DataTable();
    });
</script>
@endsection