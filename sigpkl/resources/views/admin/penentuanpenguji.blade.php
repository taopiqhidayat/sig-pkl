@extends('layout.main')

@section('title', 'Penentuan Penguji')

@section('isi')
<div class="container">
  <div class="row">
    <div class="col col-md-8">

      <h3>PENENTUAN PENGUJI</h3>

      <div class=" row">
        <div class=" col-7">
          <form action="{{ route('penentuan_penguji') }}" method="get">
            <div class=" input-group my-3">
              <input type="text" class=" form-control" name="keywrd" id="keywrd" aria-describedby="search"
                placeholder="Masukkan kata kunci">
              <button type="submit" id="search" class=" btn btn-outline-info">Cari</button>
            </div>
          </form>
        </div>
      </div>
      <table class=" table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Kelas</th>
            <th>Pembimbing</th>
            <th>Penguji</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $d)
          <tr>
            <th>{{ $loop->iteration }}</th>
            <td>{{ $d->nama_siswa }}</td>
            <td>{{ $d->jurusan }}</td>
            <td>{{ $d->kelas }}</td>
            <td>{{ $d->nama_guru }}</td>
            @foreach ($tes as $tst)
            @if ($tst->nis == $d->nis)
            @if ($tst->penguji != null)
            <td>
              {{ $tst->nama }}
            </td>
            @else
            <td><span class=" text-danger">Belum Ditentukan</span></td>
            @endif
            @if ($tst->tanggal != null)
            <td>
              {{ $tst->tanggal }}
            </td>
            @else
            <td><span class=" text-danger">Belum Ditentukan</span></td>
            @endif
            @if ($tst->waktu != null)
            <td>
              {{ $tst->waktu }}
            </td>
            @else
            <td><span class=" text-danger">Belum Ditentukan</span></td>
            @endif
            @endif
            @endforeach
            <td>
              <a href="/edit_penguji/{{$d->nis}}" class=" badge badge-warning">Edit</a>
            </td>
          </tr>
          @endforeach
          <div class=" text-gray-600 bg-secondary-50">
            {{ $data->links() }}
          </div>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection