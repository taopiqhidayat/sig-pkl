@extends('layout.main')

@section('title', 'Detail Pengajuan Siswa')

@section('isi')
<div class="container">
  <div class="row">
    <div class="col col-md-6">
      <h3>DETAIL PENGAJUAN SISWA</h3>
      <div class="card">
        <div class="card-body">
          <h5>{{ $industri->nama }}</h5>
          <small>{{ $industri->alamat }}</small>
          <hr>
          <ol>
            @foreach ($siswa as $sw)
            <li>{{$sw->kelas}} | {{$sw->nama}}</li>
            @endforeach
          </ol>
          <a target="__blank" href="/print_ajuan_saya/{{$industri->id}}" class=" btn btn-primary">Print</a>
          <a target="__blank" href="/print_balasan_saya/{{$industri->id}}" class=" btn btn-primary">Balasan</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection