@extends('layout.main')

@section('title', 'Detail Guru')

@section('isi')
<div class="container">
  <div class="row justify-content-center">
    <div class="col col-md-10">
      <h3>Detail Guru</h3>
      <div class="card">
        <div class="card-body">
          <div class="row g-0">
            <div class="col col-md-6">
              <form action="" method="post">
                @csrf
                <div class="form-group">
                  <label for="ni">Nomor Induk</label>
                  <input type="text" class="form-control" id="ni" name="ni" value="{{ $teacher->n_induk }}" disabled
                    readonly>
                  <span class="text-danger">@error('ni') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="nama_guru">Nama Lengkap</label>
                  <input type="text" class="form-control" id="nama_guru" name="nama_guru" value="{{ $teacher->nama }}"
                    disabled readonly>
                  <span class="text-danger">@error('nama_guru') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="jk_guru">Jenis Kelamin</label>
                  <input type="text" class="form-control" id="jk_guru" name="jk_guru" value="{{ $teacher->jk }}"
                    disabled readonly>
                  <span class="text-danger">@error('jk_guru') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="jurusan_guru">Jurusan</label>
                  <input type="text" class="form-control" id="jurusan_guru" name="jurusan_guru"
                    value="{{ $teacher->jurusan }}" disabled readonly>
                  <span class="text-danger">@error('jurusan_guru') {{ $message }} @enderror</span>
                </div>
            </div>
            <div class="col col-md-6">
              <div class="form-group">
                <label for="provinsi_guru">Provinsi</label>
                <input type="text" class="form-control" id="provinsi_guru" name="provinsi_guru"
                  value="{{ $teacher->provinsi }}" disabled readonly>
                <span class="text-danger">@error('provinsi_guru') {{ $message }}
                  @enderror</span>
              </div>
              <div class="form-group">
                <label for="kota_guru">Kota</label>
                <input type="text" class="form-control" id="kota_guru" name="kota_guru" value="{{ $teacher->kota }}"
                  disabled readonly>
                <span class="text-danger">@error('kota_guru') {{ $message }}
                  @enderror</span>
              </div>
              <div class="form-group">
                <label for="email_guru">Alamat Email</label>
                <input type="email" class="form-control" id="email_guru" name="email_guru" value="{{ $teacher->email }}"
                  disabled readonly>
                <span class="text-danger">@error('email_guru') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="n_wa_guru">No HP</label>
                <input type="text" class="form-control" id="n_wa_guru" name="n_wa_guru" value="{{ $teacher->n_wa }}"
                  disabled readonly>
                <span class="text-danger">@error('n_wa_guru') {{ $message }} @enderror</span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="alamat_guru">Alamat</label>
            <input type="text" class="form-control" id="alamat_guru" name="alamat_guru" value="{{ $teacher->alamat }}"
              disabled readonly>
            <span class="text-danger">@error('alamat_guru') {{ $message }} @enderror</span>
          </div>
          <a href="{{route('kd_guru')}}" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection