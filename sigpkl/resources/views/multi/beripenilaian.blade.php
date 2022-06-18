@extends('layout.main')

@section('title', 'Penilaian Siswa')

@section('isi')

@if (Auth::user()->is_industri == 1)
<div class="container">

  <div class="row justify-content-center">
    <div class="col-10">

      <h3>PENILAIAN SISWA</h3>

      @foreach ($magang as $mg)
      <div class="card text-left">
        <div class="card-body">
          <h4 class="card-title text-center">{{ $mg->nama }}</h4>
          <h6 class="card-subtitle mb-2 text-muted text-center">{{ $mg->kelas }} ({{ $mg->jurusan }})</h6>
          <hr>
          <form action="{{ route('nilai_penilaian') }}" method="post">
            @csrf
            <input type="hidden" name="nis" value="{{ $mg->nis }}">
            <input type="hidden" name="ids" value="{{ $scre->id }}">
            <div class="form-group row">
              <div class=" col-3">
                <label for="nisik">Nilai Sikap</label>
                <input type="text" class="form-control form-control-user" name="nisik" id="nisik"
                  placeholder="Masukkan Nilai..." value="{{ $scre->nisik_indu ?? old('nisik') }}">
              </div>
              <div class=" col-3">
                <label for="nidis">Nilai Kedisiplinan</label>
                <input type="text" class="form-control form-control-user" name="nidis" id="nidis"
                  placeholder="Masukkan Nilai..." value="{{ $scre->nidis_indu ?? old('nidis') }}">
              </div>
              <div class=" col-3">
                <label for="nitrm">Nilai Keterampilan</label>
                <input type="text" class="form-control form-control-user" name="nitrm" id="nitrm"
                  placeholder="Masukkan Nilai..." value="{{ $scre->nitrm_indu ?? old('nitrm') }}">
              </div>
              <div class=" col-3">
                <label for="niker">Nilai Kerapihan</label>
                <input type="text" class="form-control form-control-user" name="niker" id="niker"
                  placeholder="Masukkan Nilai..." value="{{ $scre->niker_indu ?? old('niker') }}">
              </div>
            </div>
            <button type="submit" class="btn btn-primary float-right">Beri Nilai</button>
            <a href="/penilaian" class=" btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
      @endforeach

    </div>
  </div>

</div>
@endif

@endsection