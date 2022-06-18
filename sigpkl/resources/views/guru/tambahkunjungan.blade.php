@extends('layout/main')

@section('title', 'Tambah Kunjungan')

@section('isi')

<div class="container">

  <div class="row justify-content-center">
    <div class="col-8">

      <h3>TAMBAH KUNJUNGAN</h3>

      <div class="card text-left">
        <div class="card-body">
          <form action="{{route('store_kunjungan')}}" method="post">
            @csrf
            <div class="form-group">
              <label for="industri">Kunjungan ke</label>
              <select class="form-control form-select form-select-md" name="industri" id="industri">
                <option value="">Pilih Industri</option>
                @foreach( $industri as $data )
                <option value="{{ $data->id }}">{{ $data->nama }}</option>
                @endforeach
              </select>
              <span class="text-danger">@error('industri') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="knsiswa">Kondisi Siswa</label>
              <textarea rows="2" class="form-control" id="knsiswa" name="knsiswa" placeholder="Kondisi Siswa..."
                value="{{ old('knsiswa')}}"></textarea>
              <span class="text-danger">@error('knsiswa') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="knindu">Kondisi Industri</label>
              <textarea rows="2" class="form-control" id="knindu" name="knindu" placeholder="Kondisi Industri..."
                value="{{ old('knindu')}}"></textarea>
              <span class="text-danger">@error('knindu') {{ $message }}
                @enderror</span>
            </div>
            <div class="form-group">
              <label for="khnsiswa">Keluhan Siswa (jika ada)</label>
              <textarea rows="2" class="form-control" id="khnsiswa" name="khnsiswa" placeholder="Keluhan Siswa..."
                value="{{ old('khnsiswa')}}"></textarea>
              <span class="text-danger">@error('khnsiswa') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="khnindu">Keluhan Industri (jika ada)</label>
              <textarea rows="2" class="form-control" id="khnindu" name="khnindu" placeholder="Keluhan Industri..."
                value="{{ old('khnindu')}}"></textarea>
              <span class="text-danger">@error('khnindu') {{ $message }}
                @enderror</span>
            </div>
            <div class="form-group">
              <label for="kinsiswa">Kinerja Siswa</label>
              <textarea rows="2" class="form-control" id="kinsiswa" name="kinsiswa" placeholder="Kinerja Siswa"
                value="{{ old('kinsiswa')}}"></textarea>
              <span class="text-danger">@error('kinsiswa') {{ $message }}
                @enderror</span>
            </div>
            <a href="{{ route('kunjungan') }}" class="btn btn-secondary float-right">Batal</a>
            <button type="submit" class="btn btn-primary">Tambah</button>
          </form>
        </div>
      </div>

    </div>
  </div>

</div>

@endsection