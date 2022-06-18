@extends('layout/main')

@section('title', 'Kunjungan Industri')

@section('isi')

<div class="container">

  <div class="row justify-content-center">
    <div class="col">

      <h3>DATA KUNJUNGAN</h3>

      @if (Auth::user()->is_guru == 1)
      <a href="{{route('tbh_kunjungan')}}" class="btn btn-primary my-1">Tambah Laporan Kunjungan</a>
      @endif

      @if ($data == 0)
      <div class="row mt-3">
        <div class="col">
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <div>
              <strong>Kosong!</strong> Belum ada siswa yang dibimbing oleh Anda!!
            </div>
          </div>
        </div>
      </div>
      @else
      @foreach ($kunjung as $k)
      <div class=" row">
        <div class=" col col-md-3">
          <div class="card text-left mt-2">
            <div class="card-body">
              <h4 class="card-title">{{ $k->nama }}</h4>
              <h6 class="card-subtitle mb-2 text-muted">{{ $k->created_at }}</h6>
              <a href="/detail_kunjungan/{{$k->id}}" class="card-link">Detail</a>
              @if (Auth::user()->is_guru == 1)
              <a href="/edit_kunjungan/{{$k->id}}" class="card-link">Edit</a>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endforeach
      @endif

    </div>
  </div>

</div>

@endsection