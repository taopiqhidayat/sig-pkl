@extends('layout/main')

@section('title', 'Edit Presentasi Saya')

@section('isi')

<div class="container">

  <div class="row justify-content-center">
    <div class="col-8 my-3">

      <h3>EDIT PRESENTASI SAYA</h3>

      <div class="card text-left mt-3">
        <div class="card-body">
          <form action="{{route('update_presentasi')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="filap">Pilih File</label>
              <input type="file" class="form-control" id="filap" name="filap" value="{{$presentation->presentasi}}">
              <span class="text-danger">@error('filap') {{ $message }} @enderror</span>
            </div>
            <button type="submit" class="btn btn-primary">Serahkan</button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

@endsection