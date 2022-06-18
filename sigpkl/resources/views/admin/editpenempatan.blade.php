@extends('layout.main')

@section('title', 'Edit Penempatan')

@section('isi')
<div class="container">
  <div class="row justify-content-center">
    <div class="col col-md-10">
      <h3>EDIT PENEMPATAN</h3>
      <div class="card">
        <div class="card-body">
          <form action="{{ route('update_penempatan') }}" method="post">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $placement->id }}">
            <div class="form-group">
              <label for="siswa">Siswa</label>
              <input type="text" class="form-control" id="siswa" name="siswa"
                value="{{ $siswa->jurusan .' '. $siswa->kelas .' | '. $siswa->nama}}" disabled>
              <span class="text-danger">@error('siswa') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="guru">Guru Pembimbing</label>
              <select class="form-control form-select form-select-md" name="guru" id="guru">
                <option value="">Pilih Guru Pembimbing</option>
                @foreach( $guru as $data )
                @if ($data->n_induk == $awal_guru->n_induk)
                <option value="{{ $awal_guru->n_induk }}" selected>{{$awal_guru->jurusan}} | {{ $awal_guru->nama }}
                </option>
                @endif
                <option value="{{ $data->n_induk }}">{{$data->jurusan}} | {{ $data->nama }}</option>
                @endforeach
              </select>
              <span class="text-danger">@error('guru') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="industri">Industri</label>
              <select class="form-control form-select form-select-md" name="industri" id="industri">
                <option value="">Pilih Industri</option>
                @foreach( $industri as $data )
                @if ($data->id == $awal_industri->id)
                <option value="{{ $awal_industri->id }}" selected>{{ $awal_industri->nama }}</option>
                @endif
                <option value="{{ $data->id }}">{{ $data->nama }}</option>
                @endforeach
              </select>
              <span class="text-danger">@error('industri') {{ $message }} @enderror</span>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="mulai">Mulai Tanggal</label>
                <input type="date" class="form-control" id="mulai" name="mulai" placeholder="mulai"
                  value="{{ $placement->mulai ?? old('mulai') }}">
                <span class="text-danger">@error('mulai') {{ $message }} @enderror</span>
              </div>
              <div class=" col-sm-6">
                <label for="sampai">Sampai Tanggal</label>
                <input type="date" class="form-control" id="sampai" name="sampai" placeholder="sampai"
                  value="{{ $placement->sampai ?? old('sampai') }}">
                <span class="text-danger">@error('sampai') {{ $message }}
                  @enderror</span>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="masuk">Waktu Masuk</label>
                <input type="time" class="form-control" id="masuk" name="masuk" placeholder="masuk"
                  value="{{ $placement->waktu_masuk ?? old('masuk') }}">
                <span class="text-danger">@error('masuk') {{ $message }} @enderror</span>
              </div>
              <div class=" col-sm-6">
                <label for="keluar">Waktu Keluar</label>
                <input type="time" class="form-control" id="keluar" name="keluar" placeholder="keluar"
                  value="{{ $placement->waktu_keluar ?? old('keluar') }}">
                <span class="text-danger">@error('keluar') {{ $message }}
                  @enderror</span>
              </div>
            </div>
            <button type="submit" class="btn btn-warning">Edit</button>
            <a href="{{route('kd_penempatan')}}" class="btn btn-secondary float-right">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection