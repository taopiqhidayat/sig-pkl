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

  <!-- Custom fonts for this template-->
  <link href="/temsba2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/temsba2/css/sb-admin-2.min.css" rel="stylesheet">

  @yield('mystyle')

  <title>@yield('title')</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
          <i class="fas fa-school"></i>
        </div>
        <div class="sidebar-brand-text mx-1">PKL SMKN 10 GARUT</div>
      </a>

      @php
      $skr = date('Ymd');
      $dftaw = app('App\Http\Controllers\HomeController')->getdftaw();
      $dftakh = app('App\Http\Controllers\HomeController')->getdftakh();
      $cariaw = app('App\Http\Controllers\HomeController')->getcariaw();
      $cariakh = app('App\Http\Controllers\HomeController')->getcariakh();
      $kegaw = app('App\Http\Controllers\HomeController')->getkegaw();
      $kegakh = app('App\Http\Controllers\HomeController')->getkegakh();
      $nyusaw = app('App\Http\Controllers\HomeController')->getnyusaw();
      $nyusakh = app('App\Http\Controllers\HomeController')->getnyusakh();
      $ujiaw = app('App\Http\Controllers\HomeController')->getujiaw();
      $ujiakh = app('App\Http\Controllers\HomeController')->getujiakh();
      $edu = app('App\Http\Controllers\HomeController')->geteditdtuji();
      $bniaw = app('App\Http\Controllers\HomeController')->getbniaw();
      $bniakh = app('App\Http\Controllers\HomeController')->getbniakh();
      $niakh = app('App\Http\Controllers\HomeController')->getniakh();
      $mpl = app('App\Http\Controllers\HomeController')->getaktif('Pilih Lokasi');
      $mps = app('App\Http\Controllers\HomeController')->getaktif('Pengajuan Siswa');
      $mabs = app('App\Http\Controllers\HomeController')->getaktif('Absensi');
      $mtgs = app('App\Http\Controllers\HomeController')->getaktif('Tugas');
      $mknj = app('App\Http\Controllers\HomeController')->getaktif('Kunjungan');
      $mpen = app('App\Http\Controllers\HomeController')->getaktif('Penilaian Industri');
      $mlap = app('App\Http\Controllers\HomeController')->getaktif('Laporan');
      $mpres = app('App\Http\Controllers\HomeController')->getaktif('Presentasi');
      $mpuji = app('App\Http\Controllers\HomeController')->getaktif('Penentuan Penguji');
      $muji = app('App\Http\Controllers\HomeController')->getaktif('Pengujian');
      $mnil = app('App\Http\Controllers\HomeController')->getaktif('Nilai');
      @endphp

      <hr class="sidebar-divider mt-0">

      <div class="sidebar-heading">
        User
      </div>

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active" style="margin-bottom: -10px; margin-top: -10px;">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="fas fa-fw fa-home"></i>
          <span>Halaman Utama</span></a>
      </li>

      <!-- Nav Item - Profil -->
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/profil">
          <i class="fas fa-fw fa-id-card"></i>
          <span>Profil</span></a>
      </li>

      @if (!Auth::user()->is_siswa == 1)
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Data
      </div>
      @endif

      @if (Auth::user()->is_guru == 1 or Auth::user()->is_industri == 1)
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/data_siswa">
          <i class="fas fa-fw fa-book"></i>
          <span>Data Siswa</span></a>
      </li>
      @endif

      @if (Auth::user()->is_admin == 1)
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
          aria-controls="collapseTwo">
          <i class="fas fa-fw fa-book"></i>
          <span>Data Master</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Kelola Data:</h6>
            <a class="collapse-item" href="{{ route('kd_siswa') }}">Data Siswa</a>
            <a class="collapse-item" href="{{ route('kd_guru') }}">Data Guru</a>
            <a class="collapse-item" href="{{ route('kd_industri') }}">Data Industri</a>
            <a class="collapse-item" href="{{ route('kd_penempatan') }}">Data Penempatan</a>
          </div>
        </div>
      </li>
      @endif

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Aktifitas
      </div>

      @if (Auth::user()->is_siswa == 1)
      <!-- Nav Item - Charts -->
      <?php
      if($mpl == 0) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="{{ route('plh_industri') }}" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Pilih Lokasi</span></a>
      </li>
      <?php
      elseif(($skr >= $cariaw && $skr <= $cariakh)||($cariakh == null && $skr >= $cariaw)||($cariaw == null && $skr <= $cariakh)||($cariaw == null && $cariakh == null)||($mpl == 1)) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="{{ route('plh_industri') }}">
          <i class="fas fa-fw fa-building"></i>
          <span>Pilih Lokasi</span></a>
      </li>
      <?php
      else :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="{{ route('plh_industri') }}" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Pilih Lokasi</span></a>
      </li>
      <?php
      endif;
      ?>
      @endif

      @if (Auth::user()->is_industri == 1)
      <!-- Nav Item - Charts -->
      <?php
      if($mps == 0) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/pengajuan" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Pengajuan Siswa</span></a>
      </li>
      <?php
      elseif(($skr >= $cariaw && $skr <= $cariakh)||($cariakh == null && $skr >= $cariaw)||($cariaw == null && $skr <= $cariakh)||($cariaw == null && $cariakh == null)||($mps == 1)) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/pengajuan">
          <i class="fas fa-fw fa-address-book"></i>
          <span>Pengajuan Siswa</span></a>
      </li>
      <?php
      else :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/pengajuan" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Pengajuan Siswa</span></a>
      </li>
      <?php
      endif;
      ?>
      @endif

      @if (Auth::user()->is_guru == 1)
      <!-- Nav Item - Charts -->
      <?php
      if($mknj == 0) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/kunjungan" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Kunjungan</span></a>
      </li>
      <?php
      elseif(($skr >= $kegaw && $skr <= $kegakh)||($kegakh == null && $skr >= $kegaw)||($kegaw == null && $skr <= $kegakh)||($kegaw == null && $kegakh == null)||($mknj == 1)) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/kunjungan">
          <i class="fas fa-fw fa-clipboard-list"></i>
          <span>Kunjungan</span></a>
      </li>
      <?php
      else :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/kunjungan" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Kunjungan</span></a>
      </li>
      <?php
      endif;
      ?>
      @endif

      @if (Auth::user()->is_industri == 1 or Auth::user()->is_siswa == 1)
      <!-- Nav Item - Charts -->
      <?php
      if($mabs == 0) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/absensi" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Absensi</span></a>
      </li>
      <?php
      elseif(($skr >= $kegaw && $skr <= $ujiakh)||($ujiakh == null && $skr >= $kegaw)||($kegaw == null && $skr <= $ujiakh)||($kegaw == null && $ujiakh == null)||($mabs == 1)) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/absensi">
          <i class="fas fa-fw fa-calendar-check"></i>
          <span>Absensi</span></a>
      </li>
      <?php
      else :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/absensi" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Absensi</span></a>
      </li>
      <?php
      endif;
      ?>
      @endif

      @if (Auth::user()->is_admin == 1)
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="{{ route('akses_menu') }}">
          <i class="fas fa-fw fa-th-list"></i>
          <span>Kelola Menu</span></a>
      </li>

      <?php
      if($mps == 0) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="{{ route('ajuan_siswa') }}" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Pengajuan Siswa</span></a>
      </li>
      <?php
      elseif(($skr >= $cariaw && $skr <= $cariakh)||($cariakh == null && $skr >= $cariaw)||($cariaw == null && $skr <= $cariakh)||($cariaw == null && $cariakh == null)||($mps == 1)) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="{{ route('ajuan_siswa') }}">
          <i class="fas fa-fw fa-address-book"></i>
          <span>Pengajuan Siswa</span></a>
      </li>
      <?php
      else :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="{{ route('ajuan_siswa') }}" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Pengajuan Siswa</span></a>
      </li>
      <?php
      endif;
      ?>
      @endif

      @if (!Auth::user()->is_guru == 1)
      <!-- Nav Item - Charts -->
      <?php
      if($mtgs == 0) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/tugas_siswa" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Tugas</span></a>
      </li>
      <?php
      elseif(($skr >= $kegaw && $skr <= $ujiakh)||($ujiakh == null && $skr >= $kegaw)||($kegaw == null && $skr <= $ujiakh)||($kegaw == null && $ujiakh == null)||($mtgs == 1)) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/tugas_siswa">
          <i class="fas fa-fw fa-briefcase"></i>
          <span>Tugas</span></a>
      </li>
      <?php
      else :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/tugas_siswa" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Tugas</span></a>
      </li>
      <?php
      endif;
      ?>
      @endif

      @if (Auth::user()->is_admin == 1)
      <?php
      if($mpuji == 0) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="{{ route('penentuan_penguji') }}"
          style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Penentuan Penguji</span></a>
      </li>
      <?php
      elseif(($skr >= $edu && $skr <= $ujiakh)||($ujiakh == null && $skr >= $edu)||($edu == null && $skr <= $ujiakh)||($edu == null && $ujiakh == null)||($mpuji == 1)) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="{{ route('penentuan_penguji') }}">
          <i class="fas fa-fw fa-chalkboard-teacher"></i>
          <span>Penentuan Penguji</span></a>
      </li>
      <?php
      else :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="{{ route('penentuan_penguji') }}"
          style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Penentuan Penguji</span></a>
      </li>
      <?php
      endif;
      ?>
      @endif

      @if (Auth::user()->is_guru == 1 or Auth::user()->is_siswa == 1)
      <!-- Nav Item - Charts -->
      <?php
      if($mlap == 0) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/laporan" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Laporan</span></a>
      </li>
      <?php
      elseif(($skr >= $nyusaw && $skr <= $nyusakh)||($nyusakh == null && $skr >= $nyusaw)||($nyusaw == null && $skr <= $nyusakh)||($nyusaw == null && $nyusakh == null)||($mlap == 1)) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/laporan">
          <i class="fas fa-fw fa-book-open"></i>
          <span>Laporan</span></a>
      </li>
      <?php
      else :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/laporan" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Laporan</span></a>
      </li>
      <?php
      endif;
      ?>
      @endif

      @if (Auth::user()->is_siswa == 1)
      <!-- Nav Item - Charts -->
      <?php
      if($mpres == 0) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/presentasi" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Presentasi</span></a>
      </li>
      <?php
      elseif(($skr >= $nyusaw && $skr <= $nyusakh)||($nyusakh == null && $skr >= $nyusaw)||($nyusaw == null && $skr <= $nyusakh)||($nyusaw == null && $nyusakh == null)||($mpres == 1)) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/presentasi">
          <i class="fas fa-fw fa-chalkboard-teacher"></i>
          <span>Presentasi</span></a>
      </li>
      <?php
      else :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/presentasi" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Presentasi</span></a>
      </li>
      <?php
      endif;
      ?>
      @endif

      @if (Auth::user()->is_industri == 1)
      <!-- Nav Item - Charts -->
      <?php
      if($mpen == 0) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/penilaian" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Penilaian</span></a>
      </li>
      <?php
      elseif(($skr >= $bniaw && $skr <= $bniakh)||($bniakh == null && $skr >= $bniaw)||($bniaw == null && $skr <= $bniakh)||($bniaw == null && $bniakh == null)||($mpen == 1)) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/penilaian">
          <i class="fas fa-fw fa-pen-square"></i>
          <span>Penilaian</span></a>
      </li>
      <?php
      else :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/penilaian" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Penilaian</span></a>
      </li>
      <?php
      endif;
      ?>
      @endif

      @if (Auth::user()->is_guru == 1)
      <!-- Nav Item - Charts -->
      <?php
      if($muji == 0) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/pengujian" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Pengujian</span></a>
      </li>
      <?php
      elseif(($skr >= $ujiaw && $skr <= $ujiakh)||($ujiakh == null && $skr >= $ujiaw)||($ujiaw == null && $skr <= $ujiakh)||($ujiaw == null && $ujiakh == null)||($muji == 1)) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/pengujian">
          <i class="fas fa-fw fa-tasks"></i>
          <span>Pengujian</span></a>
      </li>
      <?php
      else :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/pengujian" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Pengujian</span></a>
      </li>
      <?php
      endif;
      ?>
      @endif

      @if (Auth::user()->is_siswa == 1 or Auth::user()->is_admin == 1)
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Laporan
      </div>
      @endif

      @if (Auth::user()->is_admin == 1)
      <?php
      if($mknj == 0) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/kunjungan" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-clipboard-list"></i>
          <span>Kunjungan</span></a>
      </li>
      <?php
      elseif(($skr >= $kegaw && $skr <= $kegakh)||($kegakh == null && $skr >= $kegaw)||($kegaw == null && $skr <= $kegakh)||($kegaw == null && $kegakh == null)||($mknj == 1)) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/kunjungan">
          <i class="fas fa-fw fa-clipboard-list"></i>
          <span>Kunjungan</span></a>
      </li>
      <?php
      else :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/kunjungan" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-clipboard-list"></i>
          <span>Kunjungan</span></a>
      </li>
      <?php
      endif;
      ?>

      <?php
      if($mnil == 0) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="{{ route('lapnil') }}" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Laporan Nilai</span></a>
      </li>
      <?php
      elseif(($skr >= $ujiaw && $skr <= $niakh)||($niakh == null && $skr >= $ujiaw)||($ujiaw == null && $skr <= $niakh)||($ujiaw == null && $niakh == null)||($mnil == 1)) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="{{ route('lapnil') }}">
          <i class="fas fa-fw fa-chart-line"></i>
          <span>Laporan Nilai</span></a>
      </li>
      <?php
      else :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="{{ route('lapnil') }}" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Laporan Nilai</span></a>
      </li>
      <?php
      endif;
      ?>
      @endif

      @if (Auth::user()->is_siswa == 1)
      <?php
      if($mnil == 0) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/nilai_saya" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Nilai</span></a>
      </li>
      <?php
      elseif(($skr >= $ujiaw && $skr <= $niakh)||($niakh == null && $skr >= $ujiaw)||($ujiaw == null && $skr <= $niakh)||($ujiaw == null && $niakh == null)||($mnil == 1)) :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/nilai_saya">
          <i class="fas fa-fw fa-chart-bar"></i>
          <span>Nilai</span></a>
      </li>
      <?php
      else :
      ?>
      <li class="nav-item" style="margin-top: -10px;">
        <a class="nav-link" href="/nilai_saya" style="pointer-events: none; color: rgb(73, 73, 73);">
          <i class="fas fa-fw fa-ban"></i>
          <span>Nilai</span></a>
      </li>
      <?php
      endif;
      ?>
      @endif

      <!-- Divider -->
      <hr class="sidebar-divider mb-0">

      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw"></i>
          <span>Keluar</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                @if (Auth::user()->foto == null)
                <img src="{{asset('/images/default.png')}}" alt="profil_{{Auth::user()->name}}"
                  class="img-profile rounded-circle" height="180px">
                @else
                <img src="{{ asset('/storage/profil/'.Auth::user()->foto) }}" alt="profil_{{Auth::user()->name}}"
                  class="img-profile rounded-circle" height="180px">
                @endif
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profil
                </a>
                <div class="dropdown-divider"></div>
                {{-- <a class="dropdown-item" href="{{ route('bantuan') }}">
                  <i class="fas fa-question fa-sm fa-fw mr-2 text-gray-400"></i>
                  Bantuan
                </a> --}}
                <a class="dropdown-item" data-toggle="modal" data-target="#TentangModal">
                  <i class="fas fa-exclamation fa-sm fa-fw mr-2 text-gray-400"></i>
                  Tentang
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Keluar
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
          <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
          </symbol>
          <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
              d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
          </symbol>
          <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
              d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
          </symbol>
        </svg>

        @if (Session::get('bidden'))
        <div class="row justify-content-end">
          <div class="col col-md-6">
            <div class="alert alert-danger d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                <use xlink:href="#exclamation-triangle-fill" />
              </svg>
              <div>
                <strong>Akses Ditolak!</strong> {{ Session::get('bidden') }}
                <button type="button" class="btn-close float-right" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            </div>
          </div>
        </div>
        @endif
        @if (Session::get('success'))
        <div class="row justify-content-end">
          <div class="col col-md-6">
            <div class="alert alert-success d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#check-circle-fill" />
              </svg>
              <div>
                <strong>Berhasil! </strong> {{ Session::get('success') }}
                <button type="button" class="btn-close float-right" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            </div>
          </div>
        </div>
        @endif
        @if (Session::get('fai'))
        <div class="row justify-content-end">
          <div class="col col-md-6">
            <div class="alert alert-danger d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                <use xlink:href="#exclamation-triangle-fill" />
              </svg>
              <div>
                <strong>Gagal! </strong> {{ Session::get('fai') }}
                <button type="button" class="btn-close float-right" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            </div>
          </div>
        </div>
        @endif
        @if (Session::get('inf'))
        <div class="row justify-content-end">
          <div class="col col-md-6">
            <div class="alert alert-info d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                <use xlink:href="#info-fill" />
              </svg>
              <div>
                <strong>Pemberitahuan! </strong> {{ Session::get('fai') }}
                <button type="button" class="btn-close float-right" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            </div>
          </div>
        </div>
        @endif
        @if (Session::get('warning'))
        <div class="row justify-content-end">
          <div class="col col-md-6">
            <div class="alert alert-warning d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                <use xlink:href="#exclamation-triangle-fill" />
              </svg>
              <div>
                <strong>Peringatan! </strong> {{ Session::get('fai') }}
                <button type="button" class="btn-close float-right" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            </div>
          </div>
        </div>
        @endif

        @yield('isi')

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer" style="background-color: rgba(0, 0, 0, 0);">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; SMKN 10 Garut
              {{ Carbon\Carbon::today()->format('Y') }}</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Tentang Modal-->
  <div class="modal fade" id="TentangModal" tabindex="-1" role="dialog" aria-labelledby="TentangModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="TentangModalLabel">Tentang Kami</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class=" row">
            <div class=" col-8">
              Sistem Informasi ini dibuat dan digunakan untuk keperluan Praktek Kerja Lapangan di Sekolah Menengah
              Kejuruan Negeri 10 Garut. Sistem ini dibuat sesuai dengan peraturan pemerintah mengenai Praktek Kerja
              Lapangan.
            </div>
            <div class=" col-4">
              <img src="{{asset('/images/logosmk10.png')}}" alt="smk" width="150" height="150">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          Code by: Taopiq Hidayat
          <img src="{{asset('/images/ITG.png')}}" alt="sttg" width="50" height="50">
        </div>
      </div>
    </div>
  </div>
  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Apa Anda yakin ingin keluar?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Pilih "Keluar" jika yakin ingin keluar.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <a class="btn btn-danger" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Keluar
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
  </script>

  <!-- Bootstrap core JavaScript-->
  <script src="/temsba2/vendor/jquery/jquery.min.js"></script>
  <script src="/temsba2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="/temsba2/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="/temsba2/js/sb-admin-2.min.js"></script>

  {{--
  <!-- Page level plugins -->
  <script src="/temsba2/vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="/temsba2/js/demo/chart-area-demo.js"></script>
  <script src="/temsba2/js/demo/chart-pie-demo.js"></script> --}}

  <script>
    const nav = document.getElementById('accordionSidebar');
    const item = document.querySelectorAll('ul.sidebar li.nav-item');
    const aktif = document.querySelector('.active');


    
    for(let i = 0; i < item.length; i++){
      item[i].onClick = aktif.setAttribute('class', 'nav-item');
    }
  </script>
  @yield('script')

</body>

</html>