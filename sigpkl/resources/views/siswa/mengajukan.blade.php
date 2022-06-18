@extends('layout.main')

@section('title', 'Mengajukan')

@section('isi')
<div class="container">
  <div class="row justify-content-center">
    <div class="col col-md-8">
      <h3>PENGAJUAN</h3>
      <div class="card"">
        <div class=" card-body">
        <form action="{{route('store_ajuan')}}" method="post">
          @csrf
          <div class="row">
            <div class="col col-md-6">
              <input type="hidden" name="nis" value="{{ $siswa->nis }}">
              <div class="form-group">
                <label for="n_is">Nomor Induk Siswa</label>
                <input type="text" class="form-control" id="n_is" name="n_is" value="{{ $siswa->nis }}" disabled>
                <span class="text-danger">@error('n_is') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="nama">Nama Siswa</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $siswa->nama }}" disabled>
                <span class="text-danger">@error('nama') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="jurusan">Jurusan</label>
                <input type="text" class="form-control" id="jurusan" name="jurusan" value="{{ $siswa->jurusan }}"
                  disabled>
                <span class="text-danger">@error('jurusan') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="kelas">Kelas</label>
                <input type="text" class="form-control" id="kelas" name="kelas" value="{{ $siswa->kelas }}" disabled>
                <span class="text-danger">@error('kelas') {{ $message }} @enderror</span>
              </div>
            </div>
            <div class="col col-md-6">
              <input type="hidden" name="idi" value="{{$industri->id}}">
              <div class="form-group">
                <label for="nama_indu">Nama Industri</label>
                <input type="text" class="form-control" id="nama_indu" name="nama_indu" value="{{ $industri->nama }}"
                  disabled>
                <span class="text-danger">@error('nama') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="bidang">Bergerak di Bidang</label>
                <input type="text" class="form-control" id="bidang" name="bidang" value="{{ $industri->bidang }}"
                  disabled>
                <span class="text-danger">@error('bidang') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="menerima">Menerima Jurusan</label>
                <input type="text" class="form-control" id="menerima" name="menerima"
                  value="{{ $industri->menerima_jurusan }}" disabled>
                <span class="text-danger">@error('menerima') {{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat Industri</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $industri->alamat }}"
                  disabled>
                <span class="text-danger">@error('alamat') {{ $message }} @enderror</span>
              </div>
            </div>
          </div>
          <hr>
          <div class="form-group row">
            <input type="hidden" name="mulai" value="{{ $sch->pkl_mulai }}">
            <div class="col-sm-6 mb-3 mb-sm-0">
              <label for="tangmulai">Untuk Tanggal</label>
              <input type="text" class="form-control" id="tangmulai" name="tangmulai" value="{{ $sch->pkl_mulai }}"
                disabled>
              <span class="text-danger">@error('tangmulai') {{ $message }} @enderror</span>
            </div>
            <input type="hidden" name="sampai" value="{{ $sch->pkl_sampai }}">
            <div class=" col-sm-6">
              <label for="tangsampai">Sampai Tanggal</label>
              <input type="text" class="form-control" id="tangsampai" name="tangsampai" value="{{ $sch->pkl_sampai }}"
                disabled>
              <span class="text-danger">@error('tangsampai') {{ $message }} @enderror</span>
            </div>
          </div>
          <hr>
          <button type="submit" class="btn btn-success float-right mx-2">Kirim</button>
          <a href="/print_ajuan_saya/{{$industri->id}}" class="btn btn-primary float-right mx-2"
            target="__blank">Print</a>
          <a href="{{route('plh_industri')}}" class="btn btn-danger float-right mx-2">Batal</a>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
@endsection