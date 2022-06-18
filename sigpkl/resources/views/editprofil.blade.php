@extends('layout.main')

@section('title', 'Edit Profil')

@section('isi')
<div class="container">
  <h3 class=" text-uppercase">Edit Profil</h3>

  @if (Auth::user()->is_admin == 1)
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="row g-0">
          <div class="col-md-3 p-5">
            {{-- <div class="col-md-4 p-5" style="background-image: url('/images/default.png');"> --}}
            <form action="{{ route('simpan') }}" method="post" enctype="multipart/form-data">
              @csrf
              @if ($user->foto == null)
              <img src="/images/default.png" class=" img-thumbnail" alt="profil_{{$user->name}}" height="180px">
              @else
              <img src="{{ asset('/storage/profil/'.$user->foto) }}" alt="profil_{{$user->name}}" height="180px">
              @endif
              <input type="file" name="foto" id="foto">
          </div>
          <div class="col-md-9">
            <div class="card-body">
              <div class=" row">
                <div class=" col-6">
                  <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                  <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" class="form-control form-control-user" id="name" name="name"
                      aria-describedby="name" placeholder="Masukkan Nama Anda..." value="{{ $user->name }}">
                    <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                  </div>
                  <div class="form-group">
                    <label for="email_admin">Alamat Email</label>
                    <input type="email" class="form-control form-control-user" id="email_admin" name="email_admin"
                      aria-describedby="email_admin" placeholder="Masukkan Email Anda..." value="{{ $user->email }}">
                    <span class="text-danger">@error('email_admin') {{ $message }} @enderror</span>
                  </div>
                  <div class="form-group">
                    <label for="n_wa_admin">No HP</label>
                    <input type="text" class="form-control form-control-user" id="n_wa_admin" name="n_wa_admin"
                      aria-describedby="n_wa_admin" placeholder="Masukkan No HP Anda..." value="{{ $user->n_wa }}">
                    <span class="text-danger">@error('n_wa_admin') {{ $message }} @enderror</span>
                  </div>
                  <hr>
                  <div class="form-group">
                    <label for="nama_sch">Nama Sekolah</label>
                    <input type="text" class="form-control form-control-user" id="nama_sch" name="nama_sch"
                      aria-describedby="nama_sch" placeholder="Masukkan No HP Anda..." value="{{ $sch->nama }}">
                  </div>
                  <div class="form-group row">
                    <div class=" col-6">
                      <label for="kesek">Kepala Sekolah</label>
                      <input type="text" class="form-control form-control-user" id="kesek" name="kesek"
                        aria-describedby="kesek" placeholder="Masukkan Nama Kepala Sekolah..."
                        value="{{ $sch->kesek }}">
                    </div>
                    <div class=" col-6">
                      <label for="ni_kesek">NIP Kepala Sekolah</label>
                      <input type="text" class="form-control form-control-user" id="ni_kesek" name="ni_kesek"
                        aria-describedby="ni_kesek" placeholder="Masukkan NIP Kepala Sekolah..."
                        value="{{ $sch->ni_kesek }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class=" col-6">
                      <label for="provinsi_sch">Provinsi</label>
                      <input type="text" class="form-control form-control-user" id="provinsi_sch" name="provinsi_sch"
                        aria-describedby="provinsi_sch" placeholder="Masukkan No HP Anda..."
                        value="{{ $sch->provinsi }}">
                    </div>
                    <div class=" col-6">
                      <label for="kota_sch">Kabupaten/Kota</label>
                      <input type="text" class="form-control form-control-user" id="kota_sch" name="kota_sch"
                        aria-describedby="kota_sch" placeholder="Masukkan No HP Anda..." value="{{ $sch->kota }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="alamat_sch">Alamat Sekolah</label>
                    <input type="text" class="form-control form-control-user" id="alamat_sch" name="alamat_sch"
                      aria-describedby="alamat_sch" placeholder="Masukkan No HP Anda..." value="{{ $sch->alamat }}">
                  </div>
                </div>
                <div class=" col-6">
                  <h5>Jadwal PKL</h5>
                  <span>Pendaftaran/Registrasi:</span>
                  <div class="form-group row">
                    <div class=" col-6">
                      <label for="dft_mulai">Mulai</label>
                      <input type="date" class="form-control form-control-user" id="dft_mulai" name="dft_mulai"
                        aria-describedby="dft_mulai" placeholder="Masukkan No HP Anda..." value="{{ $sch->dft_mulai }}">
                      <span class="text-danger">@error('dft_mulai') {{ $message }} @enderror</span>
                    </div>
                    <div class=" col-6">
                      <label for="dft_sampai">Sampai</label>
                      <input type="date" class="form-control form-control-user" id="dft_sampai" name="dft_sampai"
                        aria-describedby="dft_sampai" placeholder="Masukkan No HP Anda..."
                        value="{{ $sch->dft_sampai }}">
                      <span class="text-danger">@error('dft_sampai') {{ $message }} @enderror</span>
                    </div>
                  </div>
                  <span>Pencarian Lokasi:</span>
                  <div class="form-group row">
                    <div class=" col-6">
                      <label for="clk_mulai">Mulai</label>
                      <input type="date" class="form-control form-control-user" id="clk_mulai" name="clk_mulai"
                        aria-describedby="clk_mulai" placeholder="Masukkan No HP Anda..." value="{{ $sch->clk_mulai }}">
                      <span class="text-danger">@error('clk_mulai') {{ $message }} @enderror</span>
                    </div>
                    <div class=" col-6">
                      <label for="clk_sampai">Sampi</label>
                      <input type="date" class="form-control form-control-user" id="clk_sampai" name="clk_sampai"
                        aria-describedby="clk_sampai" placeholder="Masukkan No HP Anda..."
                        value="{{ $sch->clk_sampai }}">
                      <span class="text-danger">@error('clk_sampai') {{ $message }} @enderror</span>
                    </div>
                  </div>
                  <span>Pelaksanaan:</span>
                  <div class="form-group row">
                    <div class=" col-6">
                      <label for="pkl_mulai">Mulai</label>
                      <input type="date" class="form-control form-control-user" id="pkl_mulai" name="pkl_mulai"
                        aria-describedby="pkl_mulai" placeholder="Masukkan No HP Anda..." value="{{ $sch->pkl_mulai }}">
                      <span class="text-danger">@error('pkl_mulai') {{ $message }} @enderror</span>
                    </div>
                    <div class=" col-6">
                      <label for="pkl_sampai">Sampai</label>
                      <input type="date" class="form-control form-control-user" id="pkl_sampai" name="pkl_sampai"
                        aria-describedby="pkl_sampai" placeholder="Masukkan No HP Anda..."
                        value="{{ $sch->pkl_sampai }}">
                      <span class="text-danger">@error('pkl_sampai') {{ $message }} @enderror</span>
                    </div>
                  </div>
                  <span>Penyusunan Laporan:</span>
                  <div class="form-group row">
                    <div class=" col-6">
                      <label for="lap_mulai">Mulai</label>
                      <input type="date" class="form-control form-control-user" id="lap_mulai" name="lap_mulai"
                        aria-describedby="lap_mulai" placeholder="Masukkan No HP Anda..." value="{{ $sch->lap_mulai }}">
                      <span class="text-danger">@error('lap_mulai') {{ $message }} @enderror</span>
                    </div>
                    <div class=" col-6">
                      <label for="lap_sampai">Sampai</label>
                      <input type="date" class="form-control form-control-user" id="lap_sampai" name="lap_sampai"
                        aria-describedby="lap_sampai" placeholder="Masukkan No HP Anda..."
                        value="{{ $sch->lap_sampai }}">
                      <span class="text-danger">@error('lap_sampai') {{ $message }} @enderror</span>
                    </div>
                  </div>
                  <span>Pengujian/Sidang</span>
                  <div class="form-group row">
                    <div class=" col-6">
                      <label for="uji_mulai">Mulai</label>
                      <input type="date" class="form-control form-control-user" id="uji_mulai" name="uji_mulai"
                        aria-describedby="uji_mulai" placeholder="Masukkan No HP Anda..." value="{{ $sch->uji_mulai }}">
                      <span class="text-danger">@error('uji_mulai') {{ $message }} @enderror</span>
                    </div>
                    <div class=" col-6">
                      <label for="uji_sampai">Sampai</label>
                      <input type="date" class="form-control form-control-user" id="uji_sampai" name="uji_sampai"
                        aria-describedby="uji_sampai" placeholder="Masukkan No HP Anda..."
                        value="{{ $sch->uji_sampai }}">
                      <span class="text-danger">@error('uji_sampai') {{ $message }} @enderror</span>
                    </div>
                  </div>
                </div>
                <div class=" col">
                  <button type="submit" class="btn btn-warning float-right ml-3">Simpan</button>
                  <a href="{{ route('ganti_usswrd') }}" class="btn btn-danger ml-3 float-right">Ganti Username &
                    Password</a>
                  <a href="/profil" class="btn btn-secondary float-right">Batal</a>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  @if (Auth::user()->is_guru == 1)
  <div class="row">
    <div class="col col-md-8">
      <div class="card">
        <div class="row g-0">
          <div class="col-md-4 p-5">
            <form action="{{ route('simpan') }}" method="post" enctype="multipart/form-data">
              @csrf
              @if ($user->foto == null)
              <img src="/images/default.png" class=" img-thumbnail" alt="profil_{{$user->name}}" height="180px">
              @else
              <img src="{{ asset('/storage/profil/'.$user->foto) }}" alt="profil_{{$user->name}}" height="180px">
              @endif
              <input type="file" name="foto" id="foto">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <input type="hidden" name="id" value="{{ Auth::user()->id }}">
              <div class="form-group">
                <label for="nama_guru">Nama Lengkap</label>
                <input type="text" class="form-control form-control-user" id="nama_guru" name="nama_guru"
                  aria-describedby="nama_guru" placeholder="Masukkan Nama Anda..." value="{{ $guru->nama }}">
                <span class="text-danger">@error('nama_guru') {{ $message }} @enderror</span>
              </div>
              <div class="form-group row">
                <div class=" col-6">
                  <label for="jk_guru">Jenis Kelamin</label>
                  <select class="form-control form-select form-select-md" name="jk_guru" id="jk_guru">
                    @if ($guru->jk)
                    <option value="{{ $guru->jk }}" selected>{{ $guru->jk }}</option>
                    @endif
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki - laki">Laki - laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                  <span class="text-danger">@error('jk_guru') {{ $message }} @enderror</span>
                </div>
                <div class=" col-6">
                  <label for="jurusan_guru">Jurusan</label>
                  <select class="form-control form-select form-select-md" name="jurusan_guru" id="jurusan_guru">
                    @foreach( $jurusan as $data )
                    @if ($guru->jurusan)
                    <option value="{{ ucfirst($guru->jurusan) }}" selected>{{ ucfirst($guru->jurusan) }}</option>
                    @endif
                    <option value="{{ $data->jurusan }}">{{ $data->jurusan }}</option>
                    @endforeach
                  </select>
                  <span class="text-danger">@error('jurusan_guru') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="form-group row">
                <div class=" col-6">
                  <label for="provinsi_guru">Provinsi</label>
                  <select class="form-control form-select form-select-md" name="provinsi_guru" id="provinsi_guru"
                    data-dependent="kota">
                    @foreach( $provinsi as $data )
                    @if ($guru->provinsi)
                    <option value="{{ $guru->provinsi }}" selected>{{ $guru->provinsi }}</option>
                    @endif
                    <option value="{{ $data->provinsi }}">{{ $data->provinsi }}</option>
                    @endforeach
                  </select>
                  <span class="text-danger">@error('provinsi_guru') {{ $message }}
                    @enderror</span>
                </div>
                <div class=" col-6">
                  <label for="kota_guru">Kabupaten/Kota</label>
                  <select class="form-control form-select form-select-md" name="kota_guru" id="kota_guru"
                    data-dependent="kota">
                    @foreach( $kota as $data )
                    @if ($guru->kota)
                    <option value="{{ $guru->kota }}" selected>{{ $guru->kota }}</option>
                    @endif
                    <option value="{{ $data->jk }} {{ $data->kota }}">{{ $data->kota }}
                      ({{ $data->jk }} {{ $data->kota }})</option>
                    @endforeach
                  </select>
                  <span class="text-danger">@error('kota_guru') {{ $message }}
                    @enderror</span>
                </div>
              </div>
              <div class="form-group">
                <label for="alamat_guru">Alamat</label>
                <input type="text" class="form-control" id="alamat_guru" name="alamat_guru"
                  placeholder="Masukkan Alamat Anda ..." value="{{ $guru->alamat }}">
                <span class="text-danger">@error('alamat_guru') {{ $message }} @enderror</span>
              </div>
              <div class="form-group row">
                <div class=" col-6">
                  <label for="email_guru">Alamat Email</label>
                  <input type="email" class="form-control" id="email_guru" name="email_guru"
                    placeholder="Masukkan Email Anda ..." value="{{ $guru->email }}">
                  <span class="text-danger">@error('email_guru') {{ $message }} @enderror</span>
                </div>
                <div class=" col-6">
                  <label for="n_wa_guru">No HP</label>
                  <input type="text" class="form-control" id="n_wa_guru" name="n_wa_guru"
                    placeholder="Masukkan No HP Anda ..." value="{{ $guru->n_wa }}">
                  <span class="text-danger">@error('n_wa_guru') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <label for="latguru">Latitude</label>
                  <input type="text" class="form-control" id="latguru" name="latguru" placeholder="Latitude"
                    value="{{ $guru->latitude }}">
                  <span class="text-danger">@error('latguru') {{ $message }} @enderror</span>
                </div>
                <div class=" col-sm-6">
                  <label for="longitude">Longitude</label>
                  <input type="text" class="form-control" id="longguru" name="longguru" placeholder="Longitude"
                    value="{{ $guru->longitude }}">
                  <span class="text-danger">@error('longguru') {{ $message }}
                    @enderror</span>
                </div>
              </div>
              <button type="submit" class="btn btn-warning">Simpan</button>
              <a href="/profil" class="btn btn-secondary float-right">Batal</a>
              <a href="{{ route('ganti_usswrd') }}" class="btn btn-danger ml-3">Ganti Username & Password</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  @if (Auth::user()->is_industri == 1)
  <div class="row">
    <div class="col col-md-8">
      <div class="card">
        <div class="row g-0">
          <div class="col-md-4 p-5">
            <form action="{{ route('simpan') }}" method="post" enctype="multipart/form-data">
              @csrf
              @if ($user->foto == null)
              <img src="/images/default.png" class=" img-thumbnail" alt="profil_{{$user->name}}" height="180px">
              @else
              <img src="{{ asset('/storage/profil/'.$user->foto) }}" alt="profil_{{$user->name}}" height="180px">
              @endif
              <input type="file" name="foto" id="foto">
          </div>
          <div class="col-md">
            <div class="card-body">
              <input type="hidden" name="id" value="{{ Auth::user()->id }}">
              <div class="form-group">
                <label for="nama_indu">Nama Perusahaan</label>
                <input type="text" class="form-control" id="nama_indu" name="nama_indu"
                  placeholder="Masukkan Nama Perusahaan/Industri Anda ..." value="{{ $indu->nama }}">
                <span class="text-danger">@error('nama_indu') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="bidang">Bidang</label>
                <input type="text" class="form-control" id="bidang" name="bidang" placeholder="Bergerak di bidang ..."
                  value="{{ $indu->bidang }}">
                <span class="text-danger">@error('bidang') {{ $message }} @enderror</span>
              </div>
              <label for="menjur">Menerima Jurusan</label>
              <div class="form-group">
                @foreach ($jurusan as $mj)
                <input type="hidden" name="idj[]" id="idj" value="{{$mj->id}}">
                <input type="hidden" name="mj[{{$mj->id}}]" id="jt" value="{{$mj->jurusan}}">
                <div class=" form-check">
                  @php
                  $jt = app('App\Http\Controllers\UsersControler')->getjt($mj->jurusan);
                  @endphp
                  @if ($jt == 1)
                  <input type="checkbox" class=" form-check-input" value="1" name="terjur{{$mj->id}}" id="terjur"
                    value="1" checked>
                  @else
                  <input type="checkbox" class=" form-check-input" value="1" name="terjur{{$mj->id}}" id="terjur"
                    value="1">
                  @endif
                  <label for="terjur" class=" form-check-label">{{ $mj->jurusan}}</label>
                </div>
                @endforeach
              </div>
              <div class="form-group row">
                <div class=" col-6">
                  <label for="provinsi_indu">Provinsi</label>
                  <select class="form-control form-select form-select-md" name="provinsi_indu" id="provinsi_indu"
                    data-dependent="kota">
                    @foreach( $provinsi as $data )
                    @if ($indu->provinsi)
                    <option value="{{ $indu->provinsi }}" selected>{{ $indu->provinsi }}</option>
                    @endif
                    <option value="{{ $data->provinsi }}">{{ $data->provinsi }}</option>
                    @endforeach
                  </select>
                  <span class="text-danger">@error('provinsi_indu') {{ $message }}
                    @enderror</span>
                </div>
                <div class=" col-6">
                  <label for="kota_indu">Kabupaten/Kota</label>
                  <select class="form-control form-select form-select-md" name="kota_indu" id="kota_indu"
                    data-dependent="kota">
                    @foreach( $kota as $data )
                    @if ($indu->kota)
                    <option value="{{ $indu->kota }}" selected>{{ $indu->kota }}</option>
                    @endif
                    <option value="{{ $data->jk }} {{ $data->kota }}">{{ $data->kota }}
                      ({{ $data->jk }} {{ $data->kota }})</option>
                    @endforeach
                  </select>
                  <span class="text-danger">@error('kota_indu') {{ $message }}
                    @enderror</span>
                </div>
              </div>
              <div class="form-group">
                <label for="alamat_indu">Alamat</label>
                <input type="text" class="form-control" id="alamat_indu" name="alamat_indu"
                  placeholder="Masukkan Alamat Anda ..." value="{{ $indu->alamat }}">
                <span class="text-danger">@error('alamat_indu') {{ $message }} @enderror</span>
              </div>
              <div class="form-group row">
                <div class=" col-6">
                  <label for="email_indu">Alamat Email</label>
                  <input type="email" class="form-control" id="email_indu" name="email_indu"
                    placeholder="Masukkan Email Anda ..." value="{{ $indu->email }}">
                  <span class="text-danger">@error('email_indu') {{ $message }} @enderror</span>
                </div>
                <div class=" col-6">
                  <label for="n_wa_indu">No HP</label>
                  <input type="text" class="form-control" id="n_wa_indu" name="n_wa_indu"
                    placeholder="Masukkan No HP Anda ..." value="{{ $indu->n_wa }}">
                  <span class="text-danger">@error('n_wa_indu') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <label for="latitude">Latitude</label>
                  <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude"
                    value="{{ $indu->latitude }}">
                  <span class="text-danger">@error('latitude') {{ $message }} @enderror</span>
                </div>
                <div class=" col-sm-6">
                  <label for="longitude">Longitude</label>
                  <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude"
                    value="{{ $indu->longitude }}">
                  <span class="text-danger">@error('longitude') {{ $message }}
                    @enderror</span>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <label for="nama_ketua">Nama Pimpinan</label>
                  <input type="text" class="form-control" id="nama_ketua" name="nama_ketua" placeholder="Nama Pimpinan"
                    value="{{ $indu->ketua }}">
                  <span class="text-danger">@error('nama_ketua') {{ $message }}
                    @enderror</span>
                </div>
                <div class="col col-sm-6">
                  <label for="ni_ketua">NIP Pimpinan (Jika Ada)</label>
                  <input type="text" class="form-control" id="ni_ketua" name="ni_ketua" placeholder="NIP (Jika Ada)"
                    value="{{ $indu->ni_ketua }}">
                  <span class="text-danger">@error('ni_ketua') {{ $message }}
                    @enderror</span>
                </div>
              </div>
              <button type="submit" class="btn btn-warning">Simpan</button>
              <a href="/profil" class="btn btn-secondary float-right">Batal</a>
              <a href="{{ route('ganti_usswrd') }}" class="btn btn-danger ml-3">Ganti Username & Password</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  @if (Auth::user()->is_siswa == 1)
  <div class="row">
    <div class="col col-md-8">
      <div class="card">
        <div class="row g-0">
          <div class="col-md-4 p-5">
            <form action="{{ route('simpan') }}" method="post" enctype="multipart/form-data">
              @csrf
              @if ($user->foto == null)
              <img src="/images/default.png" class=" img-thumbnail" alt="profil_{{$user->name}}" height="180px">
              @else
              <img src="{{ asset('/storage/profil/'.$user->foto) }}" alt="profil_{{$user->name}}" height="180px">
              @endif
              <input type="file" name="foto" id="foto">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <input type="hidden" name="id" value="{{ Auth::user()->id }}">
              <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Anda ..."
                  value="{{ $siswa->nama }}">
                <span class="text-danger">@error('nama') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="jk">Jenis Kelamin</label>
                <select class="form-control form-select form-select-md" name="jk" id="jk">
                  @if ($siswa->jk)
                  <option value="{{ $siswa->jk }}" selected>{{ $siswa->jk }}</option>
                  @endif
                  <option value="">Pilih Jenis Kelamin</option>
                  <option value="Laki - laki">Laki - laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
                <span class="text-danger">@error('jk') {{ $message }} @enderror</span>
              </div>
              <div class="form-group row">
                <div class=" col-6">
                  <label for="jurusan">Jurusan</label>
                  <input type="text" class="form-control" id="jurusan" name="jurusan" value="{{ $siswa->jurusan }}"
                    disabled>
                  <span class="text-danger">@error('jurusan') {{ $message }} @enderror</span>
                </div>
                <div class=" col-6">
                  <label for="kelas">Kelas</label>
                  <input type="text" class="form-control" id="kelas" name="kelas" value="{{ $siswa->kelas }}" disabled>
                  <span class="text-danger">@error('kelas') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="form-group row">
                <div class=" col-6">
                  <label for="provinsi">Provinsi</label>
                  <select class="form-control form-select form-select-md" name="provinsi" id="provinsi"
                    data-dependent="kota">
                    @foreach( $provinsi as $data )
                    @if ($siswa->provinsi)
                    <option value="{{ $siswa->provinsi }}" selected>{{ $siswa->provinsi }}</option>
                    @endif
                    <option value="{{ $data->provinsi }}">{{ $data->provinsi }}</option>
                    @endforeach
                  </select>
                  <span class="text-danger">@error('provinsi') {{ $message }}
                    @enderror</span>
                </div>
                <div class=" col-6">
                  <label for="kota">Kota</label>
                  <select class="form-control form-select form-select-md" name="kota" id="kota" data-dependent="kota">
                    @foreach( $kota as $data )
                    @if ($siswa->kota)
                    <option value="{{ $siswa->kota }}" selected>{{ $siswa->kota }}</option>
                    @endif
                    <option value="{{ $data->jk }} {{ $data->kota }}">{{ $data->kota }}
                      ({{ $data->jk }} {{ $data->kota }})</option>
                    @endforeach
                  </select>
                  <span class="text-danger">@error('kota') {{ $message }}
                    @enderror</span>
                </div>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Dimana Alamat Anda ..."
                  value="{{ $siswa->alamat }}">
                <span class="text-danger">@error('alamat') {{ $message }} @enderror</span>
              </div>
              <div class="form-group row">
                <div class=" col-6">
                  <label for="email">Alamat Email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan Email Anda ..."
                    value="{{ $siswa->email }}">
                  <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                </div>
                <div class=" col-6">
                  <label for="n_wa">No HP</label>
                  <input type="text" class="form-control" name="n_wa" id="n_wa" placeholder="Masukkan No HP Anda ..."
                    value="{{ $siswa->n_wa }}">
                  <span class="text-danger">@error('n_wa') {{ $message }} @enderror</span>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <label for="latsiswa">Latitude</label>
                  <input type="text" class="form-control" id="latsiswa" name="latsiswa" placeholder="Latitude"
                    value="{{ $siswa->latitude }}">
                  <span class="text-danger">@error('latsiswa') {{ $message }} @enderror</span>
                </div>
                <div class=" col-sm-6">
                  <label for="longitude">Longitude</label>
                  <input type="text" class="form-control" id="longsiswa" name="longsiswa" placeholder="Longitude"
                    value="{{ $siswa->longitude }}">
                  <span class="text-danger">@error('longsiswa') {{ $message }}
                    @enderror</span>
                </div>
              </div>
              <button type="submit" class="btn btn-warning">Simpan</button>
              <a href="/profil" class="btn btn-secondary float-right">Batal</a>
              <a href="{{ route('ganti_usswrd') }}" class="btn btn-danger ml-3">Ganti Username & Password</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
</div>
@endsection

@section('script')
<script>
  const terjur = document.querySelectorAll('#terjur');

    for(let i=0; i < terjur.length; i++){
    terjur[i].addEventListener('change', function() {
        terjur[i].value = terjur[i].checked ? 1 : 0;
    });
    }
</script>
@endsection