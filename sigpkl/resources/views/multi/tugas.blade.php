@extends('layout.main')

@section('title', 'Tugas')

@section('isi')

@if (Auth::user()->is_admin == 1)
<div class="container">

  <div class="row">
    <div class="col">

      <h3>DATA TUGAS</h3>

      <a href="{{ route('buat_tugas') }}" class="btn btn-primary mb-3 mt-4">Tambah Tugas</a>
      <a href="/buat_kuis/0" class="btn btn-primary mb-3 mt-4">Tambah Kuis</a>

      @if ($jumtug == 0 && $jumkuis == 0)
      <div class="row">
        <div class="col col-md-6">
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <div>
              <strong>Kosong!</strong> Anda belum membuat tugas!!
            </div>
          </div>
        </div>
      </div>
      @elseif ($jumtug > 0 || $jumkuis > 0)
      <div class=" row">
        @foreach ($tugas as $tgs)
        <div class=" col-6">
          <div class="card text-left mb-2">
            <div class="card-body">
              <span class=" text-muted float-right">Terakhir: {{$tgs->tangakhir . ' ' . $tgs->wakakhir}}</span>
              <h4 class="card-title">{{ $tgs->judul }}</h4>
              <h5 class="card-subtitle mb-2 text-muted">{{ $tgs->keterangan }}</h5>
              <h6 class="card-subtitle mb-2 text-muted">{{ $tgs->jurusan }}</h6>
              @php
              $untuk = app('App\Http\Controllers\TasksController')->getUntuk($tgs->untuk);
              @endphp
              @if ($tgs->untuk != null)
              <h6 class="card-subtitle mb-2 text-muted">{{ $untuk->nama }} | {{ $untuk->kelas }}</h6>
              @endif
              <a href="/hasil_kerja/{{$tgs->id}}" class="badge badge-info">Hasil Kerja Siswa</a>
              <a href="/edit_tugas/{{$tgs->id}}" class="badge badge-warning">Edit</a>
            </div>
          </div>
        </div>
        @endforeach
        @foreach ($kuis as $kui)
        <div class=" col-6">
          <div class="card mb-2 text-left">
            <div class="card-body">
              <span class=" text-muted float-right">Terakhir: {{$kui->tangakhir . ' ' . $kui->wakakhir}}</span>
              <h4 class="card-title">{{ $kui->kuis }}</h4>
              <h5 class="card-subtitle mb-2 text-muted">{{ $kui->jurusan }}</h5>
              @php
              $untuk = app('App\Http\Controllers\TasksController')->getUntuk($kui->untuk);
              @endphp
              @if ($kui->untuk != null)
              <h6 class="card-subtitle mb-2 text-muted">{{ $untuk->nama }} | {{ $untuk->kelas }}</h6>
              @endif
              <a href="/hasil_kuis/{{$kui->id}}" class="badge badge-info">Hasil Kuis Siswa</a>
              <a href="/edit_kuis/{{$kui->id}}" class="badge badge-warning">Edit</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @endif

    </div>
  </div>
</div>
@endif

@if (Auth::user()->is_industri == 1)
<div class="container">

  <div class="row">
    <div class="col">

      <h3>DATA TUGAS</h3>

      <a href="{{ route('buat_tugas') }}" class="btn btn-primary mb-3 mt-4">Tambah Tugas</a>

      @if ($jumtug == 0)
      <div class="row">
        <div class="col col-md-6">
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <div>
              <strong>Kosong!</strong> Anda belum membuat tugas!!
            </div>
          </div>
        </div>
      </div>
      @elseif ($jumtug > 0)
      <div class=" row">
        @foreach ($tugas as $tgs)
        <div class=" col-6">
          <div class="card text-left mb-2">
            <div class="card-body">
              <span class=" text-muted float-right">Terakhir: {{$tgs->tangakhir . ' ' . $tgs->wakakhir}}</span>
              <h4 class="card-title">{{ $tgs->judul }}</h4>
              <h5 class="card-subtitle mb-2 text-muted">{{ $tgs->tanggal }}</h5>
              @php
              $untuk = app('App\Http\Controllers\TasksController')->getUntuk($tgs->untuk);
              @endphp
              @if ($tgs->untuk != null)
              <h6 class="card-subtitle mb-2 text-muted">{{ $untuk->nama }}</h6>
              @endif
              <p class="card-text">{{$tgs->keterangan}}</p>
              <a href="/hasil_kerja/{{$tgs->id}}" class="badge badge-info">Hasil Kerja Siswa</a>
              <a href="/edit_tugas/{{$tgs->id}}" class="badge badge-warning">Edit</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @endif

    </div>
  </div>
</div>
@endif

@if (Auth::user()->is_siswa == 1)
<div class="container">

  <div class="row">
    <div class="col">

      <h3>TUGAS SAYA</h3>

      @if ($idi == null)
      <div class="row">
        <div class="col col-md-6">
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <div>
              <strong>Kosong!</strong> Anda belum mendapatkan tempat PKL!!
            </div>
          </div>
        </div>
      </div>
      @elseif ($jumtug == 0 && $jumtug_sch == 0 && $jumkuis == 0)
      <div class="row">
        <div class="col col-md-6">
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <div>
              <strong>Kosong!</strong> Anda belum memiliki tugas dari siapapun!!
            </div>
          </div>
        </div>
      </div>
      @elseif ($jumtug > 0 || $jumtug_sch > 0 || $jumkuis > 0)
      <div class=" row">
        @foreach ($tugas as $tgs)
        <div class=" col-6">
          <div class="card text-left mb-3">
            <div class="card-body">
              @foreach ($mytugas as $mytgs)
              @php
              $sekarang = time();
              $tangaw = strtotime($mytgs->updated_at);
              $tangah = strtotime($tgs->tangankhir . $tgs->wakakhir);
              $sisa = $tangah - $sekarang;
              $hari = floor($sisa/(60*60*24));
              $jm = $sisa - $hari * (60*60*24);
              $jam = floor($jm/(60*60));
              $mnt = $jm - $jam *(60*60);
              $menit = floor($mnt/60);
              $dtk = $mnt - $menit *(60);
              $detik = floor($dtk);

              $telat = $tangah - $tangaw;
              $hari_telat = floor($telat/(60*60*24));
              $jm_telat = $telat - $hari_telat * (60*60*24);
              $jam_telat = floor($jm_telat/(60*60));
              $mnt_telat = $jm_telat - $jam_telat *(60*60);
              $menit_telat = floor($mnt_telat/60);
              $dtk_telat = $mnt_telat - $menit_telat *(60);
              $detik_telat = floor($dtk_telat);
              @endphp
              @if ($mytgs->id_tugas == $tgs->id)
              @else
              <span class="card-subtitle mb-2 text-muted float-right">
                Tersisa {{$hari}} hari, {{ $jam . ' : ' . $menit . ' : ' . $detik }}
              </span>
              @endif
              @endforeach
              <h4 class="card-title">{{ $tgs->judul }}</h4>
              <h6 class="card-subtitle mb-2 text-muted">{{ $tgs->tangakhir . ' ' . $tgs->wakakhir }}</h6>
              <p class="card-text">{{ $tgs->keterangan }}</p>
              <hr>
              <form action="{{ route('serahkan_tugas') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ids" id="ids" value="{{ Auth::user()->id }}">
                <input type="hidden" name="idt" id="idt" value="{{ $tgs->id }}">
                <div class=" form-group">
                  <label for="file">Hasil Kerja Saya</label>
                  <input type="file" name="file" id="file" class=" form-control">
                  <span class="text-danger">@error('file') {{ $message }} @enderror</span>
                </div>
                <button type="submit" class="btn btn-primary d-inline">Serahkan</button>
                @foreach ($mytugas as $mytgs)
                @if ($mytgs->id_tugas == $tgs->id)
                <p class=" d-inline ml-1">Selesai
                  @if ($tangaw > $tangah)
                  @if ($hari_telat > 0)
                  <span class=" text-danger">(Terlambat {{$hari_telat}} hari,
                    {{ $jam_telat . ' : ' . $menit_telat . ' : ' . $detik_telat }})</span>
                  @elseif ($jam_telat > 0 && $hari_telat == 0)
                  <span class=" text-danger">(Terlambat
                    {{ $jam_telat . ' jam ' . $menit_telat . ' menit ' . $detik_telat . ' detik '}})</span>
                  @elseif ($menit_telat > 0 && $jam_telat == 0 && $hari_telat == 0)
                  <span class=" text-danger">(Terlambat
                    {{ $menit_telat . ' menit ' . $detik_telat . ' detik '}})</span>
                  @elseif ($detik_telat > 0 && $menit_telat == 0 && $jam_telat == 0 && $hari_telat == 0)
                  <span class=" text-danger">(Terlambat {{ $detik_telat . ' detik '}})</span>
                  @endif
                  @endif
                </p>
                @endif
                @endforeach
              </form>
            </div>
          </div>
        </div>
        @endforeach

        @foreach ($tugas_sch as $tgs_sch)
        <div class=" col-6">
          <div class="card text-left mb-3">
            <div class="card-body">
              @foreach ($mytugas as $mytgs)
              @php
              $hariini = date('Ymd');
              $ngirim = date('Ymd', strtotime($mytgs->updated_at));
              $tangakhir = date('Ymd', strtotime($tgs_sch->tangakhir));
              $sekarang = time();
              $tangaw = strtotime($mytgs->updated_at);
              $tangah = strtotime($tgs_sch->wakakhir);
              $tersisa = $tangakhir - $hariini;
              $sisa = $tangah - $sekarang;
              $hari = floor($sisa/(60*60*24));
              $jm = $sisa - $hari * (60*60*24);
              $jam = floor($jm/(60*60));
              $mnt = $jm - $jam *(60*60);
              $menit = floor($mnt/60);
              $dtk = $mnt - $menit *(60);
              $detik = floor($dtk);

              $terlambat = $ngirim - $tangakhir;
              $telat = $tangaw - $tangah;
              $hari_telat = floor($telat/(60*60*24));
              $jm_telat = $telat - $hari_telat * (60*60*24);
              $jam_telat = floor($jm_telat/(60*60));
              $mnt_telat = $jm_telat - $jam_telat *(60*60);
              $menit_telat = floor($mnt_telat/60);
              $dtk_telat = $mnt_telat - $menit_telat *(60);
              $detik_telat = floor($dtk_telat);

              $terlewat = $hariini - $tangakhir;
              $lewat = $sekarang - $tangah;
              $hari_lewat = floor($lewat/(60*60*24));
              $jm_lewat = $lewat - $hari_lewat * (60*60*24);
              $jam_lewat = floor($jm_lewat/(60*60));
              $mnt_lewat = $jm_lewat - $jam_lewat *(60*60);
              $menit_lewat = floor($mnt_lewat/60);
              $dtk_lewat = $mnt_lewat - $menit_lewat *(60);
              $detik_lewat = floor($dtk_lewat);
              @endphp
              <span class="card-subtitle mb-2 text-muted float-right">
                @if ($mytgs->id_tugas != $tgs_sch->id && $hariini <= $tangakhir) Tersisa {{$tersisa}} hari, {{ $jam
                  . ' : ' . $menit . ' : ' . $detik }} @elseif ($mytgs->id_tugas != $tgs_sch->id && $hariini >
                  $tangakhir)
                  Lewat {{$terlewat}} hari, {{ $jam_lewat . ' : ' . $menit_lewat . ' : ' . $detik_lewat }}
                  @endif
              </span>
              @endforeach
              <h4 class="card-title">{{ $tgs_sch->judul }}</h4>
              <h6 class="card-subtitle mb-2 text-muted">{{ $tgs_sch->tangakhir . ' ' . $tgs_sch->wakakhir }}</h6>
              <p class="card-text">{{ $tgs_sch->keterangan }}</p>
              <hr>
              <form action="{{ route('serahkan_tugas') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ids" id="ids" value="{{ Auth::user()->id }}">
                <input type="hidden" name="idt" id="idt" value="{{ $tgs_sch->id }}">
                <div class=" form-group">
                  <label for="file">Hasil Kerja Saya</label>
                  <input type="file" name="file" id="file" class=" form-control">
                  <span class="text-danger">@error('file') {{ $message }} @enderror</span>
                </div>
                <button type="submit" class="btn btn-primary d-inline">Serahkan</button>
                @foreach ($mytugas as $mytgs)
                @if ($mytgs->id_tugas == $tgs_sch->id)
                <p class=" d-inline ml-1">Selesai
                  @if ($ngirim > $tangakhir)
                  @if ($terlewat > 0)
                  (Terlambat {{$terlewat}} hari, {{ $jam_telat . ' : ' . $menit_telat . ' : ' . $detik_telat }})
                  @elseif ($jam_telat > 0)
                  (Terlambat {{ $jam_telat . ' jam ' . $menit_telat . ' menit ' . $detik_telat . ' detik '}})
                  @elseif ($menit_telat > 0)
                  (Terlambat {{ $menit_telat . ' menit ' . $detik_telat . ' detik '}})
                  @elseif ($detik_telat > 0)
                  (Terlambat {{ $detik_telat . ' detik '}})
                  @endif
                  @endif
                </p>
                @endif
                @endforeach
              </form>
            </div>
          </div>
        </div>
        @endforeach

        @foreach ($kuis as $kui)
        <div class=" col-6">
          <div class=" card text-left mb-3">
            <div class=" card-body">
              <h4 class="card-title">{{ $kui->kuis }}</h4>
              <h6 class="card-subtitle mb-2 text-muted">Batas Waktu:
                {{ $tgs_sch->tangakhir . ' ' . $tgs_sch->wakakhir }}</h6>
              <hr>
              <a href="/mengisi_kuis/{{ $kui->id }}" class=" btn btn-primary">Isi Kuis</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @endif

    </div>
  </div>
</div>
@endif

@endsection