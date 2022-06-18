@extends('layout/main')

@section('title', 'Presentasi Saya')

@section('isi')

<div class="container">

  <div class="row justify-content-center">
    <div class="col col-md-8 my-3">

      <h3>PRESENTASI SAYA</h3>

      @if ($data == 0)
      <div class="card text-left mt-3">
        <div class="card-body">
          <form action="{{route('store_presentasi')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="filap">Pilih File</label>
              <input type="file" class="form-control" id="filap" name="filap">
              <span class="text-danger">@error('filap') {{ $message }} @enderror</span>
            </div>
            <button type="submit" class="btn btn-primary">Serahkan</button>
          </form>
        </div>
      </div>
      @else
      <div class="card text-left">
        <div class="card-body">
          <h4 class="card-title">{{$judul->judul}}</h4>
          <h6 class="card-subtitle mb-2 text-muted">{{$presentasi->updated_at}}</h6>
          <a href="/edit_presentasi/{{$presentasi->id}}" class="btn btn-warning">Edit</a>
        </div>
      </div>
      @endif

    </div>
  </div>
</div>

@endsection