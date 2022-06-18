@extends('layout.main')

@section('title', 'Absensi')

@section('isi')

@if (Auth::user()->is_industri == 1)
<div class="container">

  <div class="row">
    <div class="col">


      <div class="row">
        <div class="col col-md-6 overflow-auto shadow-sm" style="max-height: 450px;">
          <h3>PENENTUAN HARI KERJA</h3>

          <table class="table mt-3">
            <thead>
              <tr>
                <th>#</th>
                <th>Hari</th>
                <th>Tangggal</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @if ($data <= $jhk) @for ($i=1; $i <=$jhk; $i++) <tr>
                <th>{{$i}}</th>
                <td>{{$hari[] = date('l', strtotime($hari[] = $h->addDay()))}}</td>
                <td>{{$tang[] = date('Y-m-d', strtotime($tang[] = $t1->addDay()))}}</td>
                <td>
                  <div class="row">
                    <div class="col">
                      <form action="{{route('masuk')}}" method="post">
                        @csrf
                        <input type="hidden" name="idi" id="idi" value="{{Auth::user()->id}}">
                        <input type="hidden" name="tang" id="tang"
                          value="{{$tang[] = date('Y-m-d', strtotime($tang[] = $t2->addDay()))}}">
                        <input type="hidden" name="masuk" id="masuk" value="1">
                        <button type="submit" class="btn btn-success">Masuk</button>
                      </form>
                    </div>
                    <div class="col">
                      <form action="{{route('libur')}}" method="post">
                        @csrf
                        <input type="hidden" name="idi" id="idi" value="{{Auth::user()->id}}">
                        <input type="hidden" name="tang" id="tang"
                          value="{{$tang[] = date('Y-m-d', strtotime($tang[] = $t3->addDay()))}}">
                        <input type="hidden" name="masuk" id="masuk" value="0">
                        <button type="submit" class="btn btn-danger">Libur</button>
                      </form>
                    </div>
                  </div>
                </td>
                </tr>
                @endfor
                @endif
            </tbody>
          </table>
        </div>
        @if ($data > 0)
        <div class="col col-md-6 overflow-auto shadow-sm" style="max-height: 450px;">
          <h3>JADWAL</h3>

          <table class="table mt-3">
            <thead>
              <tr>
                <th>#</th>
                <th>Hari</th>
                <th>Tangggal</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($jadw as $jdw)
              <tr>
                <th>{{ $loop->iteration }}</th>
                <td>{{date('l', strtotime($jdw->tanggal))}}</td>
                <td>{{$jdw->tanggal}}</td>
                <td>
                  @if ($jdw->masuk == 1)
                  <a class="badge badge-success">Masuk</a>
                  @else
                  <a class="badge badge-danger">Libur</a>
                  @endif
                </td>
                @if ($jdw->masuk == 1)
                <td><a href="/kehadiran/{{$jdw->id}}" class=" badge badge-info">Kehadiran</a></td>
                @else
                <td><span class="text-danger">Hari Libur</span></td>
                @endif
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif
      </div>

    </div>
  </div>

</div>
@endif

@if (Auth::user()->is_siswa == 1)
<div class="container">

  @if ($indu == null)
  <h3>ABSENSI</h3>
  <div class="row mt-3">
    <div class="col-md-6">
      <div class="alert alert-danger d-flex align-items-center" role="alert">
        <div>
          <strong>Kosong!</strong> Anda belum mendapatkan tempat PKL!!
        </div>
      </div>
    </div>
  </div>
  @elseif ($data == 0)
  <h3>ABSENSI</h3>
  <div class="row mt-3">
    <div class="col-md-6">
      <div class="alert alert-danger d-flex align-items-center" role="alert">
        <div>
          <strong>Kosong!</strong> Industri tempat anda PKL belum menentukan jadwal!!
        </div>
      </div>
    </div>
  </div>
  @else
  <div class="row">
    <div class="col-6">

      <h3>ABSENSI</h3>

      @foreach ($absen as $a)
      <div class="card text-left mb-3">
        <div class="card-body">
          <h5 class="card-subtitle mb-2 text-muted float-right">{{$a->tanggal}}</h5>
          <h4 class="card-title">{{date('l', strtotime($a->tanggal))}}</h4>
          <form action="{{route('hadir')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class=" row">
              <div class=" col-10">
                <input type="hidden" name="id" id="id" value="{{$a->id}}">
                <input type="hidden" name="masuk" id="masuk" value="1">
                <div class=" form-group row">
                  <div class=" col-4">
                    <label for="buke" class=" mt-1">Bukti Kehadiran</label>
                  </div>
                  <div class=" col-8">
                    <input type="file" name="buke" id="buke" class=" form-control">
                    <span class="text-danger">@error('buke') {{ $message }} @enderror</span>
                  </div>
                </div>
              </div>
              <div class=" col-2">
                <?php
                  $tangab = $a->tanggal;
                  $sekarang = time();
                  ?>
                @if ($tangab >= $sekarang)
                <button type="submit" class="btn btn-success">Hadir</button>
                @else
                @endif
              </div>
            </div>
          </form>

        </div>
      </div>
      @endforeach
    </div>
    <div class="col">
    </div>
    <div class="col-5">
      <h3>KEHADIRAN</h3>
      @foreach ($absen as $a)
      @php
      $hadir = app('App\Http\Controllers\CalendarsController')->cekHadir(Auth::user()->id, $a->id);
      @endphp
      <div class="card text-left mb-2">
        <div class="card-body">
          <h5 class="card-title">{{date('l', strtotime($a->tanggal))}}, <small>{{$a->tanggal}}</small>
            @if ($hadir == 1)
            <a class="badge badge-success disabled float-right mt-1">Hadir</a>
            @else
            <a class="badge badge-danger disabled float-right mt-1">Tidak Hadir</a>
            @endif
          </h5>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif

</div>
@endif

@endsection