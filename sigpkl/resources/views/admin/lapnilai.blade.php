@extends('layout/main')

@section('title', 'Laporan Nilai')

@section('isi')

<div class="container">

  <div class="row justify-content-center">
    <div class="col-sm-6 col-md-11">

      <h3>DAFTAR NILAI SISWA</h3>

      <table class="table mt-4">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">Jurusan</th>
            <th scope="col">Kelas</th>
            <th scope="col">Nilai Akhir</th>
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
                      <strong>Kosong!</strong> Belum ada siswa yang diberi nilai!!
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          @else
          @foreach ($nilai as $n)
          <tr>
            <th scope="col">{{ $loop->iteration }}</th>
            <td>{{ $n->nama}}</td>
            <td>{{ $n->jurusan}}</td>
            <td>{{ $n->kelas}}</td>
            @if ($n->nilai_akhir != null)
            <td>
              {{ $n->nilai_akhir}}
            </td>
            @else
            <td><span class=" text-danger">Belum Dinilai</span></td>
            @endif
            <td>
              <form action="/detail_nilai/{{ $n->id }}" method="get" class=" d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-info">Detail</button>
              </form>
              <form action="/edit_nilai/{{ $n->id }}" method="get" class=" d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-warning">Edit</button>
              </form>
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection