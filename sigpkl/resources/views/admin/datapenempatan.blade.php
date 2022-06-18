@extends('layout/main')

@section('title', 'Data Penempatan')

@section('isi')

<div class="container">

  <div class="row justify-content-center">
    <div class="col-md-11">

      <h3>DAFTAR PENEMPATAN SISWA</h3>

      <div class=" row">
        <div class=" col-7">
          <div class=" row">
            <div class=" col-7">
              <form action="{{ route('kd_penempatan') }}" method="get">
                <div class=" input-group my-3">
                  <input type="text" class=" form-control" name="keywrd" id="keywrd" aria-describedby="search"
                    placeholder="Masukkan kata kunci">
                  <button type="submit" id="search" class=" btn btn-outline-info">Cari</button>
                </div>
              </form>
            </div>
            <div class=" col-5">
              <a href="{{route('tbh_penempatan')}}" class="btn btn-primary my-3">Tambah Data</a>
            </div>
          </div>
        </div>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">Jurusan</th>
            <th scope="col">Kelas</th>
            <th scope="col">Guru Pembimbing</th>
            <th scope="col">Tempat</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @if ($data == 0)
          <tr>
            <td colspan="7">
              <div class="row">
                <div class="col">
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div>
                      <strong>Kosong!</strong> Belum ada siswa yang mendapatkan guru pembimbing atau tempat!!
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          @elseif ($cari == 0)
          <tr>
            <td colspan="6">
              <div class="row">
                <div class="col">
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div>
                      <strong>Kosong!</strong> Data yang dicari tidak ditemukan!!
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          @else
          @foreach ($penempatan as $tm)
          <tr>
            <th scope="col">{{ $loop->iteration }}</th>
            <td>{{ $tm->nama_siswa }}</td>
            <td>{{ $tm->jurusan }}</td>
            <td>{{ $tm->kelas }}</td>
            <td>{{ $tm->nama_guru }}</td>
            <td>{{ $tm->nama_indu }}</td>
            <td>
              <form action="/detail_penempatan/{{$tm->id}}" method="get" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-info ">Detail</button>
              </form>
              <form action="/edit_penempatan/{{$tm->id}}" method="get" class=" d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-warning">Edit</button>
              </form>
            </td>
          </tr>
          @endforeach
          <div class=" text-gray-600 bg-secondary-50">
            {{ $penempatan->links() }}
          </div>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection