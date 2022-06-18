@extends('layout.main')

@section('title', 'Penilaian Siswa')

@section('isi')

@if (Auth::user()->is_industri == 1)
<div class="container">

  <div class="row justify-content-center">
    <div class="col">

      <h3>PENILAIAN SISWA</h3>

      @if ($data == 0)
      <div class="row mt-3">
        <div class="col col-md-6">
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <div>
              <strong>Kosong!</strong> Belum ada yang terdaftar magang di tempat Anda!!
            </div>
          </div>
        </div>
      </div>
      @else
      <div class=" row">
        @foreach ($magang as $mg)
        <div class=" col col-md-6">
          <div class="card text-left">
            <div class="card-body">
              @foreach ($scre as $sc)
              @if ($mg->nis == $sc->nis && $sc->nilai_pemlapangan == null)
              <span class=" text-danger float-right">Belum Diberi Nilai</span>
              @elseif ($mg->nis == $sc->nis && $sc->nilai_pemlapangan != null)
              <span class=" text-danger float-right">Nilai: {{$sc->nilai_pemlapangan}}</span>
              @endif
              @endforeach
              <h4 class="card-title">{{ $mg->nama }}</h4>
              <h6 class="card-subtitle mb-2 text-muted">{{ $mg->kelas }} ({{ $mg->jurusan }})</h6>
              <a href="/beri_penilaian/{{ $mg->id_user }}" class=" card-link badge badge-primary">Beri Nilai</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @endif

    </div>
  </div>

</div>
@endif

@endsection