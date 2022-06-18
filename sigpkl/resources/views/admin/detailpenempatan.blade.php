@extends('layout.main')

@section('title', 'Detail Penempatan')

@section('isi')
<div class="container">
  <div class="row justify-content-center">
    <div class="col col-md-10">
      <h3>Detail Penempatan</h3>
      <div class="card">
        <div class="card-body">
          <form action="" method="post">
            @csrf
            @foreach ($penempatan as $tm)

            @endforeach
            <div class="form-group">
              <label for="nama_siswa">Nama Siswa</label>
              <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" value="{{ $tm->nama_siswa}}"
                disabled readonly>
              <span class="text-danger">@error('nama_siswa') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="jurusan_siswa">Jurusan</label>
              <input type="text" class="form-control" id="jurusan_siswa" name="jurusan_siswa" value="{{ $tm->jurusan}}"
                disabled readonly>
              <span class="text-danger">@error('jurusan_siswa') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="kelas_siswa">Kelas</label>
              <input type="text" class="form-control" id="kelas_siswa" name="kelas_siswa" value="{{ $tm->kelas}}"
                disabled readonly>
              <span class="text-danger">@error('kelas_siswa') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="guru">Guru Pembimbing</label>
              <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" value="{{ $tm->nama_guru}}"
                disabled readonly>
              <span class="text-danger">@error('guru') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="industri">Industri</label>
              <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" value="{{ $tm->nama_indu}}"
                disabled readonly>
              <span class="text-danger">@error('industri') {{ $message }} @enderror</span>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="mulai">Mulai Tanggal</label>
                <input type="date" class="form-control" id="mulai" name="mulai" value="{{ $placement->mulai}}" disabled
                  readonly>
                <span class="text-danger">@error('mulai') {{ $message }} @enderror</span>
              </div>
              <div class=" col-sm-6">
                <label for="sampai">Sampai Tanggal</label>
                <input type="date" class="form-control" id="sampai" name="sampai" value="{{ $placement->sampai}}"
                  disabled readonly>
                <span class="text-danger">@error('sampai') {{ $message }}
                  @enderror</span>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="masuk">Waktu Masuk</label>
                <input type="time" class="form-control" id="masuk" name="masuk" value="{{ $placement->waktu_masuk}}"
                  disabled readonly>
                <span class="text-danger">@error('masuk') {{ $message }} @enderror</span>
              </div>
              <div class=" col-sm-6">
                <label for="keluar">Waktu Keluar</label>
                <input type="time" class="form-control" id="keluar" name="keluar" value="{{ $placement->waktu_keluar}}"
                  disabled readonly>
                <span class="text-danger">@error('keluar') {{ $message }}
                  @enderror</span>
              </div>
            </div>
            <a href="{{route('kd_penempatan')}}" class="btn btn-secondary float-right">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection