@extends('layout.main')

@section('title', 'Edit Tugas')

@section('isi')
@if (Auth::user()->is_admin == 1)
<div class="container">
  <div class="row justify-content-center">
    <div class="col col-md-7">
      <h3>Edit Tugas</h3>
      <div class="card">
        <div class="card-body">
          <form action="{{route('update_tugas')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id" value="{{Auth::user()->id}}">
            <input type="hidden" name="idt" id="idt" value="{{$task->id}}">
            <div class="form-group">
              <label for="judul">Judul</label>
              <input type="text" class="form-control form-control-user" id="judul" name="judul"
                placeholder="Masukkan Judul Tugas..." value="{{ $task->judul }}">
              <span class="text-danger">@error('judul') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <input type="text" class="form-control form-control-user" id="keterangan" name="keterangan"
                placeholder="Masukkan Keterangan Tugas..." value="{{ $task->keterangan }}">
              <span class="text-danger">@error('keterangan') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="file">File Pendukung</label>
              <input type="file" class="form-control form-control-user" id="file" name="file"
                placeholder="Masukkan File Pendukung..." value="{{ $task->file }}">
              <span class="text-danger">@error('file') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="jurusan">Jurusan</label>
              <select class="form-control form-select form-select-md" name="jurusan" id="jurusan">
                <option value="">Pilih Jurusan</option>
                @foreach( $jurusan as $data )
                @if ($data->jurusan == $task->jurusan)
                <option value="{{ $data->jurusan }}" selected>{{ $data->jurusan }}</option>
                @endif
                <option value="{{ $data->jurusan }}">{{ $data->jurusan }}</option>
                @endforeach
              </select>
              <span class="text-danger">@error('jurusan') {{ $message }} @enderror</span>
            </div>
            <label for="">Terakhir Pengiriman</label>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="tangakhir">Tanggal</label>
                <input type="date" class="form-control form-control-user" id="tangakhir" name="tangakhir"
                  placeholder="Masukkan Terakhir Pengiriman..." value="{{ $task->tangakhir }}">
                <span class="text-danger">@error('tangakhir') {{ $message }} @enderror</span>
              </div>
              <div class="col-sm-6">
                <label for="wakakhir">Waktu</label>
                <input type="time" class="form-control form-control-user" id="wakakhir" name="wakakhir"
                  placeholder="Masukkan Terakhir Pengiriman..." value="{{ $task->wakakhir }}">
                <span class="text-danger">@error('wakakhir') {{ $message }} @enderror</span>
              </div>
            </div>
            <a href="/tugas_siswa" class="btn btn-secondary float-right">Batal</a>
            <button type="submit" class="btn btn-warning">Edit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

@if (Auth::user()->is_industri == 1)
<div class="container">
  <div class="row justify-content-center">
    <div class="col col-md-7">
      <h3>Edit Tugas</h3>
      <div class="card">
        <div class="card-body">
          <form action="{{route('update_tugas')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id" value="{{Auth::user()->id}}">
            <input type="hidden" name="idt" id="idt" value="{{$task->id}}">
            <div class="form-group">
              <label for="judul">Judul</label>
              <input type="text" class="form-control form-control-user" id="judul" name="judul"
                placeholder="Masukkan Judul Tugas..." value="{{ $task->judul }}">
              <span class="text-danger">@error('judul') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <input type="text" class="form-control form-control-user" id="keterangan" name="keterangan"
                placeholder="Masukkan Keterangan Tugas..." value="{{ $task->keterangan }}">
              <span class="text-danger">@error('keterangan') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="file">File Pendukung</label>
              <input type="file" class="form-control form-control-user" id="file" name="file"
                placeholder="Masukkan File Pendukung..." value="{{ $task->file }}">
              <span class="text-danger">@error('file') {{ $message }} @enderror</span>
            </div>
            <label for="">Terakhir Pengiriman</label>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="tangakhir">Tanggal</label>
                <input type="date" class="form-control form-control-user" id="tangakhir" name="tangakhir"
                  placeholder="Masukkan Terakhir Pengiriman..." value="{{ $task->tangakhir }}">
                <span class="text-danger">@error('tangakhir') {{ $message }} @enderror</span>
              </div>
              <div class="col-sm-6">
                <label for="wakakhir">Waktu</label>
                <input type="time" class="form-control form-control-user" id="wakakhir" name="wakakhir"
                  placeholder="Masukkan Terakhir Pengiriman..." value="{{ $task->wakakhir }}">
                <span class="text-danger">@error('wakakhir') {{ $message }} @enderror</span>
              </div>
            </div>
            <a href="/tugas_siswa" class="btn btn-secondary float-right">Batal</a>
            <button type="submit" class="btn btn-warning">Edit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endsection