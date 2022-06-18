@extends('layout.main')

@section('title', 'Hasil Kerja Siswa')

@section('isi')

@if (Auth::user()->is_admin == 1)
<div class="container">

  <div class="row">
    <div class="col">

      <h3>HASIL KERJA SISWA</h3>

      @if ($data == 0)
      <div class="row">
        <div class="col col-md-6">
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <div>
              <strong>Kosong!</strong> Belum ada yang mengerjakan tugas!!
            </div>
          </div>
        </div>
      </div>
      @else
      <div class=" row">
        @foreach ($haskersis as $hks)
        <div class=" col col-md-4">
          <div class="card text-left mt-3">
            <div class="card-body">
              <?php
                $tangaw = strtotime($hks->updated_at);
                $tangah = strtotime($kuis->tangankhir . $kuis->wakakhir);
                $telat = $tangah - $tangaw;
                $hari_telat = floor($telat/(60*60*24));
                $jm_telat = $telat - $hari_telat * (60*60*24);
                $jam_telat = floor($jm_telat/(60*60));
                $mnt_telat = $jm_telat - $jam_telat *(60*60);
                $menit_telat = floor($mnt_telat/60);
                $dtk_telat = $mnt_telat - $menit_telat *(60);
                $detik_telat = floor($dtk_telat);
              ?>
              @if ($hks->nilai == null)
              <span class=" text-danger float-right">Belum Mengerjakan</span>
              @endif
              <h4 class="card-title">{{ $hks->nama }}</h4>
              <h6 class="card-subtitle mb-2 text-muted">{{ $hks->kelas . '('. $hks->jurusan .')' }}</h6>
              <p class="card-text">Kuis: {{ $kuis->kuis }}</p>
              <hr>
              <span class="card-subtitle mb-2 text-danger">
                @if ($tangaw > $tangah)
                @if ($hari_telat > 0)
                (Terlambat {{$hari_telat}} hari,
                {{ $jam_telat . ' : ' . $menit_telat  . ' : ' . $detik_telat }})
                @elseif ($jam_telat > 0 && $hari_telat == 0)
                (Terlambat
                {{ $jam_telat . ' jam ' . $menit_telat  . ' menit ' . $detik_telat . ' detik '}})
                @elseif ($menit_telat > 0 && $jam_telat == 0 && $hari_telat == 0)
                (Terlambat
                {{ $menit_telat  . ' menit ' . $detik_telat . ' detik '}})
                @elseif ($detik_telat > 0 && $menit_telat == 0 && $jam_telat == 0 && $hari_telat == 0)
                (Terlambat {{ $detik_telat . ' detik '}})
                @endif
                @endif
              </span>
              <h5 class="text-muted">Nilai: {{ $hks->nilai }}</h5>
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