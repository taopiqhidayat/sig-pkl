@extends('layout/main')

@section('title', 'Edit Nilai')

@section('isi')

<div class="container">

  <div class="row justify-content-center">
    <div class="col-sm-6 col-md-8">

      <h3 class=" text-uppercase">Edit NILAI</h3>

      <form action="{{ route('update_nilai') }}" method="post">
        @csrf
        <div class=" card">
          <div class=" card-body">
            <h5 class=" card-title">{{ $siswa->nama }}</h5>
            <h6 class=" card-subtitle">{{ $siswa->kelas }} ({{ $siswa->jurusan }})</h6>
            <hr>
            <input type="hidden" name="nis" id="nis" value="{{ $siswa->nis }}">
            <div class=" form-group row">
              <div class=" col-6">
                <label for="nilai_absensi">Nilai Absensi</label>
                <input class=" form-control" type="text" name="nilai_absensi" id="nilai_absensi"
                  value="{{ $nilai->nilai_absensi ?? old('nilai_absensi') }}">
                <span class="text-danger">@error('nilai_absensi') {{ $message }} @enderror</span>
              </div>
              <div class=" col-6">
                <label for="nilai_tugas">Nilai Tugas</label>
                <input class=" form-control" type="text" name="nilai_tugas" id="nilai_tugas"
                  value="{{ $nilai->nilai_tugas ?? old('nilai_tugas') }}">
                <span class="text-danger">@error('nilai_tugas') {{ $message }} @enderror</span>
              </div>
            </div>
            <div class=" form-group row">
              <div class=" col-6">
                <label for="nilai_laporan">Nilai Laporan</label>
                <input class=" form-control" type="text" name="nilai_laporan" id="nilai_laporan"
                  value="{{ $nilai->nilai_laporan ?? old('nilai_laporan') }}">
                <span class="text-danger">@error('nilai_laporan') {{ $message }} @enderror</span>
              </div>
              <div class=" col-6">
                <label for="nilai_presentasi">Nilai Presentasi</label>
                <input class=" form-control" type="text" name="nilai_presentasi" id="nilai_presentasi"
                  value="{{ $nilai->nilai_presentasi ?? old('nilai_presentasi') }}">
                <span class="text-danger">@error('nilai_presentasi') {{ $message }} @enderror</span>
              </div>
            </div>
            <div class=" form-group row">
              <div class=" col-6">
                <label for="nisik">Nilai Sikap</label>
                <input class=" form-control" type="text" name="nisik" id="nisik"
                  value="{{ $nilai->nisik_indu ?? old('nisik') }}">
                <span class="text-danger">@error('nisik') {{ $message }} @enderror</span>
              </div>
              <div class=" col-6">
                <label for="nidis">Nilai Disiplin</label>
                <input class=" form-control" type="text" name="nidis" id="nidis"
                  value="{{ $nilai->nidis_indu ?? old('nidis') }}">
                <span class="text-danger">@error('nidis') {{ $message }} @enderror</span>
              </div>
            </div>
            <div class=" form-group row">
              <div class=" col-6">
                <label for="nitrm">Nilai Keterampilan</label>
                <input class=" form-control" type="text" name="nitrm" id="nitrm"
                  value="{{ $nilai->nitrm_indu ?? old('nitrm') }}">
                <span class="text-danger">@error('nitrm') {{ $message }} @enderror</span>
              </div>
              <div class=" col-6">
                <label for="niker">Nilai Kerapihan</label>
                <input class=" form-control" type="text" name="niker" id="niker"
                  value="{{ $nilai->niker_indu ?? old('niker') }}">
                <span class="text-danger">@error('niker') {{ $message }} @enderror</span>
              </div>
            </div>
            <a href="{{ route('lapnil') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

@endsection