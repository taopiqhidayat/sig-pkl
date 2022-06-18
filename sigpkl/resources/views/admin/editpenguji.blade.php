@extends('layout.main')

@section('title', 'Edit Penguji')

@section('isi')
<div class="container">
  <div class="row justify-content-center">
    <div class="col col-md-8">
      <h3>EDIT PENGUJI</h3>
      <div class="card">
        <div class="card-body">
          <form action="{{route('update_penguji')}}" method="post">
            @csrf
            <input type="hidden" name="nis" value="{{ $siswa->nis }}">
            <div class="form-group row">
              <div class=" col-6">
                <label for="nis">Nomor Induk Siswa</label>
                <input type="text" class="form-control" id="nis" name="nis"
                  placeholder="Masukkan Nomor Induk Siswa Anda ..." value="{{ $siswa->nis }}" disabled>
                <span class="text-danger">@error('nis') {{ $message }} @enderror</span>
              </div>
              <div class=" col-6">
                <label for="nama">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Anda ..."
                  value="{{ $siswa->nama }}" disabled>
                <span class="text-danger">@error('nama') {{ $message }} @enderror</span>
              </div>
            </div>
            <div class="form-group row">
              <div class=" col-6">
                <label for="jurusan">Jurusan</label>
                <input type="text" class="form-control" id="jurusan" name="jurusan"
                  placeholder="Masukkan Jurusan Anda ..." value="{{ $siswa->jurusan }}" disabled>
                <span class="text-danger">@error('jurusan') {{ $message }} @enderror</span>
              </div>
              <div class=" col-6">
                <label for="kelas">Kelas</label>
                <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Masukkan Kelas Anda ..."
                  value="{{ $siswa->kelas }}" disabled>
                <span class="text-danger">@error('kelas') {{ $message }} @enderror</span>
              </div>
            </div>
            <div class="form-group row">
              <div class=" col-6">
                <label for="pembimbing">Pennguji 1</label>
                <input type="text" class="form-control" id="pembimbing" name="pembimbing"
                  placeholder="Masukkan Pembimbing Anda ..." value="{{ $bimbing->nama ?? old('pembimbing') }}">
                <span class="text-danger">@error('pembimbing') {{ $message }} @enderror</span>
              </div>
              <div class=" col-6">
                <label for="penguji">Penguji 2</label>
                <select class="form-control form-select form-select-md" name="penguji" id="penguji">
                  @foreach( $guru as $data )
                  @if ($test->penguji == $data->n_induk)
                  <option value="{{ $test->penguji }}" selected>{{ $uji->jurusan }} | {{ $uji->nama }}</option>
                  @else
                  <option value="{{ $data->n_induk }}">{{ $data->jurusan }} | {{ $data->nama }}</option>
                  @endif
                  @endforeach
                </select>
                <span class="text-danger">@error('penguji') {{ $message }} @enderror</span>
              </div>
            </div>
            <div class="form-group row">
              <div class=" col-6">
                <label for="tanggal">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal"
                  placeholder="Masukkan Tanggal Anda ..." value="{{ $test->tanggal ?? old('tanggal') }}">
                <span class="text-danger">@error('tanggal') {{ $message }} @enderror</span>
              </div>
              <div class=" col-6">
                <label for="waktu">Waktu</label>
                <input type="time" class="form-control" id="waktu" name="waktu" placeholder="Masukkan Waktu Anda ..."
                  value="{{ $test->waktu ?? old('waktu') }}">
                <span class="text-danger">@error('waktu') {{ $message }} @enderror</span>
              </div>
            </div>
            <button type="submit" class=" btn btn-warning">Edit</button>
            <a href="{{ route('penentuan_penguji') }}" class=" btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection