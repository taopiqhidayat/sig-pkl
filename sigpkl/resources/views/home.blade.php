@extends('layout.main')

@section('mystyle')
<style>
  html,
  body {
    height: 100%;
    margin: 0;
    padding: 0;
  }

  #map {
    height: 70%;
    width: 100%;
  }

  #map-canvas {
    height: 70%;
    width: 100%;
  }

  /* Medium devices (tablets, 768px and up) */
  @media (min-width: 768px) {
    #map {
      height: 100%;
      width: 100%;
    }

    #map-canvas {
      height: 100%;
      width: 100%;
    }
  }
</style>
@endsection

@section('title', 'Halaman Utama')

@section('isi')
<div class=" container-fluid">
  @if (Auth::user()->is_admin == 1)
  <div class=" row">
    <div class=" col-6">
      <div class=" card p-0" style="height: 480px;">
        <div class=" card-body p-1">
          <div id="map"></div>
        </div>
      </div>
    </div>
    <div class=" col-6">
      <div class=" row">
        <div class=" col-4">
          <div class=" card border-warning text-warning" style="height: 120px">
            <div class=" card-body">
              <h6 class=" card-title">Jumlah Siswa Terdaftar</h6>
              @if ($bnyksiswa == null)
              <span>0 orang</span>
              @else
              <span>{{$bnyksiswa}} orang</span>
              @endif
            </div>
          </div>
        </div>
        <div class=" col-4">
          <div class=" card border-success text-success" style="height: 120px">
            <div class=" card-body">
              <h6 class=" card-title text-bold">Jumlah Guru Pembimbing</h6>
              <span>{{$indu}} orang</span>
            </div>
          </div>
        </div>
        <div class=" col-4">
          <div class=" card border-primary text-primary" style="height: 120px">
            <div class=" card-body">
              <h6 class=" card-title text-bold">Jumlah Industri Terdaftar</h6>
              <span>{{$indu}} lokasi</span>
            </div>
          </div>
        </div>
      </div>
      <div class=" row mt-2">
        <div class=" col-6">
          <div class=" card border-left-success" style="height: 120px">
            <div class=" card-body">
              <h6 class=" card-title text-bold">Siswa yang Sudah Diterima di Industri</h6>
              <div class=" row">
                <div class=" col-10">
                  @if ($jumterima == null)
                  <div class="progress progress-sm">
                    <div class=" progress-sm progress-bar bg-primary" role="progressbar" style="width: 0%"
                      aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span>0 orang</span>
                  @else
                  <div class="progress progress-sm">
                    <div class=" progress-sm progress-bar bg-primary" role="progressbar"
                      style="width: {{($jumterima / $bnyksiswa)*100}}%" aria-valuenow="{{$jumterima}}" aria-valuemin="0"
                      aria-valuemax="100"></div>
                  </div>
                  <span>{{$jumterima}}/{{$bnyksiswa}} orang</span>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class=" col-6">
          <div class=" card border-left-success" style="height: 120px">
            <div class=" card-body">
              <h6 class=" card-title text-bold">Industri yang Menerima Siswa PKL</h6>
              <div class=" row">
                <div class=" col-10">
                  @if ($jumterima == null)
                  <div class="progress progress-sm">
                    <div class=" progress-sm progress-bar bg-primary" role="progressbar" style="width: 0%"
                      aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span>0 lokasi</span>
                  @else
                  <div class="progress progress-sm">
                    <div class=" progress-sm progress-bar bg-primary" role="progressbar"
                      style="width: {{($jumnerima / $indu)*100}}%" aria-valuenow="{{$jumnerima}}" aria-valuemin="0"
                      aria-valuemax="100"></div>
                  </div>
                  <span>{{$jumnerima}}/{{$indu}} lokasi</span>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class=" row mt-2">
        <div class=" col-12">
          <div class=" card border-left-info">
            <div class=" card-body">
              <h4>Jadwal Kegiatan</h4>
              <table class=" table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Kegiatan</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>1</th>
                    <td>Registrasi / Pendaftaran</td>
                    <td>{{$sch->dft_mulai}} - {{$sch->dft_sampai}}</td>
                  </tr>
                  <tr>
                    <th>2</th>
                    <td>Pencarian Lokasi</td>
                    <td>{{$sch->clk_mulai}} - {{$sch->clk_sampai}}</td>
                  </tr>
                  <tr>
                    <th>3</th>
                    <td>Pelaksanaan PKL</td>
                    <td>{{$sch->pkl_mulai}} - {{$sch->pkl_sampai}}</td>
                  </tr>
                  <tr>
                    <th>4</th>
                    <td>Sidang / Pengujian</td>
                    <td>{{$sch->uji_mulai}} - {{$sch->uji_sampai}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function initialize() {
      const latitude = -7.2756349,
          longitude = 107.9162711,
          center = new google.maps.LatLng(latitude,longitude),
          mapOptions = {
            center: center,
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false,
            disableDefaultUI: false,
          };

      const map = new google.maps.Map(document.getElementById("map"), mapOptions);

      const marker = new google.maps.Marker({
        position: center,
        map,
        title: "SMKN 10 Garut",
      });
      const contentString =
        '<div id="content">' +
        '<div id="siteNotice">' +
        "</div>" +
        '<h1 id="firstHeading" class="firstHeading">SMKN 10 Garut</h1>' +
        '<div id="bodyContent">' +
        "<p><b>SMKN 10 Garut</b>, berada di Jl. Garut - Tasikmalaya No.KM. 8, RW.8, Cilawu, Cigasong, Kabupaten Garut, Jawa Barat 44181.</p>" +
        '<p>Situs Web: <a href="">' +
        "http://smkn10garut.sch.id/</a> " +
        "</p>" +
        "</div>" +
        "</div>";
      const infowindow = new google.maps.InfoWindow({
        content: contentString,
      });
      marker.addListener("click", () => {
        map.setZoom(18);
        infowindow.open({
          anchor: marker,
          map,
          shouldFocus: false,
        });
      });

      setMarkers(center, map);
    }

    function setMarkers(center, map) {
      const industri = @json($industri);
      const siswa = @json($siswa);
      console.log(industri);
      console.log(siswa);

      //loop between each of the json elements
      for (let i = 0, length = industri.length; i < length; i++) {
        const data = industri[i],
              sw = siswa[i];
        latLng = new google.maps.LatLng(data.latitude, data.longitude);

            const marker = new google.maps.Marker({
                position: latLng,
                map: map,
                title: data.nama
            });
            if (sw == null) {
            infoBox(map, marker, data);
            }
            infoBox(map, marker, data, sw);
      }

    }

    function infoBox(map, marker, data, sw = null) {
      google.maps.event.addListener(marker, "click", function(e) {
        // Attaching a click event to the current marker
        const infoWindow = new google.maps.InfoWindow();
      if (sw == null) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"
          );
      } else if (sw.length == 1) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas
          );
      } else if(sw.length == 2) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas
          );
      } else if(sw.length == 3) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas
          );
      } else if(sw.length == 4) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas+"<br>"+sw[3].nama+sw[3].kelas
          );
      } else if(sw.length == 5) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas+"<br>"+sw[3].nama+sw[3].kelas+"<br>"+sw[4].nama+sw[4].kelas
          );
      } else if(sw.length == 6) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas+"<br>"+sw[3].nama+sw[3].kelas+"<br>"+sw[4].nama+sw[4].kelas+"<br>"+sw[5].nama+sw[5].kelas
          );
      } else if(sw.length == 7) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas+"<br>"+sw[3].nama+sw[3].kelas+"<br>"+sw[4].nama+sw[4].kelas+"<br>"+sw[5].nama+sw[5].kelas+"<br>"+sw[6].nama+sw[6].kelas
          );
      } else if(sw.length == 8) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas+"<br>"+sw[3].nama+sw[3].kelas+"<br>"+sw[4].nama+sw[4].kelas+"<br>"+sw[5].nama+sw[5].kelas+"<br>"+sw[6].nama+sw[6].kelas+"<br>"+sw[7].nama+sw[7].kelas
          );
      } else if(sw.length == 9) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas+"<br>"+sw[3].nama+sw[3].kelas+"<br>"+sw[4].nama+sw[4].kelas+"<br>"+sw[5].nama+sw[5].kelas+"<br>"+sw[6].nama+sw[6].kelas+"<br>"+sw[7].nama+sw[7].kelas+"<br>"+sw[8].nama+sw[8].kelas
          );
      } else if(sw.length == 10) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas+"<br>"+sw[3].nama+sw[3].kelas+"<br>"+sw[4].nama+sw[4].kelas+"<br>"+sw[5].nama+sw[5].kelas+"<br>"+sw[6].nama+sw[6].kelas+"<br>"+sw[7].nama+sw[7].kelas+"<br>"+sw[8].nama+sw[8].kelas+"<br>"+sw[9].nama+sw[9].kelas
          );
      }
        infoWindow.open(map, marker);
      });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
  </script>
  <script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5yEZ-F3NhpHJQw15bRqSHHIVUCwuAv8c&callback=initialize" async
    defer></script>
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>

  @elseif (Auth::user()->is_industri == 1)
  <div class=" row">
    <div class=" col-6">
      <div class=" card p-0" style="height: 480px;">
        <div class=" card-body p-1">
          <div id="map-canvas"></div>
        </div>
      </div>
    </div>
    <div class=" col-6">
      <div class=" row">
        <div class=" col-4">
          <div class=" card border-success text-success" style="height: 120px">
            <div class=" card-body">
              <h6 class=" card-title">Siswa Magang</h6>
              @if ($siswa == null)
              <span>0 orang</span>
              @else
              <span>{{$siswa}} orang</span>
              @endif
            </div>
          </div>
        </div>
        <div class=" col-4">
          <div class=" card border-primary text-primary" style="height: 120px">
            <div class=" card-body">
              <h6 class=" card-title">Hari Magang</h6>
              @if ($absen == null)
              <span>0 hari</span>
              @else
              <span>{{$absen}} hari</span>
              @endif
            </div>
          </div>
        </div>
        <div class=" col-4">
          <div class=" card border-warning text-warning" style="height: 120px">
            <div class=" card-body">
              <h6 class=" card-title">Tugas Dibuat</h6>
              @if ($tugas == null)
              <span>0 tugas</span>
              @else
              <span>{{$tugas}} tugas</span>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class=" row mt-3">
        <div class=" col-12">
          <div class=" card border-left-info overflow-auto" style="height: 340px">
            <div class=" card-body">
              <h4>Jadwal Siswa Magang</h4>
              <table class=" table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Kelas</th>
                    <th>Waktu</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($siswamagang == null)
                  <tr>
                    <td colspan="5">
                      <div class="row">
                        <div class="col">
                          <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <div>
                              <strong>Kosong!</strong> Belum ada yang terdaftar magang di tempat Anda!!
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  @endif
                  @foreach ($siswamagang as $sm)
                  <tr>
                    <th>{{$loop->iteration}}</th>
                    <td>{{$sm->nama}}</td>
                    <td>{{$sm->jurusan}}</td>
                    <td>{{$sm->kelas}}</td>
                    <td>{{$sm->waktu_masuk}} - {{$sm->waktu_keluar}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function initialize() {
      const latitude = -7.2756349,
          longitude = 107.9162711,
          center = new google.maps.LatLng(latitude,longitude),
          mapOptions = {
            center: center,
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false,
            disableDefaultUI: false,
          };

      const map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

      setMarkers(center, map);
    }

    function setMarkers(center, map) {
      const industri = @json($industri);
      const siswa = @json($students);
      console.log(industri);
      console.log(siswa);

      //loop between each of the json elements
      for (let i = 0, length = industri.length; i < length; i++) {
        const data = industri[i],
              sw = siswa[i];
        latLng = new google.maps.LatLng(data.latitude, data.longitude);

            const marker = new google.maps.Marker({
                position: latLng,
                map: map,
                title: data.nama
            });
            if (sw == null) {
            infoBox(map, marker, data);
            }
            infoBox(map, marker, data, sw);
      }

    }

    function infoBox(map, marker, data, sw = null) {
      google.maps.event.addListener(marker, "click", function(e) {
        // Attaching a click event to the current marker
        const infoWindow = new google.maps.InfoWindow();
      if (sw == null) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"
          );
      } else if (sw.length == 1) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas
          );
      } else if(sw.length == 2) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas
          );
      } else if(sw.length == 3) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas
          );
      } else if(sw.length == 4) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas+"<br>"+sw[3].nama+sw[3].kelas
          );
      } else if(sw.length == 5) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas+"<br>"+sw[3].nama+sw[3].kelas+"<br>"+sw[4].nama+sw[4].kelas
          );
      } else if(sw.length == 6) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas+"<br>"+sw[3].nama+sw[3].kelas+"<br>"+sw[4].nama+sw[4].kelas+"<br>"+sw[5].nama+sw[5].kelas
          );
      } else if(sw.length == 7) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas+"<br>"+sw[3].nama+sw[3].kelas+"<br>"+sw[4].nama+sw[4].kelas+"<br>"+sw[5].nama+sw[5].kelas+"<br>"+sw[6].nama+sw[6].kelas
          );
      } else if(sw.length == 8) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas+"<br>"+sw[3].nama+sw[3].kelas+"<br>"+sw[4].nama+sw[4].kelas+"<br>"+sw[5].nama+sw[5].kelas+"<br>"+sw[6].nama+sw[6].kelas+"<br>"+sw[7].nama+sw[7].kelas
          );
      } else if(sw.length == 9) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas+"<br>"+sw[3].nama+sw[3].kelas+"<br>"+sw[4].nama+sw[4].kelas+"<br>"+sw[5].nama+sw[5].kelas+"<br>"+sw[6].nama+sw[6].kelas+"<br>"+sw[7].nama+sw[7].kelas+"<br>"+sw[8].nama+sw[8].kelas
          );
      } else if(sw.length == 10) {
        infoWindow.setContent(
          "<div><h5>"+data.nama+"</h5><p><b>"+ data.nama +"</b>, berada di "+ data.alamat +"</p><br>"+sw[0].nama+sw[0].kelas+"<br>"+sw[1].nama+sw[1].kelas+"<br>"+sw[2].nama+sw[2].kelas+"<br>"+sw[3].nama+sw[3].kelas+"<br>"+sw[4].nama+sw[4].kelas+"<br>"+sw[5].nama+sw[5].kelas+"<br>"+sw[6].nama+sw[6].kelas+"<br>"+sw[7].nama+sw[7].kelas+"<br>"+sw[8].nama+sw[8].kelas+"<br>"+sw[9].nama+sw[9].kelas
          );
      }
        infoWindow.open(map, marker);
      });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
  </script>
  <script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5yEZ-F3NhpHJQw15bRqSHHIVUCwuAv8c&callback=initialize" async
    defer></script>
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>

  @elseif (Auth::user()->is_guru == 1)
  <div class=" row">
    <div class=" col-6">
      <div class=" card p-0" style="height: 480px;">
        <div class=" card-body p-1">
          <div id="map"></div>
        </div>
      </div>
    </div>
    <div class=" col-6">
      <div class=" row mb-3">
        <div class=" col-4">
          <div class=" card border-warning text-warning" style="height: 120px">
            <div class=" card-body">
              <h6 class=" card-title">Siswa Bimbingan</h6>
              @if ($siswa == null)
              <span>0 orang</span>
              @else
              <span>{{$siswa}} orang</span>
              @endif
            </div>
          </div>
        </div>
        <div class=" col-4">
          <div class=" card border-success text-success" style="height: 120px">
            <div class=" card-body">
              <h6 class=" card-title text-bold">Jumlah Lokasi Industri</h6>
              @if ($indu == null)
              <span>0 lokasi</span>
              @else
              <span>{{$indu}} lokasi</span>
              @endif
            </div>
          </div>
        </div>
        <div class=" col-4">
          <div class=" card border-primary text-primary" style=" height: 120px">
            <div class=" card-body">
              <h6 class=" card-title">Jumlah Kunjungn</h6>
              <div class=" row">
                <div class=" col-10">
                  @if ($kunjungan == null)
                  <div class="progress progress-sm">
                    <div class=" progress-sm progress-bar bg-primary" role="progressbar" style="width: 0%"
                      aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span>0</span>
                  @else
                  <div class="progress progress-sm">
                    <div class=" progress-sm progress-bar bg-primary" role="progressbar"
                      style="width: {{($kunjungan / 2)*100}}%" aria-valuenow="{{$kunjungan}}" aria-valuemin="0"
                      aria-valuemax="100"></div>
                  </div>
                  <span>{{$kunjungan}}/2</span>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class=" row mt-2">
        <div class=" col-12">
          <div class=" card border-left-info">
            <div class=" card-body">
              <h4>Jadwal Kegiatan</h4>
              <table class=" table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Kegiatan</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>1</th>
                    <td>Pencarian Lokasi</td>
                    <td>{{$sch->clk_mulai}} - {{$sch->clk_sampai}}</td>
                  </tr>
                  <tr>
                    <th>2</th>
                    <td>Pelaksanaan PKL</td>
                    <td>{{$sch->pkl_mulai}} - {{$sch->pkl_sampai}}</td>
                  </tr>
                  <tr>
                    <th>3</th>
                    <td>Sidang / Pengujian</td>
                    <td>{{$sch->uji_mulai}} - {{$sch->uji_sampai}}</td>
                  </tr>
                  @foreach ($data as $dt)
                  <tr>
                    <td>{{$loop->iteration + 3}}</td>
                    <td>Sidang {{$loop->iteration}}</td>
                    <td>{{$dt->tanggal}} {{$dt->waktu}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function initMap() {
          const myLatlng = { lat: -7.27536, lng: 107.91793 };
          const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 10,
            center: myLatlng,
          });
          const marker = new google.maps.Marker({
            position: myLatlng,
            map,
            title: "SMKN 10 Garut",
          });
          const contentString =
            '<div id="content">' +
            '<div id="siteNotice">' +
            "</div>" +
            '<h1 id="firstHeading" class="firstHeading">SMKN 10 Garut</h1>' +
            '<div id="bodyContent">' +
            "<p><b>SMKN 10 Garut</b>, berada di Jl. Garut - Tasikmalaya No.KM. 8, RW.8, Cilawu, Cigasong, Kabupaten Garut, Jawa Barat 44181.</p>" +
            '<p>Situs Web: <a href="">' +
            "http://smkn10garut.sch.id/</a> " +
            "</p>" +
            "</div>" +
            "</div>";
          const infowindow = new google.maps.InfoWindow({
            content: contentString,
          });
          marker.addListener("click", () => {
            map.setZoom(18);
            infowindow.open({
              anchor: marker,
              map,
              shouldFocus: false,
            });
          });
        }
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6YvAg6UAJRk0euEajOAln7z6SeuEDasM&callback=initMap"
    async defer></script>

  @elseif (Auth::user()->is_siswa == 1)
  <div class=" row">
    <div class=" col-6">
      <div class=" card p-0" style="height: 480px;">
        <div class=" card-body p-1">
          <div id="map"></div>
        </div>
      </div>
    </div>
    <div class=" col-6">
      <div class=" row mb2">
        <div class=" col-6">
          <div class=" card border-success text-success" style=" height: 120px">
            <div class=" card-body">
              <h6 class=" card-title">Kehadiran</h6>
              <div class=" row">
                <div class=" col-10">
                  @if ($absen == null or $hadir == null)
                  <div class="progress progress-sm">
                    <div class=" progress-sm progress-bar bg-success" role="progressbar" style="width: 0%"
                      aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span>0</span>
                  @else
                  <div class="progress progress-sm">
                    <div class=" progress-sm progress-bar bg-success" role="progressbar"
                      style="width: {{($hadir / $absen)*100}}%" aria-valuenow="{{$hadir}}" aria-valuemin="0"
                      aria-valuemax="100">
                    </div>
                  </div>
                  <span>{{$hadir}}/{{$absen}}</span>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class=" col-6">
          <div class=" card border-warning text-warning" style=" height: 120px">
            <div class=" card-body">
              <h6 class=" card-title">Tugas</h6>
              <div class=" row">
                <div class=" col-10">
                  @if ($jumtugas == null or $jumtugasku == null)
                  <div class="progress progress-sm">
                    <div class=" progress-sm progress-bar bg-warning" role="progressbar" style="width: 0%"
                      aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span>0</span>
                  @else
                  <div class="progress progress-sm">
                    <div class=" progress-sm progress-bar bg-warning" role="progressbar"
                      style="width: {{($jumtugasku / $jumtugas)*100}}%" aria-valuenow="{{$jumtugasku}}"
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span>{{$jumtugasku}}/{{$jumtugas}}</span>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class=" row mt-3">
        <div class=" col-12">
          <div class=" card border-left-info">
            <div class=" card-body">
              <h4>Jadwal Kegiatan</h4>
              <table class=" table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Kegiatan</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>1</th>
                    <td>Pencarian Lokasi</td>
                    <td>{{$sch->clk_mulai}} - {{$sch->clk_sampai}}</td>
                  </tr>
                  <tr>
                    <th>2</th>
                    <td>Pelaksanaan PKL</td>
                    <td>{{$sch->pkl_mulai}} - {{$sch->pkl_sampai}}</td>
                  </tr>
                  <tr>
                    <th>3</th>
                    <td>Sidang / Pengujian</td>
                    <td>{{$sch->uji_mulai}} - {{$sch->uji_sampai}}</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Sidang</td>
                    @if ($data == null)
                    <td>Belum ditentukan</td>
                    @else
                    <td>{{$data->tanggal}} {{$data->waktu}}</td>
                    @endif
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if ($indu != null)
  <div class=" row mt-3">
    <div class=" col-6">
      <div class=" card border-left-success overflow-auto" style="height: 400px">
        <div class=" card-body">
          <h4>Jadwal Hari Kerja</h4>
          <table class=" table">
            <thead>
              <tr>
                <th>#</th>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Waktu</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($jadw as $jw)
              <tr>
                <th>{{$loop->iteration}}</th>
                <td>{{date('l', strtotime($jw->tanggal))}}</td>
                <td>{{$jw->tanggal}}</td>
                <td>{{$waktu->waktu_masuk}} - {{$waktu->waktu_keluar}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class=" col-6">
      <div class=" card border-left-warning overflow-auto" style="height: 400px">
        <div class=" card-body">
          <h4>Tugas</h4>
          <table class=" table">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Tugas</th>
                <th>Terakhir</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th colspan="4" class=" text-center">Tugas</th>
              </tr>
              @foreach ($tugas as $tgs)
              @php
              $status = app('App\Http\Controllers\HomeController')->getStatusTugas($tgs->id, Auth::user()->id)
              @endphp
              <tr>
                <th>{{$loop->iteration}}</th>
                <td>{{$tgs->judul}}</td>
                <td>{{$tgs->tangakhir}} {{$tgs->wakakhir}}</td>
                @if ($status != null)
                <td><span class="badge badge-success">Selesai</span></td>
                @else
                <td><span class="badge badge-danger">Tidak Selesai</span></td>
                @endif
              </tr>
              @endforeach
              <tr>
                <th colspan="4" class=" text-center">Kuis</th>
              </tr>
              @foreach ($kuis as $k)
              @php
              $status = app('App\Http\Controllers\HomeController')->getStatusKuis($tgs->id, Auth::user()->id)
              @endphp
              <tr>
                <th>{{$loop->iteration}}</th>
                <td>{{$k->kuis}}</td>
                <td>{{$tgs->tangakhir}} {{$tgs->wakakhir}}</td>
                @if ($status != null)
                <td><span class="badge badge-success">Selesai</span></td>
                @else
                <td><span class="badge badge-danger">Tidak Selesai</span></td>
                @endif
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @endif
  <script>
    function initMap() {
        const myLatlng = { lat: -7.275756, lng: 107.9177994 };
        const map = new google.maps.Map(document.querySelector('div#map'), {
          zoom: 10,
          center: myLatlng,
          disableDefaultUI: true,
        });
        const marker = new google.maps.Marker({
          position: myLatlng,
          map,
          title: "SMKN 10 Garut",
        });
        const contentString =
          '<div id="content">' +
          '<div id="siteNotice">' +
          "</div>" +
          '<h1 id="firstHeading" class="firstHeading">SMKN 10 Garut</h1>' +
          '<div id="bodyContent">' +
          "<p><b>SMKN 10 Garut</b>, berada di Jl. Garut - Tasikmalaya No.KM. 8, RW.8, Cilawu, Cigasong, Kabupaten Garut, Jawa Barat 44181.</p>" +
          '<p>Situs Web: <a href="">' +
          "http://smkn10garut.sch.id/</a> " +
          "</p>" +
          "</div>" +
          "</div>";
        const infowindow = new google.maps.InfoWindow({
          content: contentString,
        });
        marker.addListener("click", () => {
          map.setZoom(18);
          infowindow.open({
            anchor: marker,
            map,
            shouldFocus: false,
          });
        });
      }
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6YvAg6UAJRk0euEajOAln7z6SeuEDasM&callback=initMap"
    async defer></script>
  @endif
</div>
@endsection