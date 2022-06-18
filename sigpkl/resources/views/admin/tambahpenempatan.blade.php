@extends('layout.main')

@section('title', 'Tambah Penempatan')

@section('isi')
<div class="container">
  <div class="row justify-content-center">
    <div class="col col-md-10">
      <h3>TAMBAH PENEMPATAN</h3>
      <div class="card">
        <div class="card-body">
          <form action="{{ route('store_penempatan') }}" method="post">
            @csrf
            <div class="form-group">
              <label for="siswa">Siswa</label>
              <select class="form-control form-select form-select-md" name="siswa" id="siswa">
                <option value="">Pilih Siswa</option>
                @foreach( $siswa as $data )
                <option value="{{ $data->nis }}">{{ $data->kelas }} | {{ $data->nama }}</option>
                @endforeach
              </select>
              <span class="text-danger">@error('siswa') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="guru">Guru Pembimbing</label>
              <select class="form-control form-select form-select-md" name="guru" id="guru">
                <option value="">Pilih Guru Pembimbing</option>
                @foreach( $guru as $data )
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
                <option value="{{ $data->id }}">{{ $data->nama }}</option>
                @endforeach
              </select>
              <span class="text-danger">@error('industri') {{ $message }} @enderror</span>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="mulai">Mulai Tanggal</label>
                <input type="date" class="form-control" id="mulai" name="mulai" placeholder="mulai"
                  value="{{ old('mulai') ?? $sch->pkl_mulai}}">
                <span class="text-danger">@error('mulai') {{ $message }} @enderror</span>
              </div>
              <div class=" col-sm-6">
                <label for="sampai">Sampai Tanggal</label>
                <input type="date" class="form-control" id="sampai" name="sampai" placeholder="sampai"
                  value="{{ old('sampai') ?? $sch->pkl_sampai}}">
                <span class="text-danger">@error('sampai') {{ $message }}
                  @enderror</span>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="masuk">Waktu Masuk</label>
                <input type="time" class="form-control" id="masuk" name="masuk" placeholder="masuk"
                  value="{{ old('masuk')}}">
                <span class="text-danger">@error('masuk') {{ $message }} @enderror</span>
              </div>
              <div class=" col-sm-6">
                <label for="keluar">Waktu Keluar</label>
                <input type="time" class="form-control" id="keluar" name="keluar" placeholder="keluar"
                  value="{{ old('keluar')}}">
                <span class="text-danger">@error('keluar') {{ $message }}
                  @enderror</span>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
            <a href="{{route('kd_penempatan')}}" class="btn btn-secondary float-right">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection