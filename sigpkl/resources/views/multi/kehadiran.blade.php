@extends('layout.main')

@section('title', 'Kehadiran Siswa')

@section('isi')
<div class="container">
  <h3>KEHADIRAN SISWA</h3>
  <table class=" table table-striped">
    <thead>
      <tr>
        <th scope="col" scope="col">#</th>
        <th scope="col">Bukti Kegiatan</th>
        <th scope="col">Nama</th>
        <th scope="col">Jurusan</th>
        <th scope="col">Kelas</th>
        <th scope="col">Tanggal</th>
        <th scope="col">Status</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($siswa as $s)
      @php
      $hadir = app('App\Http\Controllers\CalendarsController')->cekKehadiran($jadw->id , $s->nis);
      $fi = app('App\Http\Controllers\CalendarsController')->cekFiKeh($jadw->id , $s->nis);
      $idh = app('App\Http\Controllers\CalendarsController')->cekIdh($jadw->id , $s->nis);
      @endphp
      <tr>
        <th scope="col">{{ $loop->iteration }}</th>
        <td>
          @if ($hadir == 1)
          @if ($fi != null)
          <div class=" row justify-content-center">
            <img src="{{ asset('/storage/absen/'.$fi) }}" alt="Bukti Kehadiran" style="width: 250px; height: 250px;">
          </div>
          @else
          <span class=" text-danger">Kosong</span>
          @endif
          @endif
        </td>
        <td>{{ $s->nama }}</td>
        <td>{{ $s->jurusan }}</td>
        <td>{{ $s->kelas }}</td>
        <td>{{ $jadw->tanggal }}</td>
        <td>
          @if ($hadir == 1)<span class=" badge badge-success">Hadir</span>
          @else
          <span class=" badge badge-danger">Tidak Hadir</span>
          @endif
        </td>
        <td>
          <form action="{{ route('hadirkan') }}" method="post" class=" d-inline">
            @csrf
            <input type="hidden" name="idk" value="{{ $jadw->id }}">
            <input type="hidden" name="id" value="{{ $idh }}">
            <input type="hidden" name="nis" value="{{ $s->nis }}">
            <input type="hidden" name="hadir" value="1">
            <button type="submit" class=" btn btn-sm btn-success">Hadir</button>
          </form>
          <form action="{{ route('tidak_hadir') }}" method="post" class=" d-inline">
            @csrf
            <input type="hidden" name="idk" value="{{ $jadw->id }}">
            <input type="hidden" name="id" value="{{ $idh }}">
            <input type="hidden" name="nis" value="{{ $s->nis }}">
            <input type="hidden" name="hadir" value="0">
            <button type="submit" class=" btn btn-sm btn-danger">Tidak Hadir</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection