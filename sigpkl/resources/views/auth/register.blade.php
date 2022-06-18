@extends('layout.auth')

@section('title', 'Form Registrasi')

@section('isi')

<div class="container">
    @php
    $dftaw = date('Ymd', strtotime($sch->dft_mulai));
    $dftakh = date('Ymd', strtotime($sch->dft_sampai));
    $skr = date('Ymd');
    @endphp
    @if ($skr <= $dftaw || $skr>= $dftakh)
        <h3 class=" text-danger">Fitur ini tidak tersedia</h3>
        @else
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h3 class="text-gray-900 mb-4">Buat Akun!</h3>
                                    </div>
                                    @if (Session::get('fai'))
                                    <div class="alert alert-danger">{{ Session::get('fai') }}</div>
                                    @endif
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="siswa-tab" data-bs-toggle="tab"
                                            data-bs-target="#siswa" type="button" role="tab" aria-controls="siswa"
                                            aria-selected="true">Siswa</button>
                                        <button class="nav-link" id="guru-tab" data-bs-toggle="tab"
                                            data-bs-target="#guru" type="button" role="tab" aria-controls="guru"
                                            aria-selected="false">Guru</button>
                                        <button class="nav-link" id="industri-tab" data-bs-toggle="tab"
                                            data-bs-target="#industri" type="button" role="tab" aria-controls="industri"
                                            aria-selected="false">Industri</button>
                                    </div>
                                    <div class="tab tab-content" id="nav-tabContent">
                                        <div class="tab tab-pane fade show active" id="siswa" role="tabpanel"
                                            aria-labelledby="siswa-tab">
                                            <h5 class="mt-2">Registrasi Sebagai Siswa</h5>
                                            <form action="{{ route('regist_siswa') }}" method="post" class="user">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="nama">Nama Lengkap</label>
                                                    <input type="text" class="form-control" id="nama" name="nama"
                                                        placeholder="Masukkan Nama Anda ..." value="{{ old('nama') }}">
                                                    <span class="text-danger">@error('nama') {{ $message }}
                                                        @enderror</span>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="nis">Nomor Induk Siswa</label>
                                                        <input type="text" class="form-control" id="nis" name="nis"
                                                            placeholder="Masukkan Nomor Induk Siswa Anda ..."
                                                            value="{{ old('nis') }}">
                                                        <span class="text-danger">@error('nis') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                    <div class="col col-sm-6">
                                                        <label for="jk">Jenis Kelamin</label>
                                                        <select class="form-control form-select form-select-md"
                                                            name="jk" id="jk">
                                                            <option value="">Pilih Jenis Kelamin</option>
                                                            <option value="Laki - laki">Laki - laki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                        </select>
                                                        <span class="text-danger">@error('jk') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="jurusan">Jurusan</label>
                                                        <select class="form-control form-select form-select-md"
                                                            name="jurusan" id="jurusan">
                                                            <option value="">Pilih Jurusan</option>
                                                            @foreach( $jurusan as $data )
                                                            <option value="{{ $data->jurusan }}">{{ $data->jurusan }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">@error('jurusan') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                    <div class="col col-sm-6">
                                                        <label for="kelas">Kelas</label>
                                                        <select class="form-control form-select form-select-md"
                                                            name="kelas" id="kelas">
                                                            <option value="">Pilih Kelas</option>
                                                            @foreach( $kelas as $data )
                                                            <option value="{{ $data->kelas }}">{{ $data->kelas }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">@error('kelas') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="provinsi">Provinsi</label>
                                                        <select class="form-control form-select form-select-md"
                                                            name="provinsi" id="provinsi">
                                                            <option value="">Pilih Provinsi</option>
                                                            @foreach( $provinsi as $data )
                                                            <option value="{{ $data->provinsi }}">{{ $data->provinsi }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">@error('provinsi') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                    <div class="col col-sm-6">
                                                        <label for="kota">Kabupaten/Kota</label>
                                                        <select class="form-control form-select form-select-md"
                                                            name="kota" id="kota" data-dependent="kecamatan">
                                                            <option value="">Pilih Kabupaten/Kota</option>
                                                            @foreach( $kota as $data )
                                                            <option value="{{ $data->jk }} {{ $data->kota }}">
                                                                {{ $data->kota }}
                                                                ({{ $data->jk }} {{ $data->kota }})</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">@error('kota') {{ $message }}
                                                            @enderror</span>
                                                        {{-- <div id="loading" style="margin-top: 15px;">
                                                        <img src="/images/loading.gif" width="18"> <small>Loading...</small>
                                                    </div> --}}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="alamat">Alamat</label>
                                                    <input type="text" class="form-control" name="alamat" id="alamat"
                                                        placeholder="Dimana Alamat Anda ..."
                                                        value="{{ old('alamat') }}">
                                                    <span class="text-danger">@error('alamat') {{ $message }}
                                                        @enderror</span>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="email">Alamat Email</label>
                                                        <input type="email" class="form-control" name="email" id="email"
                                                            placeholder="Masukkan Email Anda ..."
                                                            value="{{ old('email') }}">
                                                        <span class="text-danger">@error('email') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                    <div class="col col-sm-6">
                                                        <label for="n_wa">No HP</label>
                                                        <input type="text" class="form-control" name="n_wa" id="n_wa"
                                                            placeholder="Masukkan No HP Anda ..."
                                                            value="{{ old('n_wa') }}">
                                                        <span class="text-danger">@error('n_wa') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input type="text" class="form-control" name="username"
                                                        id="username" placeholder="Masukkan Username ..."
                                                        value="{{ old('username')}}">
                                                    <span class="text-danger">@error('username') {{ $message }}
                                                        @enderror</span>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="password">Password</label>
                                                        <input type="password" class="form-control" id="password"
                                                            name="password" placeholder="Password">
                                                    </div>
                                                    <div class="col col-sm-6">
                                                        <label for="password_confirmation">Konfirmasi Password</label>
                                                        <input type="password" class="form-control"
                                                            id="password_confirmation" name="password_confirmation"
                                                            placeholder="Ulangi Password">
                                                        <span class="text-danger">@error('password_confirmation')
                                                            {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                    <span class="text-danger">@error('password') {{ $message }}
                                                        @enderror</span>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                                    Registrasi Akun
                                                </button>
                                                {{-- <hr>
                                    <a href="index.html" class="btn btn-google btn-user btn-block">
                                        <i class="fab fa-google fa-fw"></i> Registrasi dengan Akun Google
                                    </a> --}}
                                            </form>
                                        </div>
                                        <div class=" tab tab-pane fade" id="guru" role="tabpanel"
                                            aria-labelledby="guru-tab">
                                            <h5 class="mt-2">Registrasi Sebagai Guru</h5>
                                            <form action="{{ route('regist_guru') }}" method="post" class="user">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="ni">Nomor Induk</label>
                                                        <input type="text" class="form-control" id="ni" name="ni"
                                                            placeholder="Masukkan Nomor Induk Anda ..."
                                                            value="{{ old('ni') }}">
                                                        <span class="text-danger">@error('ni') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="nama_guru">Nama Lengkap</label>
                                                        <input type="text" class="form-control" id="nama_guru"
                                                            name="nama_guru" placeholder="Masukkan Nama Anda ..."
                                                            value="{{ old('nama_guru') }}">
                                                        <span class="text-danger">@error('nama_guru') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="jk_guru">Jenis Kelamin</label>
                                                        <select class="form-control form-select form-select-md"
                                                            name="jk_guru" id="jk_guru">
                                                            <option value="">Pilih Jenis Kelamin</option>
                                                            <option value="Laki - laki">Laki - laki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                        </select>
                                                        <span class="text-danger">@error('jk_guru') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="jurusan_guru">Jurusan</label>
                                                        <select class="form-control form-select form-select-md"
                                                            name="jurusan_guru" id="jurusan_guru">
                                                            <option value="">Pilih Jurusan</option>
                                                            @foreach( $jurusan as $data )
                                                            <option value="{{ $data->jurusan }}">{{ $data->jurusan }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">@error('jurusan_guru') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="provinsi_guru">Provinsi</label>
                                                        <select class="form-control form-select form-select-md"
                                                            name="provinsi_guru" id="provinsi_guru"
                                                            data-dependent="kota">
                                                            <option value="">Pilih Provinsi</option>
                                                            @foreach( $provinsi as $data )
                                                            <option value="{{ $data->provinsi }}">{{ $data->provinsi }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">@error('provinsi_guru') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="kota_guru">Kabupaten/Kota</label>
                                                        <select class="form-control form-select form-select-md"
                                                            name="kota_guru" id="kota_guru" data-dependent="kota">
                                                            <option value="">Pilih Kabupaten/Kota</option>
                                                            @foreach( $kota as $data )
                                                            <option value="{{ $data->jk }} {{ $data->kota }}">
                                                                {{ $data->kota }}
                                                                ({{ $data->jk }} {{ $data->kota }})</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">@error('kota_guru') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="alamat_guru">Alamat</label>
                                                    <input type="text" class="form-control" id="alamat_guru"
                                                        name="alamat_guru" placeholder="Masukkan Alamat Anda ..."
                                                        value="{{ old('alamat_guru') }}">
                                                    <span class="text-danger">@error('alamat_guru') {{ $message }}
                                                        @enderror</span>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="email_guru">Alamat Email</label>
                                                        <input type="email" class="form-control" id="email_guru"
                                                            name="email_guru" placeholder="Masukkan Email Anda ..."
                                                            value="{{ old('email_guru') }}">
                                                        <span class="text-danger">@error('email_guru') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="n_wa_guru">No HP</label>
                                                        <input type="text" class="form-control" id="n_wa_guru"
                                                            name="n_wa_guru" placeholder="Masukkan No HP Anda ..."
                                                            value="{{ old('n_wa_guru') }}">
                                                        <span class="text-danger">@error('n_wa_guru') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label for="username_guru">Username</label>
                                                    <input type="text" class="form-control" name="username_guru"
                                                        id="username_guru" placeholder="Masukkan Username ..."
                                                        value="{{ old('username_guru')}}">
                                                    <span class="text-danger">@error('username_guru') {{ $message }}
                                                        @enderror</span>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="passwordguru">Password</label>
                                                        <input type="password" class="form-control" id="passwordguru"
                                                            name="passwordguru" placeholder="Password">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="passwordguru_confirmation">Konfirmasi
                                                            Password</label>
                                                        <input type="password" class="form-control"
                                                            id="passwordguru_confirmation"
                                                            name="passwordguru_confirmation"
                                                            placeholder="Ulangi Password">
                                                    </div>
                                                    <span class="text-danger">@error('passwordguru') {{ $message }}
                                                        @enderror</span>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                                    Registrasi Akun
                                                </button>
                                                {{-- <hr>
                                    <a href="index.html" class="btn btn-google btn-user btn-block">
                                        <i class="fab fa-google fa-fw"></i> Registrasi dengan Akun Google
                                    </a> --}}
                                            </form>
                                        </div>
                                        <div class=" tab tab-pane fade" id="industri" role="tabpanel"
                                            aria-labelledby="industri-tab">
                                            <h5 class="mt-2">Registrasi Sebagai Industri</h5>
                                            <form action="{{ route('regist_industri') }}" method="post" class="user">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="nama_indu">Nama Perusahaan</label>
                                                    <input type="text" class="form-control" id="nama_indu"
                                                        name="nama_indu"
                                                        placeholder="Masukkan Nama Perusahaan/Industri/Instansi Anda ..."
                                                        value="{{ old('nama_indu') }}">
                                                    <span class="text-danger">@error('nama_indu') {{ $message }}
                                                        @enderror</span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="bidang">Bidang</label>
                                                    <input type="text" class="form-control" id="bidang" name="bidang"
                                                        placeholder="Bergerak di bidang ..."
                                                        value="{{ old('bidang') }}">
                                                    <span class="text-danger">@error('bidang') {{ $message }}
                                                        @enderror</span>
                                                </div>
                                                <label for="menjur">Menerima Jurusan</label>
                                                <div class="form-group">
                                                    @foreach ($jurusan as $mj)
                                                    <input type="hidden" name="idj[]" id="idj" value="{{$mj->id}}">
                                                    <input type="hidden" name="mj[{{$mj->id}}]" id="jt"
                                                        value="{{$mj->jurusan}}">
                                                    <div class=" form-check">
                                                        <input type="checkbox" class=" form-check-input" value="1"
                                                            name="terjur{{$mj->id}}" id="terjur" value="1">
                                                        <label for="terjur"
                                                            class=" form-check-label">{{ $mj->jurusan}}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="provinsi_indu">Provinsi</label>
                                                        <select class="form-control form-select form-select-md"
                                                            name="provinsi_indu" id="provinsi_indu"
                                                            data-dependent="kota">
                                                            <option value="">Pilih Provinsi</option>
                                                            @foreach( $provinsi as $data )
                                                            <option value="{{ $data->provinsi }}">{{ $data->provinsi }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">@error('provinsi_indu') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="kota_indu">Kabupaten/Kota</label>
                                                        <select class="form-control form-select form-select-md"
                                                            name="kota_indu" id="kota_indu" data-dependent="kota">
                                                            <option value="">Pilih Kabupaten/Kota</option>
                                                            @foreach( $kota as $data )
                                                            <option value="{{ $data->jk }} {{ $data->kota }}">
                                                                {{ $data->kota }}
                                                                ({{ $data->jk }} {{ $data->kota }})</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">@error('kota_indu') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="alamat_indu">Alamat</label>
                                                    <input type="text" class="form-control" id="alamat_indu"
                                                        name="alamat_indu" placeholder="Masukkan Alamat Anda ..."
                                                        value="{{ old('alamat_indu') }}">
                                                    <span class="text-danger">@error('alamat_indu') {{ $message }}
                                                        @enderror</span>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="email_indu">Alamat Email</label>
                                                        <input type="email" class="form-control" id="email_indu"
                                                            name="email_indu" placeholder="Masukkan Email Anda ..."
                                                            value="{{ old('email_indu') }}">
                                                        <span class="text-danger">@error('email_indu') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="n_wa_indu">No Telepon</label>
                                                        <input type="text" class="form-control" id="n_wa_indu"
                                                            name="n_wa_indu" placeholder="Masukkan No HP Anda ..."
                                                            value="{{ old('n_wa_indu') }}">
                                                        <span class="text-danger">@error('n_wa_indu') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="latitude">Latitude</label>
                                                        <input type="text" class="form-control" id="latitude"
                                                            name="latitude" placeholder="Latitude"
                                                            value="{{ old('latitude')}}">
                                                        <span class="text-danger">@error('latitude') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                    <div class="col col-sm-6">
                                                        <label for="longitude">Longitude</label>
                                                        <input type="text" class="form-control" id="longitude"
                                                            name="longitude" placeholder="Longitude"
                                                            value="{{ old('longitude')}}">
                                                        <span class="text-danger">@error('longitude') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="nama_ketua">Nama Pimpinan</label>
                                                        <input type="text" class="form-control" id="nama_ketua"
                                                            name="nama_ketua" placeholder="Nama Pimpinan"
                                                            value="{{ old('nama_ketua')}}">
                                                        <span class="text-danger">@error('nama_ketua') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                    <div class="col col-sm-6">
                                                        <label for="ni_ketua">NIP Pimpinan (Jika Ada)</label>
                                                        <input type="text" class="form-control" id="ni_ketua"
                                                            name="ni_ketua" placeholder="NIP (Jika Ada)"
                                                            value="{{ old('ni_ketua')}}">
                                                        <span class="text-danger">@error('ni_ketua') {{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label for="username_indu">Username</label>
                                                    <input type="text" class="form-control" name="username_indu"
                                                        id="username_indu" placeholder="Masukkan Username ..."
                                                        value="{{ old('username_indu')}}">
                                                    <span class="text-danger">@error('username_indu') {{ $message }}
                                                        @enderror</span>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="passwordindu">Password</label>
                                                        <input type="password" class="form-control" id="passwordindu"
                                                            name="passwordindu" placeholder="Password">
                                                    </div>
                                                    <div class="col col-sm-6">
                                                        <label for="passwordindu_confirmation">Konfirmasi
                                                            Password</label>
                                                        <input type="password" class="form-control"
                                                            id="passwordindu_confirmation"
                                                            name="passwordindu_confirmation"
                                                            placeholder="Ulangi Password">
                                                    </div>
                                                    <span class="text-danger">@error('passwordindu') {{ $message }}
                                                        @enderror</span>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                                    Registrasi Akun
                                                </button>
                                                {{-- <hr>
                                    <a href="index.html" class="btn btn-google btn-user btn-block">
                                        <i class="fab fa-google fa-fw"></i> Registrasi dengan Akun Google
                                    </a> --}}
                                            </form>
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- <div class="text-center">
                            <a class="small" href="{{ route('forgot') }}">Lupa Password?</a>
                                </div> --}}
                                <div class="text-center">
                                    <a class="small" href="{{ route('flogin') }}">Sudah Punya Akun? Login Sekarang!</a>
                                </div>
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