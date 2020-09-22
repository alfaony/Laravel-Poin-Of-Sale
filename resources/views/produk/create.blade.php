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
                    <h3 class="card-title">Membuat Produk</h3>
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
                  <form role="form" method="post" action="{{ route('produk.store') }}" enctype='multipart/form-data'>
                    @csrf 
                  `<div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Kode Produk</label>
                        <input type="number" min="1" name="kode" class="form-control" id="exampleInputEmail1" placeholder="Kode Produk">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Nama</label>
                        <input type="text" name="name" class="form-control" id="exampleInputPassword1" placeholder="Nama Produk">
                      </div>
                      <div class="form-group">
                        <label>Kategori</label> 
                        <select class="form-control" name="categori_id">
                        @forelse($categori as $raw)
                          <option value="{{ $raw->id }}">{{ $raw->name }}</option>
                            @empty
                          <div>
                            DATA KATEGORI KOSONG
                          </div>
                          <a href="{{ url('/kategori') }}" class="form-control">Buat Kategori</a>
                          @endforelse
                        </select>
                        

                        
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFile">Foto</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="foto" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text" id="">Foto</span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control" id="exampleInputEmail1">
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

