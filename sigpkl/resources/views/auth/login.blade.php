@extends('layout.auth')

@section('title', 'Form Login')

@section('isi')

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-6 col-lg-6 col-md-6">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                                </div>
                                <form action="{{ route('login') }}" method="post" class="user">
                                    @if (Session::get('fai'))
                                    <div class="alert alert-danger">{{ Session::get('fai') }}</div>
                                    @endif
                                    @if (Session::get('success'))
                                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                                    @endif

                                    @csrf
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control form-control-user" id="username"
                                            name="username" aria-describedby="username"
                                            placeholder="Masukkan username Anda..." value="{{ old('username') }}">
                                        <span class="text-danger">@error('username') {{ $message }} @enderror</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control form-control-user" id="password"
                                            name="password" placeholder="Masukkan Password Anda ..."
                                            value="{{ old('password') }}">
                                        <span class="text-danger">@error('password') {{ $message }} @enderror</span>
                                    </div>
                                    {{-- <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Remember
                                                Me</label>
                                        </div>
                                    </div> --}}
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Masuk
                                    </button>
                                    <hr>
                                    <a href="{{ route('google_login') }}" class="btn btn-google btn-user btn-block">
                                        <i class="fab fa-google fa-fw"></i> Masuk dengan Akun Google
                                    </a>
                                </form>
                                <hr>
                                {{-- <div class="text-center">
                                    <a class="small" href="{{ route('forgot') }}">Lupa Password?</a>
                            </div> --}}
                            @php
                            $dftaw = date('Ymd', strtotime($sch->dft_mulai));
                            $dftakh = date('Ymd', strtotime($sch->dft_sampai));
                            $skr = date('Ymd');
                            @endphp
                            @if ($skr >= $dftaw && $skr <= $dftakh) <div class="text-center">
                                <a class="small" href="{{ route('fregistrasi') }}">Belum Punya Akun, Buat Akun
                                    Baru!</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</div>

</div>

@endsection