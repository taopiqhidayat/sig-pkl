@extends('layout.main')

@section('title', 'Detail Siswa')

@section('isi')
<div class="container">
  <div class="row justify-content-center">
    <div class="col col-md-10">
      <h3>Detail Siswa</h3>
      <div class="card">
        <div class="card-body">
          <div class="row g-0">
            <div class="col col-md-6">
              <form action="" method="post">
                @csrf
                <div class="form-group">
                  <label for="nis">Nomor Induk Siswa</label>
                  <input type="text" class="form-control" id="nis" name="nis" value="{{ $student->nis }}" disabled
                    readonly>
                  <span class="text-danger">@error('nis') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="nama">Nama Lengkap</label>
                  <input type="text" class="form-control" id="nama" name="nama" value="{{ $student->nama }}" disabled
                    readonly>
                  <span class="text-danger">@error('nama') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="jk">Jenis Kelamin</label>
                  <input type="text" class="form-control" id="jk" name="jk" value="{{ $student->jk }}" disabled
                    readonly>
                  <span class="text-danger">@error('jk') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="jurusan">Jurusan</label>
                  <input type="text" class="form-control" id="jurusan" name="jurusan" value="{{ $student->jurusan }}"
                    disabled readonly>
                  <span class="text-danger">@error('jurusan') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="kelas">Kelas</label>
                  <input type="text" class="form-control" id="kelas" name="kelas" value="{{ $student->kelas }}" disabled
                    readonly>
                  <span class="text-danger">@error('kelas') {{ $message }} @enderror</span>
                </div>
            </div>
            <div class="col col-md-6">
              <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{ $student->provinsi }}"
                  disabled readonly>
                <span class="text-danger">@error('provinsi') {{ $message }}
                  @enderror</span>
              </div>
              <div class="form-group">
                <label for="kota">Kota</label>
                <input type="text" class="form-control" id="kota" name="kota" value="{{ $student->kota }}" disabled
                  readonly>
                <span class="text-danger">@error('kota') {{ $message }}
                  @enderror</span>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" name="alamat" id="alamat" value="{{ $student->alamat }}"
                  disabled readonly>
                <span class="text-danger">@error('alamat') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ $student->email }}" disabled
                  readonly>
                <span class="text-danger">@error('email') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="n_wa">No HP</label>
                <input type="text" class="form-control" name="n_wa" id="n_wa" value="{{ $student->n_wa }}" disabled
                  readonly>
                <span class="text-danger">@error('n_wa') {{ $message }} @enderror</span>
              </div>
            </div>
          </div>
          <a href="{{route('kd_siswa')}}" class="btn btn-secondary">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection