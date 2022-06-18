@extends('layout/main')

@section('title', 'Pengajuan Siswa')

@section('isi')

<div class="container">

  <div class="row">
    <div class="col-md-5 overflow-auto" style="max-height: 450px">

      <h3>DAFTAR PENGAJUAN SISWA</h3>
      <a target="__blank" href="/print_ajuan_saya/{{$idi->id}}" class="btn btn-primary my-2">Print Surat
        Pengantar</a>
      @if ($data == 0)
      <div class="row mt-3">
        <div class="col">
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <div>
              <strong>Kosong!</strong> Belum ada yang mengajukan untuk magang di tempat Anda!!
            </div>
          </div>
        </div>
      </div>
      @else
      @foreach ($aju as $aj)
      @if ($aj->diterima != 1)
      <div class="card text-left mt-3">
        <div class="card-body">
          <h4 class="card-title d-inline">{{$aj->nama}}</h4> <small>({{$aj->jk}})</small>
          <h6 class="card-subtitle my-1 text-muted">Tanggal: {{$aj->mulai}} - {{$aj->sampai}}</h6>
          <p>Kelas: {{$aj->kelas}} (Jurusan: {{$aj->jurusan}})</p>
          <hr>
          <form action="{{route('terima_pengajuan')}}" method="post">
            @csrf
            <input type="hidden" name="terima" value="1">
            <input type="hidden" name="id" value="{{$aj->id}}">
            <input type="hidden" name="nis" value="{{$aj->nis}}">
            <div class=" row">
              <div class="col">
                <label for="masuk">Waktu Masuk</label>
                <input type="time" name="masuk" id="masuk">
                <span class="text-danger">@error('masuk') {{ $message }} @enderror</span>
              </div>
              <div class="col">
                <label for="keluar">Wakktu Keluar</label>
                <input type="time" name="keluar" id="keluar">
                <span class="text-danger">@error('keluar') {{ $message }} @enderror</span>
              </div>
            </div>
            <button type="submit" class="btn btn-success mt-1 btn-block">Terima</button>
          </form>
          <form action="{{route('tolak_pengajuan')}}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$aj->id}}">
            <input type="hidden" name="terima" value="0">
            <button href="" class="btn btn-danger mt-1 btn-block">Tolak</button>
          </form>
        </div>
      </div>
      @endif
      @endforeach
    </div>
    <div class=" col"></div>
    <div class="col-md-5 overflow-auto" style="max-height: 450px">
      <h3>DAFTAR JAM KERJA SISWA</h3>

      @foreach ($aju as $aj)
      @if ($aj->diterima == 1)
      <div class="card text-left mt-3">
        <div class="card-body">
          <h4 class="card-title">{{$aj->nama}} <small>({{$aj->jk}})</small></h4>
          <h6 class="card-subtitle mb-2 text-muted">Tanggal {{$aj->mulai}} - {{$aj->sampai}}</h6>
          <p>Kelas: {{$aj->kelas}} (Jurusan: {{$aj->jurusan}})</p>
          <hr>
          <form action="" method="post">
            @csrf
            <input type="hidden" name="terima" value="1">
            <input type="hidden" name="id" value="{{$aj->id}}">
            <input type="hidden" name="nis" value="{{$aj->nis}}">
            <div class=" row">
              <div class="col">
                <label for="masuk">Waktu Masuk</label>
                <input type="time" name="masuk" id="masuk" value="{{$aj->waktu_masuk}}">
                <span class="text-danger">@error('masuk') {{ $message }} @enderror</span>
              </div>
              <div class="col">
                <label for="keluar">Wakktu Keluar</label>
                <input type="time" name="keluar" id="keluar" value="{{$aj->waktu_keluar}}">
                <span class="text-danger">@error('keluar') {{ $message }} @enderror</span>
              </div>
            </div>
            <button type="submit" class="btn btn-warning mt-1 btn-block">Ubah</button>
          </form>
        </div>
      </div>
      @endif
      @endforeach
    </div>
  </div>

  @endif

</div>

@endsection