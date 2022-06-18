@extends('layout.main')

@section('title', 'Pengajuan Siswa')

@section('isi')
<div class="container">
  <h3>DAFTAR PENGAJUAN SISWA</h3>
  <div class="row">
    @foreach ($ajuan as $aju)
    <div class="col col-md-6">
      <div class="card mt-2">
        <div class="card-body row">
          <div class="col col-10">
            <h5 class=" card-title">
              {{ $aju->nama }}
            </h5>
            <hr>
            {{ $aju->alamat }}
          </div>
          <div class="col col-2">
            <a href="/detail_pengajuan/{{ $aju->id }}" class=" btn btn-info">Detail</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection