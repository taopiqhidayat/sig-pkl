@extends('layout/main')

@section('title', 'Edit Kunjungan')

@section('isi')

<div class="container">

  <div class="row justify-content-center">
    <div class="col-8">

      <h3>EDIT KUNJUNGAN</h3>

      <div class="card text-left">
        <div class="card-body">
          <form action="{{route('update_kunjungan')}}" method="post">
            @csrf
            <div class="form-group">
              <label for="industri">Kunjungan ke</label>
              <select class="form-control form-select form-select-md" name="industri" id="industri">
                <option value="">Pilih Industri</option>
                @foreach( $industri as $data )
                @if ($data->id == $visit->id_industri)
                <option value="{{ $indu->id }}" selected>{{ $indu->nama }}</option>
                @endif
                <option value="{{ $data->id }}">{{ $data->nama }}</option>
                @endforeach
              </select>
              <span class="text-danger">@error('industri') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="knsiswa">Kondisi Siswa</label>
              <textarea class="form-control" id="knsiswa" name="knsiswa" value="{{ $visit->kondisi_siswa}}"></textarea>
              <span class="text-danger">@error('knsiswa') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="knindu">Kondisi Industri</label>
              <textarea class="form-control" id="knindu" name="knindu" value="{{ $visit->kondisi_industri}}"></textarea>
              <span class="text-danger">@error('knindu') {{ $message }}
                @enderror</span>
            </div>
            <div class="form-group">
              <label for="khnsiswa">Keluhan Siswa (jika ada)</label>
              <textarea class="form-control" id="khnsiswa" name="khnsiswa"
                value="{{ $visit->keluhan_siswa}}"></textarea>
              <span class="text-danger">@error('khnsiswa') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="khnindu">Keluhan Industri (jika ada)</label>
              <textarea class="form-control" id="khnindu" name="khnindu"
                value="{{ $visit->keluhan_industri}}"></textarea>
              <span class="text-danger">@error('khnindu') {{ $message }}
                @enderror</span>
            </div>
            <div class="form-group">
              <label for="kinsiswa">Kinerja Siswa</label>
              <textarea class="form-control" id="kinsiswa" name="kinsiswa"
                value="{{ $visit->kinerja_siswa }}"></textarea>
              <span class="text-danger">@error('kinsiswa') {{ $message }}
                @enderror</span>
            </div>
            <a href="{{ route('kunjungan') }}" class="btn btn-secondary float-right">Batal</a>
            <button type="submit" class="btn btn-warning">Edit</button>
          </form>
        </div>
      </div>

    </div>
  </div>

</div>

@endsection