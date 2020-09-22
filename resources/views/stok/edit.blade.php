@extends('tamplate.content')
@section('content')
<div class="content-wrapper">
    <section class="content">
          <div class="container-fluid">
            <div class="row">
              <!-- left column -->
              <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Update Stok Material</h3>
                  </div>
                  @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                  @endif
                  @if ($errors->any())
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif
                  <!-- /.card-header -->
                  <!-- form start -->
                  
                  
                  <form role="form" method="post" action="{{ route('stok.update',['id'=>$data['a']->id]) }}" enctype='multipart/form-data'>
                    @csrf
                  `<div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Nama Bahan</label>
                        <input type="text" value="{{ $data['a']->stokcol }}" name="stokcol" class="form-control" id="exampleInputPassword1" placeholder="Nama Produk">
                      </div>
                      <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control" name="kategori_stok_id">
                        @foreach($data['kategori'] as $a)
                            <option value="{{ $a->id }}"
                                @if($a->kategori_stokcol == $data['a']->kategori_stok->kategori_stokcol ) selected @endif
                            >{{ $a->kategori_stokcol }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Berat Jenis</label>
                        <input type="number" min="1" value="{{ $data['a']->berat }}" name="berat" class="form-control" id="exampleInputPassword1" placeholder="Berat">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Harga</label>
                        <input type="number" min="1" value="{{ $data['a']->harga }}" name="harga" class="form-control" id="exampleInputPassword1" placeholder="harga">
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
  
                </div>
                <!-- /.card -->
                </div>
                </div>
            </div>
    </section>
</div>
@endsection

