@extends('layout.main')

@section('mystyle')
<style>
  /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
  #map-canvas {
    height: 100%;
    width: 100%;
  }

  /* Optional: Makes the sample page fill the window.
  html,
  body {
    height: 100%;
    margin: 0;
    padding: 0;
  } */
</style>
@endsection

@section('title', 'Data Siswa')

@section('isi')
@if (Auth::user()->is_industri == 1)
<div class="container">

  <div class="row justify-content-center">
    <div class="col-10">

      <h3 class="mb-5">DAFTAR SISWA MAGANG</h3>

      <div class=" row">
        <div class=" col-7">
          <form action="{{ route('data_siswa') }}" method="get">
            <div class=" input-group my-3">
              <input type="text" class=" form-control" name="keywrd" id="keywrd" aria-describedby="search"
                placeholder="Masukkan kata kunci">
              <button type="submit" id="search" class=" btn btn-outline-info">Cari</button>
            </div>
          </form>
        </div>
      </div>
      <table class="table mt-3">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">Jurusan</th>
            <th scope="col">Kelas</th>
            <th scope="col">Pembimbing</th>
            <th scope="col">No Pembimbing</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            @if ($data == 0)
            <td colspan="6">
              <div class="row">
                <div class="col">
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div>
                      <strong>Kosong!</strong> Tidak ada Siswa yang terdaftar magang di tempat Anda!!
                    </div>
                  </div>
                </div>
              </div>
            </td>
            @else
            @foreach ($siswa as $s)
            <th scope="col">{{ $loop->iteration }}</th>
            <td>{{ $s->nama_siswa }}</td>
            <td>{{ $s->jurusan }}</td>
            <td>{{ $s->kelas }}</td>
            <td>{{ $s->nama_guru }}</td>
            <td>{{ $s->n_wa }}</td>
          </tr>
          @endforeach
          <div class=" text-gray-600 bg-secondary-50">
            {{ $siswa->links() }}
          </div>
          @endif
        </tbody>
      </table>

    </div>
  </div>

</div>
@endif

@if (Auth::user()->is_guru == 1)
<div class="container">

  <div class=" card p-0" style="height: 300px;">
    <div class=" card-body p-1">
      <div id="map-canvas"></div>
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
                infoBox(map, marker, data, sw);
          }

        }

        function infoBox(map, marker, data, sw) {
          google.maps.event.addListener(marker, "click", function(e) {
            // Attaching a click event to the current marker
            const infoWindow = new google.maps.InfoWindow();
          if (sw.length == 1) {
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

  <div class="row justify-content-center">
    <div class="col-10">

      <h3>DAFTAR SISWA BIMBINGAN</h3>

      <div class=" row">
        <div class=" col-7">
          <form action="{{ route('data_siswa') }}" method="get">
            <div class=" input-group my-3">
              <input type="text" class=" form-control" name="keywrd" id="keywrd" aria-describedby="search"
                placeholder="Masukkan kata kunci">
              <button type="submit" id="search" class=" btn btn-outline-info">Cari</button>
            </div>
          </form>
        </div>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">Jurusan</th>
            <th scope="col">Kelas</th>
            <th scope="col">Tempat</th>
            <th scope="col">No Pem. Lapangan</th>
          </tr>
        </thead>
        <tbody>
          @if ($data == 0)
          <tr>
            <td colspan="6">
              <div class="row">
                <div class="col">
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div>
                      <strong>Kosong!</strong> Tidak ada siswa yang dibimbing oleh Anda!!
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          @else
          @foreach ($sistem as $s)
          <tr>
            <th scope="col">{{ $loop->iteration }}</th>
            <td>{{ $s->nama_siswa }}</td>
            <td>{{ $s->jurusan }}</td>
            <td>{{ $s->kelas }}</td>
            <td>{{ $s->nama_indu }}</td>
            <td>{{ $s->n_wa }}</td>
          </tr>
          @endforeach
          <div class=" text-gray-600 bg-secondary-50">
            {{ $sistem->links() }}
          </div>
          @endif
        </tbody>
      </table>

    </div>
  </div>

</div>
@endif
@endsection