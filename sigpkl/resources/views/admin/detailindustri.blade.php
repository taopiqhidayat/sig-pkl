@extends('layout.main')

@section('title', 'Detail Industri')

@section('isi')
<div class="container">
  <div class="row justify-content-center">
    <div class="col col-md-10">
      <h3>Detail Industri</h3>
      <div class="card">
        <div class="card-body">
          <div class="row g-0">
            <div class="col col-md-6">
              <form action="" method="post">
                @csrf
                <div class="form-group">
                  <label for="nama_indu">Nama Perusahaan</label>
                  <input type="text" class="form-control" id="nama_indu" name="nama_indu" value="{{ $industrie->nama }}"
                    disabled readonly>
                  <span class="text-danger">@error('nama_indu') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="bidang">Bidang</label>
                  <input type="text" class="form-control" id="bidang" name="bidang" value="{{ $industrie->bidang }}"
                    disabled readonly>
                  <span class="text-danger">@error('bidang') {{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                  <label for="provinsi_indu">Provinsi</label>
                  <input type="text" class="form-control" id="provinsi" name="provinsi"
                    value="{{ $industrie->provinsi }}" disabled readonly>
                  <span class="text-danger">@error('provinsi_indu') {{ $message }}
                    @enderror</span>
                </div>
                <div class="form-group">
                  <label for="kota_indu">Kota</label>
                  <input type="text" class="form-control" id="kota" name="kota" value="{{ $industrie->kota }}" disabled
                    readonly>
                  <span class="text-danger">@error('kota_indu') {{ $message }}
                    @enderror</span>
                </div>
            </div>
            <div class="col col-md-6">
              <div class="form-group">
                <label for="alamat_indu">Alamat</label>
                <input type="text" class="form-control" id="alamat_indu" name="alamat_indu"
                  value="{{ $industrie->alamat }}" disabled readonly>
                <span class="text-danger">@error('alamat_indu') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="email_indu">Alamat Email</label>
                <input type="email" class="form-control" id="email_indu" name="email_indu"
                  value="{{ $industrie->email }}" disabled readonly>
                <span class="text-danger">@error('email_indu') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="n_wa_indu">No HP</label>
                <input type="text" class="form-control" id="n_wa_indu" name="n_wa_indu" value="{{ $industrie->n_wa }}"
                  disabled readonly>
                <span class="text-danger">@error('n_wa_indu') {{ $message }} @enderror</span>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <label for="latitude">Latitude</label>
                  <input type="text" class="form-control" id="latitude" name="latitude"
                    value="{{ $industrie->latitude }}" disabled readonly>
                  <span class="text-danger">@error('latitude') {{ $message }} @enderror</span>
                </div>
                <div class=" col-sm-6">
                  <label for="longitude">Longitude</label>
                  <input type="text" class="form-control" id="longitude" name="longitude"
                    value="{{ $industrie->longitude }}" disabled readonly>
                  <span class="text-danger">@error('longitude') {{ $message }}
                    @enderror</span>
                </div>
              </div>
            </div>
          </div>
          <a href="{{route('kd_industri')}}" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection