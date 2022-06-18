@extends('layout.main')

@section('title', 'Profil Saya')

@section('isi')
<div class="container">
  <h3 class=" text-uppercase">Profil Saya</h3>

  @if (Auth::user()->is_admin == 1)
  <div class="row">
    <div class="col col-md-7">
      <div class="card">
        <div class="row g-0">
          <div class="col-md-4">
            @if ($user->foto == null)
            <img src="/images/default.png" class=" img-thumbnail" alt="profil_{{$user->name}}" height="180px">
            @else
            <img src="{{ asset('/storage/profil/'.$user->foto) }}" alt="profil_{{$user->name}}" height="180px">
            @endif
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title">{{ $user->name }}</h5>
              <h6 class="card-subttitle">{{ $user->email }}</h6>
              <p>{{ $user->n_wa }}</p>
              <hr>
              <h5>{{ $sch->nama }}</h5>
              <h6>{{ $sch->kesek }} ({{ $sch->ni_kesek }})</h6>
              <span>{{ $sch->alamat }}</span>
              <h6>Jadwal PKL</h6>
              <p>Pendaftaran PKL : {{ $sch->dft_mulai }} - {{ $sch->dft_sampai }}</p>
              <p>Pencarian Tempat: {{ $sch->clk_mulai }} - {{ $sch->clk_sampai }}</p>
              <p>Pelaksanaan PKL : {{ $sch->pkl_mulai }} - {{ $sch->pkl_sampai }}</p>
              <p>Penyusunan Laporan : {{ $sch->lap_mulai }} - {{ $sch->lap_sampai }}</p>
              <p>Pengujian/sidang: {{ $sch->uji_mulai }} - {{ $sch->uji_sampai }}</p>
              <a href="/edit_profil" class="btn btn-warning">Edit Profil</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  @if (Auth::user()->is_guru == 1)
  <div class="row">
    <div class="col col-md-7">
      <div class="card">
        <div class="row g-0">
          <div class="col-md-4">
            @if ($user->foto == null)
            <img src="/images/default.png" class=" img-thumbnail" alt="profil_{{$user->name}}" height="180px">
            @else
            <img src="{{ asset('/storage/profil/'.$user->foto) }}" alt="profil_{{$user->name}}" height="180px">
            @endif
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h4 class="card-title">{{ $guru->nama }} <small>({{ $guru->jk }})</small></h4>
              <h6 class="card-subttitle">{{ $guru->jurusan }}</h6>
              <p>{{ $guru->email }} ({{ $guru->n_wa }})</p>
              <p>{{ $guru->alamat }}</p>
              <p>{{ $guru->kota }} {{ $guru->provinsi }}</p>
              <a href="/edit_profil" class="btn btn-warning">Edit Profil</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  @if (Auth::user()->is_industri == 1)
  <div class="row">
    <div class="col col-md-7">
      <div class="card">
        <div class="row g-0">
          <div class="col-md-3">
            @if ($user->foto == null)
            <img src="/images/default.png" class=" img-thumbnail" alt="profil_{{$user->name}}" height="180px">
            @else
            <img src="{{ asset('/storage/profil/'.$user->foto) }}" alt="profil_{{$user->name}}" height="180px">
            @endif
          </div>
          <div class="col-md">
            <div class="card-body">
              <h4 class="card-title">{{ $indu->nama }} (Pimpinan: {{$indu->ketua}})</h4>
              <h6 class="card-subttitle">{{ $indu->bidang }} (Menerima Jurusan: {{$indu->menerima_jurusan}})</h6>
              <p>{{ $indu->email }} ({{ $indu->n_wa }})</p>
              <p>{{ $indu->alamat }}</p>
              <p>{{ $indu->kota }} {{ $indu->provinsi }}</p>
              <a href="/edit_profil" class="btn btn-warning">Edit Profil</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  @if (Auth::user()->is_siswa == 1)
  <div class="row">
    <div class="col col-md-7">
      <div class="card">
        <div class="row g-0">
          <div class="col-md-4">
            @if ($user->foto == null)
            <img src="/images/default.png" class=" img-thumbnail" alt="profil_{{$user->name}}" height="180px">
            @else
            <img src="{{ asset('/storage/profil/'.$user->foto) }}" alt="profil_{{$user->name}}" height="180px">
            @endif
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h4 class="card-title">{{ $siswa->nama }} <small>({{ $siswa->jk }})</small></h4>
              <h6 class="card-subttitle">{{ $siswa->kelas }} ({{ $siswa->jurusan }})</h6>
              <p>{{ $siswa->email }} ({{ $siswa->n_wa }})</p>
              <p>{{ $siswa->alamat }}</p>
              <p>{{ $siswa->kota }} {{ $siswa->provinsi }}</p>
              <a href="/edit_profil" class="btn btn-warning">Edit Profil</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
</div>
@endsection