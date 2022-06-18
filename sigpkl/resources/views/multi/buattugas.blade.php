@extends('layout.main')

@section('title', 'Buat Tugas')

@section('isi')
@if (Auth::user()->is_admin == 1)
<div class="container">
  <div class="row justify-content-center">
    <div class="col col-md-7">
      <h3>Buat Tugas</h3>
      <div class="card">
        <div class="card-body">
          <form action="{{route('store_tugas')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id" value="{{Auth::user()->id}}">
            <div class="form-group">
              <label for="judul">Judul</label>
              <input type="text" class="form-control form-control-user" id="judul" name="judul"
                placeholder="Masukkan Judul Tugas..." value="{{ old('judul') }}">
              <span class="text-danger">@error('judul') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <input type="text" class="form-control form-control-user" id="keterangan" name="keterangan"
                placeholder="Masukkan Keterangan Tugas..." value="{{ old('keterangan') }}">
              <span class="text-danger">@error('keterangan') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="file">File Pendukung</label>
              <input type="file" class="form-control form-control-user" id="file" name="file"
                placeholder="Masukkan File Pendukung..." value="{{ old('file') }}">
              <span class="text-danger">@error('file') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="jurusan">Jurusan</label>
              <select class="form-control form-select form-select-md" name="jurusan" id="jurusan">
                <option value="">Pilih Jurusan</option>
                @foreach( $jurusan as $data )
                <option value="{{ $data->jurusan }}">{{ $data->jurusan }}</option>
                @endforeach
              </select>
              <span class="text-danger">@error('jurusan') {{ $message }} @enderror</span>
            </div>
            <div class=" row">
              <div class=" col-md-5 mt-1">
                <div class="form-check d-inline">
                  <input class="form-check-input" type="checkbox" value="" id="individu" name="individu">
                  <label class="form-check-label" for="individu">
                    Untuk satu orang (opsional):
                  </label>
                </div>
              </div>
              <div class=" col-md">
                <div class=" form-inline">
                  <label for="siswa" class=" mr-2">Pilih Siswa</label>
                  <select class="form-control form-select form-select-md" name="siswa" id="siswa" style="width: 73%;">
                    <option value="">Pilih Siswa</option>
                    @foreach( $siswa as $data )
                    <option value="{{ $data->nis }}">{{ $data->kelas }} | {{ $data->nama }}</option>
                    @endforeach
                  </select>
                  <span class="text-danger">@error('siswa') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <label class=" d-block">Terakhir Pengiriman</label>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="tangakhir">Tanggal</label>
                <input type="date" class="form-control form-control-user" id="tangakhir" name="tangakhir"
                  placeholder="Masukkan Terakhir Pengiriman..." value="{{ old('tangakhir') }}">
                <span class="text-danger">@error('tangakhir') {{ $message }} @enderror</span>
              </div>
              <div class="col-sm-6">
                <label for="wakakhir">Waktu</label>
                <input type="time" class="form-control form-control-user" id="wakakhir" name="wakakhir"
                  placeholder="Masukkan Terakhir Pengiriman..." value="{{ old('wakakhir') }}">
                <span class="text-danger">@error('wakakhir') {{ $message }} @enderror</span>
              </div>
            </div>
            <a href="/tugas_siswa" class="btn btn-secondary float-right">Batal</a>
            <button type="submit" class="btn btn-primary">Buat</button>
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
      <h3>Buat Tugas</h3>
      <div class="card">
        <div class="card-body">
          <form action="{{route('store_tugas')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id" value="{{Auth::user()->id}}">
            <div class="form-group">
              <label for="judul">Judul</label>
              <input type="text" class="form-control form-control-user" id="judul" name="judul"
                placeholder="Masukkan Judul Tugas..." value="{{ old('judul') }}">
              <span class="text-danger">@error('judul') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <input type="text" class="form-control form-control-user" id="keterangan" name="keterangan"
                placeholder="Masukkan Keterangan Tugas..." value="{{ old('keterangan') }}">
              <span class="text-danger">@error('keterangan') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="file">File Pendukung</label>
              <input type="file" class="form-control form-control-user" id="file" name="file"
                placeholder="Masukkan File Pendukung..." value="{{ old('file') }}">
              <span class="text-danger">@error('file') {{ $message }} @enderror</span>
            </div>
            <div class=" row">
              <div class=" col-4 mt-1">
                <div class="form-check d-inline">
                  <input class="form-check-input" type="checkbox" value="" id="individu" name="individu">
                  <label class="form-check-label" for="individu">
                    Untuk satu orang (opsional):
                  </label>
                </div>
              </div>
              <div class=" col-8">
                <div class=" form-group">
                  <label for="siswa" class=" mr-2">Pilih Siswa</label>
                  <select class="form-control form-select form-select-md" name="siswa" id="siswa">
                    <option value="">Pilih Siswa</option>
                    @foreach( $siswa as $data )
                    @foreach( $tem as $t )
                    @if ($data->nis == $t->nis)
                    <option value="{{ $data->nis }}">{{ $data->kelas }} | {{ $data->nama }}</option>
                    @endif
                    @endforeach
                    @endforeach
                  </select>
                  <span class="text-danger">@error('siswa') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <label for="">Terakhir Pengiriman</label>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="tangakhir">Tanggal</label>
                <input type="date" class="form-control form-control-user" id="tangakhir" name="tangakhir"
                  placeholder="Masukkan Terakhir Pengiriman..." value="{{ old('tangakhir') }}">
                <span class="text-danger">@error('tangakhir') {{ $message }} @enderror</span>
              </div>
              <div class="col-sm-6">
                <label for="wakakhir">Waktu</label>
                <input type="time" class="form-control form-control-user" id="wakakhir" name="wakakhir"
                  placeholder="Masukkan Terakhir Pengiriman..." value="{{ old('wakakhir') }}">
                <span class="text-danger">@error('wakakhir') {{ $message }} @enderror</span>
              </div>
            </div>
            <a href="/tugas_siswa" class="btn btn-secondary float-right">Batal</a>
            <button type="submit" class="btn btn-primary">Buat</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endsection

@section('script')
<script>
  const centang = document.querySelector('#individu');

  centang.addEventListener('change', function() {
    centang.value = centang.checked ? 1 : 0;
    alert(centang.value);
  });
</script>
@endsection