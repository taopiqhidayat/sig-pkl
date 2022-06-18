@extends('layout.auth')

@section('title', 'Registrasi Admin')

@section('isi')
<div class="container">
  @if ($res == 1)
  <!-- Nested Row within Card Body -->
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <div class="p-5">
            <div class="text-center">
              <h3 class="text-gray-900 mb-4">Buat Akun!</h3>
            </div>
            @if (Session::get('fai'))
            <div class="alert alert-danger">{{ Session::get('fai') }}</div>
            @endif
            <h5 class="mt-2">Registrasi Sebagai Admin</h5>
            <form action="{{ route('regist_admin') }}" method="post" class="user">
              @csrf
              <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Anda ..."
                  value="{{ old('name') }}">
                <span class="text-danger">@error('name') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="email_admin">Alamat Email</label>
                <input type="email" class="form-control" id="email_admin" name="email_admin"
                  placeholder="Masukkan Email Anda ..." value="{{ old('email_admin') }}">
                <span class="text-danger">@error('email_admin') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="n_wa_admin">No HP</label>
                <input type="text" class="form-control" id="n_wa_admin" name="n_wa_admin"
                  placeholder="Masukkan No HP Anda ..." value="{{ old('n_wa_admin') }}">
                <span class="text-danger">@error('n_wa_admin') {{ $message }} @enderror</span>
              </div>
              <hr>
              <div class="form-group">
                <label for="username_admin">Username</label>
                <input type="text" class="form-control" name="username_admin" id="username_admin"
                  placeholder="Masukkan Username ..." value="{{ old('username_admin')}}">
                <span class="text-danger">@error('username_admin') {{ $message }}
                  @enderror</span>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <label for="passwordadmin">Password</label>
                  <input type="password" class="form-control" id="passwordadmin" name="passwordadmin"
                    placeholder="Password">
                </div>
                <div class="col-sm-6">
                  <label for="passwordadmin_confirmation">Konfirmasi Password</label>
                  <input type="password" class="form-control" id="passwordadmin_confirmation"
                    name="passwordadmin_confirmation" placeholder="Ulangi Password">
                </div>
                <span class="text-danger">@error('passwordadmin') {{ $message }}
                  @enderror</span>
              </div>
              <button type="submit" class="btn btn-primary btn-user btn-block">
                Registrasi Akun
              </button>
              {{--
              <hr>
              <a href="index.html" class="btn btn-google btn-user btn-block">
                <i class="fab fa-google fa-fw"></i> Registrasi dengan Akun Google
              </a> --}}
            </form>
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
    @else
    <h3 class=" text-danger">Fitur ini tidak tersedia</h3>
    @endif
  </div>
  @endsection