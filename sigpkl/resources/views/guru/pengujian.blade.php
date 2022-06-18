@extends('layout/main')

@section('title', 'Pengujian Siswa')

@section('isi')

<div class="container">

  <div class="row justify-content-center">
    <div class="col-10">

      <h3>DATA PENGUJIAN</h3>

      @if ($data == 0)
      <div class="row mt-3">
        <div class="col">
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <div>
              <strong>Kosong!</strong> Belum ada siswa yang dibimbing dan diuji oleh Anda!!
            </div>
          </div>
        </div>
      </div>
      @else
      @foreach ($uji as $u)
      @php
      $ni1 = app('App\Http\Controllers\TestsController')->getni1($u->nis);
      $ni2 = app('App\Http\Controllers\TestsController')->getni2($u->nis);
      $laporan = app('App\Http\Controllers\TestsController')->getIdLaporan($u->nis);
      $presentasi = app('App\Http\Controllers\TestsController')->getIdPresentasi($u->nis);
      @endphp
      <div class="card text-left mt-2">
        <div class="card-body">
          <h4 class="card-title">{{ $u->nama }}</h4>
          <h6 class="card-subtitle mb-2 text-muted float-right">{{ $u->tanggal }} ({{ $u->waktu }})</h6>
          <h6 class="card-subtitle mb-2 text-muted">{{ $u->kelas }} ({{ $u->jurusan }})</h6>
          <a target="__blank" href="{{url('/lihat_laporan/'.$laporan)}}" class="badge badge-primary">Laporan</a>
          <a target="__blank" href="{{url('/lihat_ppt/'.$presentasi)}}" class="badge badge-primary">Dokumentasi
            Presentasi</a>
          <hr>
          <form action="{{route('nilai_pengujian')}}" method="post">
            @csrf
            <input type="hidden" name="nis" value="{{ $u->nis }}">
            <div class="row">
              <div class="col-5">
                <div class="form-group row">
                  <div class=" col-4 mt-1">
                    <label for="laporan">Nilai Laporan</label>
                  </div>
                  <div class=" col-8">
                    <input type="text" class="form-control form-control-user" id="laporan" name="laporan"
                      value="{{$ni1}}" placeholder="Masukkan Nilai...">
                    <span class="text-danger">@error('laporan') {{ $message }}
                      @enderror</span>
                  </div>
                </div>
              </div>
              <div class="col-5">
                <div class="form-group row">
                  <div class=" col-5 mt-1">
                    <label for="presentasi">Nilai Presentasi</label>
                  </div>
                  <div class=" col-7">
                    <input type="text" class="form-control form-control-user" id="presentasi" name="presentasi"
                      value="{{$ni2}}" placeholder="Masukkan Nilai...">
                    <span class="text-danger">@error('presentasi') {{ $message }}
                      @enderror</span>
                  </div>
                </div>
              </div>
              <div class="col-2">
                <button type="submit" class="btn btn-primary">Beri Nilai</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      @endforeach
      @endif


    </div>
  </div>

</div>

@endsection