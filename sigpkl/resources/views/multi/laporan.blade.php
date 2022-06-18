@extends('layout.main')

@section('title', 'Laporan')

@section('isi')

@if (Auth::user()->is_guru == 1)
<div class="container">

  <div class="row">
    <div class="col">

      <h3>DAFTAR LAPORAN SISWA</h3>

      <div class=" row">
        @if ($data >= 1)
        @foreach ($siswa as $s)
        @foreach ($laporan as $l)
        <?php
        $nis1 = $l->nis;
        $nis2 = $s->nis;
        $nama = app('App\Http\Controllers\ReportsController')->getNama($l->nis);
        $kelas = app('App\Http\Controllers\ReportsController')->getkelas($l->nis);
        ?>
        @if ($nis1 == $nis2)
        <div class=" col col-md-6">
          <div class="card text-left">
            <div class="card-body">
              <h4 class="card-title">{{ $l->judul }}</h4>
              <h5 class="card-subtitle mb-2">{{ $nama }} ({{ $kelas }})</h5>
              <h6 class="card-subtitle mb-2 text-muted">{{ $l->updated_at }}</h6>
              <a target="__blank" href="{{url('/lihat_laporan/'.$l->id)}}" class="badge badge-primary">
                Lihat File
              </a>
              <hr>
              <form action="{{route('respon_laporan')}}" method="post">
                @csrf
                <input type="hidden" name="nis" value="{{ $nis1 }}">
                <div class="form-group">
                  <label for="kritik">Respon</label>
                  <input type="text" class="form-control form-control-user" id="kritik" name="kritik"
                    placeholder="Masukkan kritik, saran atau tanggapan dari laporan..." value="{{ $l->respon }}">
                  <span class="text-danger">@error('kritik') {{ $message }} @enderror</span>
                </div>
                <button type="submit" class=" btn btn-primary">Kirim Tanggapan</button>
              </form>
            </div>
          </div>
        </div>
        @endif
        @endforeach
        @endforeach
        @else
        <div class="row mt-3">
          <div class="col col-md-6">
            <div class="alert alert-danger d-flex align-items-center" role="alert">
              <div>
                <strong>Kosong!</strong> Belum ada siswa yang mengirim laporan!!
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>

    </div>
  </div>
</div>
@endif

@if (Auth::user()->is_siswa == 1)
<div class="container">

  <div class="row justify-content-center">
    <div class="col-8 my-3">

      <h3>LAPORAN SAYA</h3>

      @if ($data == 0)
      <div class="card text-left mt-3">
        <div class="card-body">
          <form action="{{route('store_laporan')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="judul">Judul Laporan</label>
              <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan Judul Laporan...">
              <span class="text-danger">@error('judul') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="filap">Pilih File</label>
              <input type="file" class="form-control" id="filap" name="filap">
              <span class="text-danger">@error('file') {{ $message }} @enderror</span>
            </div>
            <button type="submit" class="btn btn-primary">Upload File</button>
          </form>
        </div>
      </div>
      @else
      <div class="card text-left">
        <div class="card-body">
          <h4 class="card-title">{{ $laporan->judul }}</h4>
          <h6 class="card-subtitle mb-2 text-muted">{{ $laporan->updated_at }}</h6>
          <p class="card-text">Tanggapan: {{ $laporan->respon }}</p>
          <a href="/edit_laporan/{{$laporan->id}}" class="btn btn-warning">Edit</a>
        </div>
      </div>
      @endif

    </div>
  </div>
</div>
@endif

@endsection