@extends('layout.main')

@section('title', 'Laporan')

@section('isi')

@if (Auth::user()->is_siswa == 1)
<div class="container">

  <div class="row justify-content-center">
    <div class="col-8 my-3">

      <h3>EDIT LAPORAN SAYA</h3>

      <div class="card text-left mt-3">
        <div class="card-body">
          <form action="{{route('edit_laporan')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="idr" value="{{$report->id}}">
            <div class="form-group">
              <label for="judul">Judul Laporan</label>
              <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan Judul Laporan..."
                value="{{$report->judul}}">
              <span class="text-danger">@error('judul') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="filap">Pilih File</label>
              <input type="file" class="form-control" id="filap" name="filap" value="{{$report->laporan}}">
              <span class="text-danger">@error('filap') {{ $message }} @enderror</span>
            </div>
            <button type="submit" class="btn btn-primary">Serahkan</button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endif

@endsection