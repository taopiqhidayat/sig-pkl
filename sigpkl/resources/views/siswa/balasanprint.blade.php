<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

  <title>Print Balasan</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <table align="center">
          <thead>
            <tr>
              <td colspan="2">
                <center>
                  <font size="6">SURAT PERNYATAAN</font>
                </center>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="2" height="20"></td>
            </tr>
            <tr>
              <td colspan="2">Yang bertandatangan di bawah ini:</td>
            </tr>
            <tr>
              <td colspan="2" height="10"></td>
            </tr>
            <tr>
              <td>Pimpian DUDIKA<sup>**</sup></td>
              <td>: {{$industri->ketua}}</td>
            </tr>
            <tr>
              <td>Nama DUDIKA<sup>**</sup></td>
              <td>: {{$industri->nama}}</td>
            </tr>
            <tr>
              <td>Alamat Lengkap DUDIKA<sup>**</sup></td>
              <td>: {{$industri->alamat}}</td>
            </tr>
            <tr>
              <td>No Telp/Kontak DUDIKA<sup>**</sup></td>
              <td>: {{$industri->n_wa}}</td>
            </tr>
            <tr>
              <td colspan="2" height="20"></td>
            </tr>
            <tr>
              <td colspan="2">Dengan ini menyatakan</td>
            </tr>
            <tr>
              <td colspan="2" height="10"></td>
            </tr>
            <tr>
              <td colspan="2" align="center">
                @if ($diterima == 0)
                <font size="4"> <del>MENERIMA</del> / TIDAK MENERIMA <sup>*</sup></font><br><br>
                @else
                <font size="4">MENERIMA / <del>TIDAK MENERIMA</del> <sup>*</sup></font><br><br>
                @endif
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <p class=" text-justify">
                  Penempatan siswa SMK Negeri 10 Garut untuk melaksanakan Praktek Kerja Lapangan di DUDIKA<sup>**</sup>
                  Kami, sebanyak {{$diterima}} orang. Dimulai dari tanggal
                  <b>{{date('d/m/Y', strtotime($sch->pkl_mulai))}} -
                    {{date('d/m/Y', strtotime($sch->pkl_sampai))}}.</b><br><br>
                  Nama - nama siswanya diantaranya:
                </p>
              </td>
            </tr>
          </tbody>
        </table>
        <table align="center" class=" table table-bordered table-striped"
          style="border: 1px solid black; border-collapse: collapse;">
          <thead>
            <tr>
              <th style="border: 1px solid black; padding: 10px;">No</th>
              <th style="border: 1px solid black; padding: 10px;">Nama Siswa</th>
              <th style="border: 1px solid black; padding: 10px;">Kelas / Jurusan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($siswaterima as $sd)
            @if ($sd->diterima == 1)
            <tr>
              <th style="border: 1px solid black; padding: 10px;">{{$loop->iteration}}</th>
              <td style="border: 1px solid black; padding: 10px;">{{$sd->nama}}</td>
              <td style="border: 1px solid black; padding: 10px;">{{$sd->kelas}} / {{$sd->jurusan}}</td>
            </tr>
            @else
            <tr>
              <th style="border: 1px solid black; padding: 10px; color: red;">{{$loop->iteration}}</th>
              <td style="border: 1px solid black; padding: 10px; color: red;">{{$sd->nama}}</td>
              <td style="border: 1px solid black; padding: 10px; color: red;">{{$sd->kelas}} / {{$sd->jurusan}}</td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
        <table align="right">
          <thead>
            <tr>
              <td height="20"></td>
            </tr>
            <tr>
              <td align="center">Garut, {{date('d-m-Y')}}</td>
            </tr>
            <tr>
              <td align="center"><b>Pimpinan {{$industri->nama}}</b></td>
            </tr>
            <tr>
              <td height="20"></td>
            </tr>
            <tr>
              <td align="center"><b>{{$industri->ketua}}</b></td>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <br><br><br><br><br><br><br><br><br>
        <table>
          <thead>
            <tr>
              <td></td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Catatan:</td>
              <td><sup>*</sup>) Coret yang tidak perlu</td>
            </tr>
            <tr>
              <td></td>
              <td><sup>**</sup>) DUDIKA: Dunia Usaha/Industri dan Dunia Kerja</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
  </script>

</body>

</html>