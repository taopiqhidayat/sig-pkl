@extends('layout/main')

@section('title', 'Detail Kunjungan')

@section('isi')

<div class="container">

  <div class="row justify-content-center">
    <div class="col-8">

      <h3>DETAIL KUNJUNGAN</h3>

      <div class="card text-left">
        <div class="card-body">
          <h5 class=" card-title">Kunjungan ke: {{ $indu->nama}}</h5>
          <div class=" row mb-3">
            <div class=" col-3">Kondisi Siswa:</div>
            <div class=" col-9">
              {{ $visit->kondisi_siswa}}
            </div>
          </div>
          <div class=" row mb-3">
            <div class=" col-3">Kondisi Industri:</div>
            <div class=" col-9">
              {{ $visit->kondisi_industri}}
            </div>
          </div>
          <div class=" row mb-3">
            <div class=" col-3">Keluhan Siswa:</div>
            <div class=" col-9">
              {{ $visit->keluhan_siswa}}
            </div>
          </div>
          <div class=" row mb-3">
            <div class=" col-3">Keluhan Industri:</div>
            <div class=" col-9">
              {{ $visit->keluhan_industri}}
            </div>
          </div>
          <div class=" row mb-3">
            <div class=" col-3">Kinerja Siswa</div>
            <div class=" col-9">
              {{ $visit->kinerja_siswa}}
            </div>
          </div>
          <a href="{{ route('kunjungan') }}" class="btn btn-secondary">Kembali</a>
        </div>
      </div>

    </div>
  </div>

</div>

@endsection