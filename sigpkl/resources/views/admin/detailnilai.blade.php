@extends('layout/main')

@section('title', 'Detail Nilai')

@section('isi')

<div class="container">

  <div class="row justify-content-center">
    <div class="col-sm-6 col-md-11">

      <h3>DETAIL NILAI</h3>

      @if ($nilai->nilai_akhir == null)
      <div class="row mt-3">
        <div class="col">
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <div>
              <strong>Kosong!</strong> Anda belum mendapatkan nilai!!
            </div>
          </div>
        </div>
      </div>
      @else
      <div class="card text-left">
        <div class="card-body">
          @php
          if ($nilai->nilai_akhir >= 80) {
          $hm = 'A';
          } elseif ($nilai->nilai_akhir >= 70) {
          $hm = 'B';
          } elseif ($nilai->nilai_akhir >= 60) {
          $hm = 'C';
          } elseif ($nilai->nilai_akhir >= 50) {
          $hm = 'D';
          } else {
          $hm = 'E';
          }
          @endphp
          <h5>{{ $siswa->nama }}</h5>
          <span>{{ $siswa->jurusan }} | {{ $siswa->kelas }}</span>
          <hr>
          <div class=" row">
            <div class=" col-4">
              <h4 class="card-title">Nilai Akhir: {{ $nilai->nilai_akhir }} ( {{ $hm }} )</h4>
            </div>
            <div class=" col-8">
              @if ($nilai->nilai_akhir >= 80)
              <h4 class="small font-weight-bold">Nilai Akhir <span class="float-right">{{$nilai->nilai_akhir}}%</span>
              </h4>
              <div class="progress mb-4">
                <div class="progress-bar bg-primary" role="progressbar" style="width: {{$nilai->nilai_akhir}}%"
                  aria-valuenow="{{$nilai->nilai_akhir}}" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              @elseif ($nilai->nilai_akhir >= 70)
              <h4 class="small font-weight-bold">Nilai Akhir <span class="float-right">{{$nilai->nilai_akhir}}%</span>
              </h4>
              <div class="progress mb-4">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{$nilai->nilai_akhir}}%"
                  aria-valuenow="{{$nilai->nilai_akhir}}" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              @elseif ($nilai->nilai_akhir >= 60)
              <h4 class="small font-weight-bold">Nilai Akhir <span class="float-right">{{$nilai->nilai_akhir}}%</span>
              </h4>
              <div class="progress mb-4">
                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$nilai->nilai_akhir}}%"
                  aria-valuenow="{{$nilai->nilai_akhir}}" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              @else
              <h4 class="small font-weight-bold">Nilai Akhir <span class="float-right">{{$nilai->nilai_akhir}}%</span>
              </h4>
              <div class="progress mb-4">
                <div class="progress-bar bg-danger" role="progressbar" style="width: {{$nilai->nilai_akhir}}%"
                  aria-valuenow="{{$nilai->nilai_akhir}}" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              @endif
            </div>
            <div class=" col-4">
              <h5>Detail Nilai</h5>
              <table class=" table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Kategori</th>
                    <th>Nilai</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Nilai Absen</td>
                    <td>{{ $nilai->nilai_absensi }}</td>
                  </tr>
                  <tr>
                    <td>Nilai Tugas</td>
                    <td>{{ $nilai->nilai_tugas }}</td>
                  </tr>
                  <tr>
                    <td>Nilai Laporan</td>
                    <td>{{ $nilai->nilai_laporan }}</td>
                  </tr>
                  <tr>
                    <td>Nilai Presentasi</td>
                    <td>{{ $nilai->nilai_presentasi }}</td>
                  </tr>
                  <tr>
                    <td>Nilai Pembimbing Lapangan</td>
                    <td>{{ $nilai->nilai_pemlapangan }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class=" col-8">
              <div class=" card">
                <div class=" card-body">
                  <h5>Detail Nilai</h5>
                  <section class="nilai_absensi">
                    @if ($nilai->nilai_absensi >= 80)
                    <h6 class="small font-weight-bold">Nilai Absensi <span
                        class="float-right">{{$nilai->nilai_absensi}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-4">
                      <div class=" progress-sm progress-bar bg-primary" role="progressbar"
                        style="width: {{$nilai->nilai_absensi}}%" aria-valuenow="{{$nilai->nilai_absensi}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @elseif ($nilai->nilai_absensi >= 70)
                    <h6 class="small font-weight-bold">Nilai Absensi <span
                        class="float-right">{{$nilai->nilai_absensi}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-4">
                      <div class=" progress-sm progress-bar bg-success" role="progressbar"
                        style="width: {{$nilai->nilai_absensi}}%" aria-valuenow="{{$nilai->nilai_absensi}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @elseif ($nilai->nilai_absensi >= 60)
                    <h6 class="small font-weight-bold">Nilai Absensi <span
                        class="float-right">{{$nilai->nilai_absensi}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-2">
                      <div class=" progress-sm progress-bar bg-warning" role="progressbar"
                        style="width: {{$nilai->nilai_absensi}}%" aria-valuenow="{{$nilai->nilai_absensi}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @else
                    <h6 class="small font-weight-bold">Nilai Absensi <span
                        class="float-right">{{$nilai->nilai_absensi}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-4">
                      <div class=" progress-sm progress-bar bg-danger" role="progressbar"
                        style="width: {{$nilai->nilai_absensi}}%" aria-valuenow="{{$nilai->nilai_absensi}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @endif
                  </section>
                  <section class="nilai_tugas">
                    @if ($nilai->nilai_tugas >= 80)
                    <h6 class="small font-weight-bold">Nilai Tugas <span
                        class="float-right">{{$nilai->nilai_tugas}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-4">
                      <div class=" progress-sm progress-bar bg-primary" role="progressbar"
                        style="width: {{$nilai->nilai_tugas}}%" aria-valuenow="{{$nilai->nilai_tugas}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @elseif ($nilai->nilai_tugas >= 70)
                    <h6 class="small font-weight-bold">Nilai Tugas <span
                        class="float-right">{{$nilai->nilai_tugas}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-4">
                      <div class=" progress-sm progress-bar bg-success" role="progressbar"
                        style="width: {{$nilai->nilai_tugas}}%" aria-valuenow="{{$nilai->nilai_tugas}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @elseif ($nilai->nilai_tugas >= 60)
                    <h6 class="small font-weight-bold">Nilai Tugas <span
                        class="float-right">{{$nilai->nilai_tugas}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-2">
                      <div class=" progress-sm progress-bar bg-warning" role="progressbar"
                        style="width: {{$nilai->nilai_tugas}}%" aria-valuenow="{{$nilai->nilai_tugas}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @else
                    <h6 class="small font-weight-bold">Nilai Tugas <span
                        class="float-right">{{$nilai->nilai_tugas}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-4">
                      <div class=" progress-sm progress-bar bg-danger" role="progressbar"
                        style="width: {{$nilai->nilai_tugas}}%" aria-valuenow="{{$nilai->nilai_tugas}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @endif
                  </section>
                  <section class="nilai_laporan">
                    @if ($nilai->nilai_laporan >= 80)
                    <h6 class="small font-weight-bold">Nilai Laporan <span
                        class="float-right">{{$nilai->nilai_laporan}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-4">
                      <div class=" progress-sm progress-bar bg-primary" role="progressbar"
                        style="width: {{$nilai->nilai_laporan}}%" aria-valuenow="{{$nilai->nilai_laporan}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @elseif ($nilai->nilai_laporan >= 70)
                    <h6 class="small font-weight-bold">Nilai Laporan <span
                        class="float-right">{{$nilai->nilai_laporan}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-4">
                      <div class=" progress-sm progress-bar bg-success" role="progressbar"
                        style="width: {{$nilai->nilai_laporan}}%" aria-valuenow="{{$nilai->nilai_laporan}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @elseif ($nilai->nilai_laporan >= 60)
                    <h6 class="small font-weight-bold">Nilai Laporan <span
                        class="float-right">{{$nilai->nilai_laporan}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-2">
                      <div class=" progress-sm progress-bar bg-warning" role="progressbar"
                        style="width: {{$nilai->nilai_laporan}}%" aria-valuenow="{{$nilai->nilai_laporan}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @else
                    <h6 class="small font-weight-bold">Nilai Laporan <span
                        class="float-right">{{$nilai->nilai_laporan}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-4">
                      <div class=" progress-sm progress-bar bg-danger" role="progressbar"
                        style="width: {{$nilai->nilai_laporan}}%" aria-valuenow="{{$nilai->nilai_laporan}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @endif
                  </section>
                  <section class="nilai_presentasi">
                    @if ($nilai->nilai_presentasi >= 80)
                    <h6 class="small font-weight-bold">Nilai Presentasi <span
                        class="float-right">{{$nilai->nilai_presentasi}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-4">
                      <div class=" progress-sm progress-bar bg-primary" role="progressbar"
                        style="width: {{$nilai->nilai_presentasi}}%" aria-valuenow="{{$nilai->nilai_presentasi}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @elseif ($nilai->nilai_presentasi >= 70)
                    <h6 class="small font-weight-bold">Nilai Presentasi <span
                        class="float-right">{{$nilai->nilai_presentasi}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-4">
                      <div class=" progress-sm progress-bar bg-success" role="progressbar"
                        style="width: {{$nilai->nilai_presentasi}}%" aria-valuenow="{{$nilai->nilai_presentasi}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @elseif ($nilai->nilai_presentasi >= 60)
                    <h6 class="small font-weight-bold">Nilai Presentasi <span
                        class="float-right">{{$nilai->nilai_presentasi}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-2">
                      <div class=" progress-sm progress-bar bg-warning" role="progressbar"
                        style="width: {{$nilai->nilai_presentasi}}%" aria-valuenow="{{$nilai->nilai_presentasi}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @else
                    <h6 class="small font-weight-bold">Nilai Presentasi <span
                        class="float-right">{{$nilai->nilai_presentasi}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-4">
                      <div class=" progress-sm progress-bar bg-danger" role="progressbar"
                        style="width: {{$nilai->nilai_presentasi}}%" aria-valuenow="{{$nilai->nilai_presentasi}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @endif
                  </section>
                  <section class="nilai_pemlapangan">
                    @if ($nilai->nilai_pemlapangan >= 80)
                    <h6 class="small font-weight-bold">Nilai Pembimbing Lapangan <span
                        class="float-right">{{$nilai->nilai_pemlapangan}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-4">
                      <div class=" progress-sm progress-bar bg-primary" role="progressbar"
                        style="width: {{$nilai->nilai_pemlapangan}}%" aria-valuenow="{{$nilai->nilai_pemlapangan}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @elseif ($nilai->nilai_pemlapangan >= 70)
                    <h6 class="small font-weight-bold">Nilai Pembimbing Lapangan <span
                        class="float-right">{{$nilai->nilai_pemlapangan}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-4">
                      <div class=" progress-sm progress-bar bg-success" role="progressbar"
                        style="width: {{$nilai->nilai_pemlapangan}}%" aria-valuenow="{{$nilai->nilai_pemlapangan}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @elseif ($nilai->nilai_pemlapangan >= 60)
                    <h6 class="small font-weight-bold">Nilai Pembimbing Lapangan <span
                        class="float-right">{{$nilai->nilai_pemlapangan}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-2">
                      <div class=" progress-sm progress-bar bg-warning" role="progressbar"
                        style="width: {{$nilai->nilai_pemlapangan}}%" aria-valuenow="{{$nilai->nilai_pemlapangan}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @else
                    <h6 class="small font-weight-bold">Nilai Pembimbing Lapangan <span
                        class="float-right">{{$nilai->nilai_pemlapangan}}%</span>
                    </h6>
                    <div class="progress progress-sm mb-4">
                      <div class=" progress-sm progress-bar bg-danger" role="progressbar"
                        style="width: {{$nilai->nilai_pemlapangan}}%" aria-valuenow="{{$nilai->nilai_pemlapangan}}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @endif
                  </section>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif


      </div>
    </div>
  </div>

  @endsection