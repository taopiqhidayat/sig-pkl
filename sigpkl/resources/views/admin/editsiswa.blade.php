@extends('layout.main')

@section('title', 'Edit Siswa')

@section('isi')
<div class="container">
  <div class="row justify-content-center">
    <div class="col col-md-10">
      <h3>EDIT SISWA</h3>
      <div class="card">
        <div class="card-body">
          <div class="row g-0">
            <div class="col col-md-6">
              <form action="{{ route('update_siswa') }}" method="post">
                @csrf
                <input type="hidden" name="ids" id="ids" value="{{ $student->id_user }}">
                <div class="form-group">
                  <label for="nis">Nomor Induk Siswa</label>
                  <input type="text" class="form-control" id="nis" name="nis" value="{{ $student->nis ?? old('nis') }}">
                  <span class="text-danger">@error('nis') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="nama">Nama Lengkap</label>
                  <input type="text" class="form-control" id="nama" name="nama"
                    value="{{ $student->nama ?? old('nama') }}">
                  <span class="text-danger">@error('nama') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="jk">Jenis Kelamin</label>
                  <select class="form-control form-select form-select-md" name="jk" id="jk">
                    @if ($student->jk)
                    <option value="{{ $student->jk }}" selected>{{ $student->jk }}</option>
                    @endif
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki - laki">Laki - laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                  <span class="text-danger">@error('jk') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="jurusan">Jurusan</label>
                  <select class="form-control form-select form-select-md" name="jurusan" id="jurusan">
                    @foreach( $jurusan as $data )
                    @if ($student->jurusan)
                    <option value="{{ $student->jurusan }}" selected>{{ $student->jurusan }}</option>
                    @endif
                    <option value="{{ $data->jurusan }}">{{ $data->jurusan }}</option>
                    @endforeach
                  </select>
                  <span class="text-danger">@error('jurusan') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="kelas">Kelas</label>
                  <select class="form-control form-select form-select-md" name="kelas" id="kelas">
                    @foreach( $kelas as $data )
                    @if ($student->kelas)
                    <option value="{{ $student->kelas }}" selected>{{ $student->kelas }}</option>
                    @endif
                    <option value="{{ $data->kelas }}">{{ $data->kelas }}</option>
                    @endforeach
                  </select>
                  <span class="text-danger">@error('kelas') {{ $message }} @enderror</span>
                </div>
            </div>
            <div class="col col-md-6">
              <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <select class="form-control form-select form-select-md" name="provinsi" id="provinsi"
                  data-dependent="kota">
                  @foreach( $provinsi as $data )
                  @if ($student->provinsi)
                  <option value="{{ $student->provinsi }}" selected>{{ $student->provinsi }}</option>
                  @endif
                  <option value="{{ $data->provinsi }}">{{ $data->provinsi }}</option>
                  @endforeach
                </select>
                <span class="text-danger">@error('provinsi') {{ $message }}
                  @enderror</span>
              </div>
              <div class="form-group">
                <label for="kota">Kota</label>
                <select class="form-control form-select form-select-md" name="kota" id="kota" data-dependent="kota">
                  @foreach( $kota as $data )
                  @if ($student->kota)
                  <option value="{{ $student->kota }}" selected>{{ $student->kota }}</option>
                  @endif
                  <option value="{{ $data->jk }} {{ $data->kota }}">{{ $data->kota }}
                    ({{ $data->jk }} {{ $data->kota }})</option>
                  @endforeach
                </select>
                <span class="text-danger">@error('kota') {{ $message }}
                  @enderror</span>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" name="alamat" id="alamat"
                  value="{{ $student->alamat ?? old('alamat') }}">
                <span class="text-danger">@error('alamat') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" class="form-control" name="email" id="email"
                  value="{{ $student->email ?? old('email') }}">
                <span class="text-danger">@error('email') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="n_wa">No HP</label>
                <input type="text" class="form-control" name="n_wa" id="n_wa"
                  value="{{ $student->n_wa ?? old('n_wa') }}">
                <span class="text-danger">@error('n_wa') {{ $message }} @enderror</span>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-warning">Edit</button>
          <a href="{{route('kd_siswa')}}" class="btn btn-secondary float-right">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection