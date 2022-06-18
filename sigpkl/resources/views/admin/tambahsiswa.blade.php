@extends('layout.main')

@section('title', 'Tambah Siswa')

@section('isi')
<div class="container">
  <div class="row justify-content-center">
    <div class="col col-md-10">
      <h3>TAMBAH SISWA</h3>
      <div class="card">
        <div class="card-body">
          <div class="row g-0">
            <div class="col col-md-6">
              <form action="{{ route('store_siswa') }}" method="post">
                @csrf
                <div class="form-group">
                  <label for="nis">Nomor Induk Siswa</label>
                  <input type="text" class="form-control" id="nis" name="nis"
                    placeholder="Masukkan Nomor Induk Siswa Anda ..." value="{{ old('nis') }}">
                  <span class="text-danger">@error('nis') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="nama">Nama Lengkap</label>
                  <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Anda ..."
                    value="{{ old('nama') }}">
                  <span class="text-danger">@error('nama') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="jk">Jenis Kelamin</label>
                  <select class="form-control form-select form-select-md" name="jk" id="jk">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki - laki">Laki - laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                  <span class="text-danger">@error('jk') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="jurusan">Jurusan</label>
                  <select class="form-control form-select form-select-md" name="jurusan" id="jurusan">
                    <option value="">Pilih Jurusan</option>
                    @foreach( $jurusan as $data )
                    <option value="{{ $data->jurusan }}">{{ $data->jurusan }}</option>
                    @endforeach
                  </select>
                  <span class="text-danger">@error('jurusan') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="kelas">Kelas</label>
                  <select class="form-control form-select form-select-md" name="kelas" id="kelas">
                    <option value="">Pilih Kelas</option>
                    @foreach( $kelas as $data )
                    <option value="{{ $data->kelas }}">{{ $data->kelas }}</option>
                    @endforeach
                  </select>
                  <span class="text-danger">@error('kelas') {{ $message }} @enderror</span>
                </div>
            </div>
            <div class="col col-md-6">
              <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <select class="form-control form-select form-select-md" name="provinsi" id="provinsi">
                  <option value="">Pilih Provinsi</option>
                  @foreach( $provinsi as $data )
                  <option value="{{ $data->provinsi }}">{{ $data->provinsi }}</option>
                  @endforeach
                </select>
                <span class="text-danger">@error('provinsi') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="kota">Kabupaten/Kota</label>
                <select class="form-control form-select form-select-md" name="kota" id="kota"
                  data-dependent="kecamatan">
                  <option value="">Pilih Kabupaten/Kota</option>
                  @foreach( $kota as $data )
                  <option value="{{ $data->jk }} {{ $data->kota }}">{{ $data->kota }}
                    ({{ $data->jk }} {{ $data->kota }})</option>
                  @endforeach
                </select>
                <span class="text-danger">@error('kota') {{ $message }} @enderror</span>
                {{-- <div id="loading" style="margin-top: 15px;">
                      <img src="/images/loading.gif" width="18"> <small>Loading...</small>
                  </div> --}}
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Dimana Alamat Anda ..."
                  value="{{ old('alamat') }}">
                <span class="text-danger">@error('alamat') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan Email Anda ..."
                  value="{{ old('email') }}">
                <span class="text-danger">@error('email') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="n_wa">No HP</label>
                <input type="text" class="form-control" name="n_wa" id="n_wa" placeholder="Masukkan No HP Anda ..."
                  value="{{ old('n_wa') }}">
                <span class="text-danger">@error('n_wa') {{ $message }} @enderror</span>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Tambah</button>
          <a href="{{ route('kd_siswa') }}" class="btn btn-secondary float-right">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection