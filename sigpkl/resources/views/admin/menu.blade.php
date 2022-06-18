@extends('layout.main')

@section('title', 'Kelola Menu')

@section('isi')
<div class="container">
  <div class="row">
    <div class="col col-md-7">
      <h3 class=" text-uppercase">Daftar Menu</h3>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Menu</th>
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($menu as $m)
          <tr>
            <th scope="col">{{ $loop->iteration }}</th>
            <td scope="col">{{ $m->menu }}</td>
            <td scope="col">
              @if ($m->aktif == 1)
              <a class="badge badge-success">Aktif</a>
              @else
              <a class="badge badge-danger">Tidak Aktif</a>
              @endif
            </td>
            <td>
              <form action="{{ route('aktif_menu') }}" method="post" class=" d-inline">
                @csrf
                <input type="hidden" name="id" value="{{ $m->id }}">
                <input type="hidden" name="aktif" value="1">
                <button type="submit" class="btn btn-success btn-sm">Aktifkan</button>
              </form>
              <form action="{{ route('aktif_menu') }}" method="post" class=" d-inline">
                @csrf
                <input type="hidden" name="id" value="{{ $m->id }}">
                <input type="hidden" name="aktif" value="0">
                <button type="submit" class="btn btn-danger btn-sm">Non-Aktifkan</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection