@extends('tamplate.content')
@section('content')


<div class="content-wrapper">
    <div class="content-header">
        <form method="post" action="{{route('option.store')}}">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1">Channel Secret</label>
            <input type="text" class="form-control" name ="channel_secret" id="exampleFormControlInput1" value="@if($data != null){{$data['channel_secret']}}@endif" placeholder="channel_secret">
        </div>
        
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Channel Access Token</label>
            <textarea class="form-control" name ="channel_access_token" id="exampleFormControlTextarea1" rows="3 ">@if($data != null){{$data['channel_access_token']}}@endif</textarea>
        </div>
        <td colspan="3">
            <button class="btn btn-primary btn-sm">Tambahkan</button>
        </td>
        </form>
    </div>
    </div>
@endsection