@extends('layout.main')

@section('title', 'Reset Password')

@section('isi')

<div class="container">

  <!-- Outer Row -->
  <div class="row">

    <div class="col-sm-12 col-md-8">

      <h3 class="mb-2 text-uppercase">Ganti Username dan Password</h3>
      <div class="card">
        <div class="card-body p-0">
          <div class="p-5">
            <div class="text-center">
            </div>
            <form action="{{ route('reset_username') }}" method="post" class="user">
              @csrf
              <div class="form-group">
                <label for="usnmama">Username Lama</label>
                <input type="text" class="form-control" name="usnmama" id="usnmama" aria-describedby="usnmama"
                  value="{{ old('usnmama') }}" placeholder="Masukkan Username Lama Anda...">
                <span class="text-danger">@error('usnmama') {{ $message }} @enderror</span>
              </div>
              <div class=" form-group">
                <label for="usnmbaru">Username Baru</label>
                <input type="text" class="form-control" name="usnmbaru" id="usnmbaru" aria-describedby="usnmbaru"
                  value="{{ old('usnmbaru') }}" placeholder="Masukkan Username Baru Anda...">
                <span class="text-danger">@error('usnmbaru') {{ $message }} @enderror</span>
              </div>
              <button type="submit" class=" btn btn-danger">Ganti Username</button>
            </form>
            <hr>
            <form action="{{ route('reset_password') }}" method="post" class="user">
              @csrf
              <div class="form-group">
                <label for="asswrdama">Password Lama</label>
                <input type="password" class="form-control" name="asswrdama" id="asswrdama" aria-describedby="asswrdama"
                  placeholder="Masukkan Password Lama Anda...">
                <span class="text-danger">@error('asswrdama') {{ $message }} @enderror</span>
              </div>
              <div class="form-group row">
                <div class=" col-6">
                  <label for="asswrdbaru">Password Baru</label>
                  <input type="password" class="form-control" name="asswrdbaru" id="asswrdbaru"
                    aria-describedby="asswrdbaru" placeholder="Masukkan Password Baru...">
                  <span class="text-danger">@error('asswrdbaru') {{ $message }} @enderror</span>
                </div>
                <div class=" col-6">
                  <label for="asswrdbaru_confirmation">Konfirmasi Password</label>
                  <input type="password" class="form-control" name="asswrdbaru_confirmation"
                    id="asswrdbaru_confirmation" aria-describedby="asswrdbaru_confirmation"
                    placeholder="Konfirmasi Password...">
                  <span class="text-danger">@error('asswrdbaru_confirmation') {{ $message }} @enderror</span>
                </div>
              </div>
              <a href="/edit_profil" class=" btn btn-secondary float-right">Batal</a>
              <button type="submit" class="btn btn-danger">Ganti Password</button>
            </form>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>

@endsection