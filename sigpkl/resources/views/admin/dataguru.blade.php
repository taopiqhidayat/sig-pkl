@extends('layout/main')

@section('title', 'Data Guru')

@section('isi')

<div class="container">

  <div class="row justify-content-center">
    <div class="col-md-11">

      <h3>DAFTAR GURU PEMBIMBING</h3>

      <div class=" row">
        <div class=" col-7">
          <div class=" row">
            <div class=" col-7">
              <form action="{{ route('kd_guru') }}" method="get">
                <div class=" input-group my-3">
                  <input type="text" class=" form-control" name="keywrd" id="keywrd" aria-describedby="search"
                    placeholder="Masukkan kata kunci">
                  <button type="submit" id="search" class=" btn btn-outline-info">Cari</button>
                </div>
              </form>
            </div>
            <div class=" col-5">
              <a href="{{route('tbh_guru')}}" class="btn btn-primary my-3">Tambah Data</a>
            </div>
          </div>
        </div>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nomor Induk</th>
            <th scope="col">Nama</th>
            <th scope="col">Jurusan</th>
            <th scope="col">No HP</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @if ($data == 0)
          <tr>
            <td colspan="6">
              <div class="row">
                <div class="col">
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div>
                      <strong>Kosong!</strong> Belum ada Guru yang mendaftar atau registrasi!!
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
                      <strong>Kosong!</strong> Guru yang dicari tidak ditemukan!!
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          @else
          @foreach ($guru as $g)
          <tr>
            <th scope="col">{{ $loop->iteration }}</th>
            <td>{{ $g->n_induk }}</td>
            <td>{{ $g->nama }}</td>
            <td>{{ $g->jurusan }}</td>
            <td>{{ $g->n_wa }}</td>
            <td>
              <form action="/detail_guru/{{$g->id}}" method="get" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-info ">Detail</button>
              </form>
              <form action="/edit_guru/{{$g->id}}" method="get" class=" d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-warning">Edit</button>
              </form>
              <form action="/hapus_guru/{{$g->id}}" method="post" class=" d-inline">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </td>
          </tr>
          @endforeach
          <div class=" text-gray-600 bg-secondary-50">
            {{ $guru->links() }}
          </div>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>


@endsection