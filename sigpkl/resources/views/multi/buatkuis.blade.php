@extends('layout.main')

@section('title', 'Buat Kuis')

@section('isi')
@if (Auth::user()->is_admin == 1)
<div class="container">
  <div class="row">
    <div class="col-sm-12 col-md-6 overflow-auto shadow-sm" style="max-height: 480px;">
      <h3>Buat Kuis</h3>

      @if ($kuis == null)
      <form action="{{route('store_kuis')}}" method="post" id="kuis">
        @csrf
        <div class="card mb-md-2 mb-sm-1">
          <div class="card-body">
            <div class="form-group">
              <label for="kuis">Nama Kuis</label>
              <input type="text" class="form-control form-control-user" id="kuis" name="kuis"
                placeholder="Masukkan Nama Kuis..." value="{{ $kuis->kuis ?? old('kuis') }}">
              <span class="text-danger">@error('kuis') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="jurusan">Jurusan</label>
              <select class="form-control form-select form-select-md" name="jurusan" id="jurusan">
                <option value="">Pilih Jurusan</option>
                @foreach( $jurusan as $data )
                <option value="{{ $data->jurusan }}">{{ $data->jurusan }}</option>
                @endforeach
              </select>
              <span class="text-danger">@error('jurusan') {{ $message }} @enderror</span>
            </div>
            <div class=" row">
              <div class="col col-md-6 mt-1">
                <div class="form-check d-inline">
                  <input class="form-check-input" type="checkbox" value="" id="individu" name="individu">
                  <label class="form-check-label" for="individu">
                    Untuk satu orang (opsional):
                  </label>
                </div>
              </div>
              <div class="col col-md-6">
                <div class=" form-inline">
                  <label for="siswa" class=" mr-2">Pilih Siswa</label>
                  <select class="form-control form-select form-select-md" name="siswa" id="siswa" style="width: 73%;">
                    <option value="">Pilih Siswa</option>
                    @foreach( $siswa as $data )
                    <option value="{{ $data->nis }}">{{ $data->kelas }} | {{ $data->nama }}</option>
                    @endforeach
                  </select>
                  <span class="text-danger">@error('siswa') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <label for="">Terakhir Pengiriman</label>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="tangakhir">Tanggal</label>
                <input type="date" class="form-control form-control-user" id="tangakhir" name="tangakhir"
                  placeholder="Masukkan Terakhir Pengiriman..." value="{{ $kuis->tangakhir ?? old('tangakhir') }}">
                <span class="text-danger">@error('tangakhir') {{ $message }} @enderror</span>
              </div>
              <div class="col-sm-6">
                <label for="wakakhir">Waktu</label>
                <input type="time" class="form-control form-control-user" id="wakakhir" name="wakakhir"
                  placeholder="Masukkan Terakhir Pengiriman..." value="{{ $kuis->wakakhir ?? old('wakakhir') }}">
                <span class="text-danger">@error('wakakhir') {{ $message }} @enderror</span>
              </div>
            </div>
            <a href="/tugas_siswa" class="btn btn-secondary mt-2">Batal</a>
            <button type="submit" class="btn btn-primary mt-2">Lanjutkan</button>
          </div>
        </div>
      </form>
      @else
      <div class="card mb-md-2 mb-sm-1">
        <div class="card-body">
          <div class=" row">
            <div class=" col-7">
              <h5>{{ $kuis->kuis }}</h5>
              <p>{{ $kuis->jurusan }}</p>
              @if ($kuis->untuk != null)
              <p>{{ $kuis->untuk }}</p>
              @endif
            </div>
            <div class=" col-5">
              <span>Terakhir: {{ $kuis->tangakhir }} ({{ $kuis->wakakhir }})</span>
            </div>
          </div>
        </div>
      </div>
      @endif

      @if ($kuis != null)
      <nav class=" mt-2">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link active" id="pilihan2-tab" data-bs-toggle="tab" data-bs-target="#pilihan2"
            type="button" role="tab" aria-controls="pilihan2" aria-selected="true">2 Pilihan</button>
          <button class="nav-link" id="pilihan3-tab" data-bs-toggle="tab" data-bs-target="#pilihan3" type="button"
            role="tab" aria-controls="pilihan3" aria-selected="false">3 Pilihan</button>
          <button class="nav-link" id="pilihan4-tab" data-bs-toggle="tab" data-bs-target="#pilihan4" type="button"
            role="tab" aria-controls="pilihan4" aria-selected="false">4 Pilihan</button>
          <button class="nav-link" id="pilihan5-tab" data-bs-toggle="tab" data-bs-target="#pilihan5" type="button"
            role="tab" aria-controls="pilihan5" aria-selected="false">5 Pilihan</button>
        </div>
      </nav>
      <div class="card mt-md-2 mt-sm-1">
        <div class="card-body">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="pilihan2" role="tabpanel" aria-labelledby="pilihan2-tab">
              <form action="{{route('store_tanyaan')}}" method="post">
                @csrf
                @if ($kuis != null)
                <input type="hidden" name="idkini" value="{{$kuis->id}}">
                @endif
                <input type="hidden" name="is2" value="1">
                <div class=" form-group">
                  @if ($tanyaan != null)
                  <label for="tanyaan2">Pertanyaan Selanjutnya</label>
                  @else
                  <label for="tanyaan2">Pertanyaan</label>
                  @endif
                  <input type="text" class=" form-control" name="tanyaan2" id="tanyaan2" value="{{old('tanyaan2')}}"
                    placeholder="Masukkan pertanyaan">
                  <span class="text-danger">@error('tanyaan2') {{ $message }} @enderror</span>
                </div>
                <div class=" row">
                  <div class=" col-10">
                    <div class=" form-group">
                      <label for="pilihan2a">Pilihan A</label>
                      <input type="text" class=" form-control" name="pilihan2a" id="pilihan2a"
                        value="{{old('pilihan2a')}}">
                    </div>
                  </div>
                  <div class=" col-2">
                    <div class=" form-check">
                      <input type="checkbox" class=" form-check-input" name="pilihan2abenar" id="pilihan2abenar"
                        style="margin-top: 70%;">
                      <label for="pilihan2abenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
                    </div>
                  </div>
                </div>
                <div class=" row">
                  <div class=" col-10">
                    <div class=" form-group">
                      <label for="pilihan2b">Pilihan B</label>
                      <input type="text" class=" form-control" name="pilihan2b" id="pilihan2b"
                        value="{{old('pilihan2b')}}">
                    </div>
                  </div>
                  <div class=" col-2">
                    <div class=" form-check">
                      <input type="checkbox" class=" form-check-input" name="pilihan2bbenar" id="pilihan2bbenar"
                        style="margin-top: 70%;">
                      <label for="pilihan2bbenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
                    </div>
                  </div>
                </div>
                <button type="submit" class=" btn btn-primary">Simpan</button>
              </form>
            </div>
            <div class="tab-pane fade" id="pilihan3" role="tabpanel" aria-labelledby="pilihan3-tab">
              <form action="{{route('store_tanyaan')}}" method="post">
                @csrf
                @if ($kuis != null)
                <input type="hidden" name="idkini" value="{{$kuis->id}}">
                @endif
                <input type="hidden" name="is3" value="1">
                <div class=" form-group">
                  @if ($tanyaan != null)
                  <label for="tanyaan3">Pertanyaan Selanjutnya</label>
                  @else
                  <label for="tanyaan3">Pertanyaan</label>
                  @endif
                  <input type="text" class=" form-control" name="tanyaan3" id="tanyaan3" value="{{old('tanyaan3')}}"
                    placeholder="Masukkan pertanyaan">
                  <span class="text-danger">@error('tanyaan3') {{ $message }} @enderror</span>
                </div>
                <div class=" row">
                  <div class=" col-10">
                    <div class=" form-group">
                      <label for="pilihan3a">Pilihan A</label>
                      <input type="text" class=" form-control" name="pilihan3a" id="pilihan3a"
                        value="{{old('pilihan3a')}}">
                    </div>
                  </div>
                  <div class=" col-2">
                    <div class=" form-check">
                      <input type="checkbox" class=" form-check-input" name="pilihan3abenar" id="pilihan3abenar"
                        style="margin-top: 70%;">
                      <label for="pilihan3abenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
                    </div>
                  </div>
                </div>
                <div class=" row">
                  <div class=" col-10">
                    <div class=" form-group">
                      <label for="pilihan3b">Pilihan B</label>
                      <input type="text" class=" form-control" name="pilihan3b" id="pilihan3b"
                        value="{{old('pilihan3b')}}">
                    </div>
                  </div>
                  <div class=" col-2">
                    <div class=" form-check">
                      <input type="checkbox" class=" form-check-input" name="pilihan3bbenar" id="pilihan3bbenar"
                        style="margin-top: 70%;">
                      <label for="pilihan3bbenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
                    </div>
                  </div>
                </div>
                <div class=" row">
                  <div class=" col-10">
                    <div class=" form-group">
                      <label for="pilihan3c">Pilihan C</label>
                      <input type="text" class=" form-control" name="pilihan3c" id="pilihan3c"
                        value="{{old('pilihan3c')}}">
                    </div>
                  </div>
                  <div class=" col-2">
                    <div class=" form-check">
                      <input type="checkbox" class=" form-check-input" name="pilihan3cbenar" id="pilihan3cbenar"
                        style="margin-top: 70%;">
                      <label for="pilihan3cbenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
                    </div>
                  </div>
                </div>
                <button type="submit" class=" btn btn-primary">Simpan</button>
              </form>
            </div>
            <div class="tab-pane fade" id="pilihan4" role="tabpanel" aria-labelledby="pilihan4-tab">
              <form action="{{route('store_tanyaan')}}" method="post">
                @csrf
                @if ($kuis != null)
                <input type="hidden" name="idkini" value="{{$kuis->id}}">
                @endif
                <input type="hidden" name="is4" value="1">
                <div class=" form-group">
                  @if ($tanyaan != null)
                  <label for="tanyaan4">Pertanyaan Selanjutnya</label>
                  @else
                  <label for="tanyaan4">Pertanyaan</label>
                  @endif
                  <input type="text" class=" form-control" name="tanyaan4" id="tanyaan4" value="{{old('tanyaan4')}}"
                    placeholder="Masukkan pertanyaan">
                  <span class="text-danger">@error('tanyaan4') {{ $message }} @enderror</span>
                </div>
                <div class=" row">
                  <div class=" col-10">
                    <div class=" form-group">
                      <label for="pilihan4a">Pilihan A</label>
                      <input type="text" class=" form-control" name="pilihan4a" id="pilihan4a"
                        value="{{old('pilihan4a')}}">
                    </div>
                  </div>
                  <div class=" col-2">
                    <div class=" form-check">
                      <input type="checkbox" class=" form-check-input" name="pilihan4abenar" id="pilihan4abenar"
                        style="margin-top: 70%;">
                      <label for="pilihan4abenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
                    </div>
                  </div>
                </div>
                <div class=" row">
                  <div class=" col-10">
                    <div class=" form-group">
                      <label for="pilihan4b">Pilihan B</label>
                      <input type="text" class=" form-control" name="pilihan4b" id="pilihan4b"
                        value="{{old('pilihan4b')}}">
                    </div>
                  </div>
                  <div class=" col-2">
                    <div class=" form-check">
                      <input type="checkbox" class=" form-check-input" name="pilihan4bbenar" id="pilihan4bbenar"
                        style="margin-top: 70%;">
                      <label for="pilihan4bbenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
                    </div>
                  </div>
                </div>
                <div class=" row">
                  <div class=" col-10">
                    <div class=" form-group">
                      <label for="pilihan4c">Pilihan C</label>
                      <input type="text" class=" form-control" name="pilihan4c" id="pilihan4c"
                        value="{{old('pilihan4c')}}">
                    </div>
                  </div>
                  <div class=" col-2">
                    <div class=" form-check">
                      <input type="checkbox" class=" form-check-input" name="pilihan4cbenar" id="pilihan4cbenar"
                        style="margin-top: 70%;">
                      <label for="pilihan4cbenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
                    </div>
                  </div>
                </div>
                <div class=" row">
                  <div class=" col-10">
                    <div class=" form-group">
                      <label for="pilihan4d">Pilihan D</label>
                      <input type="text" class=" form-control" name="pilihan4d" id="pilihan4d"
                        value="{{old('pilihan4d')}}">
                    </div>
                  </div>
                  <div class=" col-2">
                    <div class=" form-check">
                      <input type="checkbox" class=" form-check-input" name="pilihan4dbenar" id="pilihan4dbenar"
                        style="margin-top: 70%;">
                      <label for="pilihan4dbenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
                    </div>
                  </div>
                </div>
                <button type="submit" class=" btn btn-primary">Simpan</button>
              </form>
            </div>
            <div class="tab-pane fade" id="pilihan5" role="tabpanel" aria-labelledby="pilihan5-tab">
              <form action="{{route('store_tanyaan')}}" method="post">
                @csrf
                @if ($kuis != null)
                <input type="hidden" name="idkini" value="{{$kuis->id}}">
                @endif
                <input type="hidden" name="is5" value="1">
                <div class=" form-group">
                  @if ($tanyaan != null)
                  <label for="tanyaan5">Pertanyaan Selanjutnya</label>
                  @else
                  <label for="tanyaan5">Pertanyaan</label>
                  @endif
                  <input type="text" class=" form-control" name="tanyaan5" id="tanyaan5" value="{{old('tanyaan5')}}"
                    placeholder="Masukkan pertanyaan">
                  <span class="text-danger">@error('tanyaan5') {{ $message }} @enderror</span>
                </div>
                <div class=" row">
                  <div class=" col-10">
                    <div class=" form-group">
                      <label for="pilihan5a">Pilihan A</label>
                      <input type="text" class=" form-control" name="pilihan5a" id="pilihan5a"
                        value="{{old('pilihan5a')}}">
                    </div>
                  </div>
                  <div class=" col-2">
                    <div class=" form-check">
                      <input type="checkbox" class=" form-check-input" name="pilihan5abenar" id="pilihan5abenar"
                        style="margin-top: 70%;">
                      <label for="pilihan5abenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
                    </div>
                  </div>
                </div>
                <div class=" row">
                  <div class=" col-10">
                    <div class=" form-group">
                      <label for="pilihan5b">Pilihan B</label>
                      <input type="text" class=" form-control" name="pilihan5b" id="pilihan5b"
                        value="{{old('pilihan5b')}}">
                    </div>
                  </div>
                  <div class=" col-2">
                    <div class=" form-check">
                      <input type="checkbox" class=" form-check-input" name="pilihan5bbenar" id="pilihan5bbenar"
                        style="margin-top: 70%;">
                      <label for="pilihan5bbenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
                    </div>
                  </div>
                </div>
                <div class=" row">
                  <div class=" col-10">
                    <div class=" form-group">
                      <label for="pilihan5c">Pilihan C</label>
                      <input type="text" class=" form-control" name="pilihan5c" id="pilihan5c"
                        value="{{old('pilihan5c')}}">
                    </div>
                  </div>
                  <div class=" col-2">
                    <div class=" form-check">
                      <input type="checkbox" class=" form-check-input" name="pilihan5cbenar" id="pilihan5cbenar"
                        style="margin-top: 70%;">
                      <label for="pilihan5cbenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
                    </div>
                  </div>
                </div>
                <div class=" row">
                  <div class=" col-10">
                    <div class=" form-group">
                      <label for="pilihan5d">Pilihan D</label>
                      <input type="text" class=" form-control" name="pilihan5d" id="pilihan5d"
                        value="{{old('pilihan5d')}}">
                    </div>
                  </div>
                  <div class=" col-2">
                    <div class=" form-check">
                      <input type="checkbox" class=" form-check-input" name="pilihan5dbenar" id="pilihan5dbenar"
                        style="margin-top: 70%;">
                      <label for="pilihan5dbenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
                    </div>
                  </div>
                </div>
                <div class=" row">
                  <div class=" col-10">
                    <div class=" form-group">
                      <label for="pilihan5e">Pilihan E</label>
                      <input type="text" class=" form-control" name="pilihan5e" id="pilihan5e"
                        value="{{old('pilihan5e')}}">
                    </div>
                  </div>
                  <div class=" col-2">
                    <div class=" form-check">
                      <input type="checkbox" class=" form-check-input" name="pilihan5ebenar" id="pilihan5ebenar"
                        style="margin-top: 70%;">
                      <label for="pilihan5ebenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
                    </div>
                  </div>
                </div>
                <button type="submit" class=" btn btn-primary">Simpan</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif

    <div class="col-sm-12 col-md-6 overflow-auto shadow-sm" style="max-height: 480px;">
      @if ($kuis != null)
      <h3>Edit Kuis</h3>
      <form action="{{route('update_buat_kuis')}}" method="post" id="kuis">
        @csrf
        <div class="card mb-md-2 mb-sm-1">
          <div class="card-body">
            <input type="hidden" name="id" id="id" value="{{$kuis->id}}">
            <div class="form-group">
              <label for="kuis">Nama Kuis</label>
              <input type="text" class="form-control form-control-user" id="kuis" name="kuis"
                placeholder="Masukkan Nama Kuis..." value="{{ $kuis->kuis ?? old('kuis') }}">
              <span class="text-danger">@error('kuis') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="jurusan">Jurusan</label>
              <select class="form-control form-select form-select-md" name="jurusan" id="jurusan">
                <option value="">Pilih Jurusan</option>
                @foreach( $jurusan as $data )
                @if ($kuis->jurusan)
                <option value="{{ $kuis->jurusan }}">{{ $kuis->jurusan }}</option>
                @endif
                <option value="{{ $data->jurusan }}">{{ $data->jurusan }}</option>
                @endforeach
              </select>
              <span class="text-danger">@error('jurusan') {{ $message }} @enderror</span>
            </div>
            <div class=" row">
              <div class=" col-md-5 mt-1">
                <div class="form-check d-inline">
                  @if ($kuis->untuk != null)
                  <input class="form-check-input" type="checkbox" value="" id="individu" name="individu" checked>
                  @else
                  <input class="form-check-input" type="checkbox" value="" id="individu" name="individu">
                  @endif
                  <label class="form-check-label" for="individu">
                    Untuk satu orang (opsional):
                  </label>
                </div>
              </div>
              <div class=" col-md">
                <div class=" form-inline">
                  <label for="siswa" class=" mr-2">Pilih Siswa</label>
                  <select class="form-control form-select form-select-md" name="siswa" id="siswa" style="width: 73%;">
                    <option value="">Pilih Siswa</option>
                    @foreach( $siswa as $data )
                    @if ($kuis->untuk != null && $kuis->untuk == $data->nis)
                    <option value="{{ $data->nis }}">{{ $data->kelas }} | {{ $data->nama }}</option>
                    @endif
                    <option value="{{ $data->nis }}">{{ $data->kelas }} | {{ $data->nama }}</option>
                    @endforeach
                  </select>
                  <span class="text-danger">@error('siswa') {{ $message }} @enderror</span>
                </div>
              </div>
            </div>
            <label for="">Terakhir Pengiriman</label>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="tangakhir">Tanggal</label>
                <input type="date" class="form-control form-control-user" id="tangakhir" name="tangakhir"
                  placeholder="Masukkan Terakhir Pengiriman..." value="{{ $kuis->tangakhir ?? old('tangakhir') }}">
                <span class="text-danger">@error('tangakhir') {{ $message }} @enderror</span>
              </div>
              <div class="col-sm-6">
                <label for="wakakhir">Waktu</label>
                <input type="time" class="form-control form-control-user" id="wakakhir" name="wakakhir"
                  placeholder="Masukkan Terakhir Pengiriman..." value="{{ $kuis->wakakhir ?? old('wakakhir') }}">
                <span class="text-danger">@error('wakakhir') {{ $message }} @enderror</span>
              </div>
            </div>
            <button type="submit" class="btn btn-warning mt-2">Edit</button>
          </div>
        </div>
      </form>
      @foreach ($tanyaan as $tanya)
      @php
      $choices = app('App\Http\Controllers\QuizzesController')->getPilihin($tanya->id);
      $jch = app('App\Http\Controllers\QuizzesController')->jumPilihin($tanya->id);
      $jchb = app('App\Http\Controllers\QuizzesController')->jumPilihinBenar($tanya->id);
      @endphp
      <div class="card mb-md-2 mb-sm-1">
        <div class="card-body">
          <form action="{{route('update_buat_tanyaan')}}" method="post">
            @csrf
            <input type="hidden" name="idk" id="idk" value="{{$kuis->id}}">
            <input type="hidden" name="id" value="{{ $tanya->id }}">
            <div class=" form-group">
              <label for="pertanyaan">Pertanyaan ke-{{ $loop->iteration }}</label>
              <input type="text" class=" form-control" name="pertanyaan" id="pertanyaan"
                value="{{$tanya->tanyaan ?? old('pertanyaan'.$loop->iteration)}}">
              <span class="text-danger">@error('pertanyaan') {{ $message }} @enderror</span>
            </div>
            <div>
              <button type="submit" class=" btn btn-warning d-inline">Edit</button>
              @if ($jch <= 5) <a class=" btn btn-primary d-inline" data-bs-toggle="collapse" href="#collaseTbhPilihan"
                role="button" aria-expanded="false" aria-controls="collaseTbhPilihan">Tambah Pilihan</a>
                @endif
          </form>
          <form action="/hapus_tanyaan_buat/{{$tanya->id}}" method="post" class=" d-inline">
            @method('delete')
            @csrf
            <input type="hidden" name="idk" id="idk" value="{{$kuis->id}}">
            <button type="submit" class=" btn btn-danger d-inline">Hapus</button>
          </form>
        </div>
        <div class=" collapse" id="collaseTbhPilihan">
          <div class=" card card-body">
            <form action="{{route('str_edit_buat_pilihan')}}" method="post">
              @csrf
              <input type="hidden" name="idk" id="idk" value="{{$kuis->id}}">
              <input type="hidden" name="idt" id="idt" value="{{$tanya->id}}">
              <div class=" row">
                <div class=" col-10">
                  <div class=" form-group">
                    <label for="pilihan">Pilihan</label>
                    <input type="text" class=" form-control" name="pilihan" id="pilihan" value="{{old('pilihan')}}">
                  </div>
                </div>
                <div class=" col-2">
                  <div class=" form-check">
                    <input type="checkbox" class=" form-check-input" name="pilihanbenar" id="pilihanbenar"
                      style="margin-top: 70%;">
                    <label for="pilihanbenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
                  </div>
                </div>
              </div>
              <button type="submit" class=" btn btn-primary mt-2">Tambah</button>
            </form>
          </div>
        </div>
        <hr>
        @foreach ($choices as $ch)
        <form action="{{route('update_buat_pilihan')}}" method="post">
          @csrf
          <input type="hidden" name="idk" id="idk" value="{{$kuis->id}}">
          <input type="hidden" name="id" value="{{ $ch->id }}">
          <div class=" row">
            <div class=" col-10">
              <div class=" form-group">
                <label for="pilihan">Pilihan ke-{{ $loop->iteration }}</label>
                <input type="text" class=" form-control" name="pilihan" id="pilihan"
                  value="{{ $ch->pilihan ?? old('pilihan') }}">
                <span class="text-danger">@error('pilihan') {{ $message }} @enderror</span>
              </div>
            </div>
            <div class=" col-2">
              <div class=" form-check">
                @if ($ch->benar == 1)
                <input type="checkbox" class=" form-check-input" value="1" name="pilihanbenar" id="pilihanbenar"
                  style="margin-top: 70%;" checked>
                @else
                <input type="checkbox" class=" form-check-input" value="0" name="pilihanbenar" id="pilihanbenar"
                  style="margin-top: 70%;">
                @endif
                <label for="pilihanbenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
              </div>
            </div>
          </div>
          <div>
            <button type="submit" class="btn btn-warning d-inline">Edit</button>
        </form>
        <form action="/hapus_pilihan_buat/{{$ch->id}}" method="post" class=" d-inline">
          @method('delete')
          @csrf
          <input type="hidden" name="idk" id="idk" value="{{$kuis->id}}">
          <button type="submit" class="btn btn-danger mr-2 d-inline">Hapus</button>
        </form>
      </div>
      @endforeach
    </div>
  </div>
  @endforeach
  @endif
</div>
</div>
@if ($kuis != null)
<a href="/tugas_siswa" class=" btn btn-primary mt-3">Selesai</a>
@endif
</div>
@endif
@endsection

@section('script')
<script>
  // const tbhtanya = document.querySelector('#tbhtanyaan');
  // const tbhpilih = document.querySelector('#tbhpilihan');

  // tbhtanya.addEventListener('click', function(){
  //   const jumpertanyaan = document.querySelectorAll('div.pertanyaan');
  //   const ke = jumpertanyaan.length + 1;
  //   const name = 'tanyaan'+ke;
  //   const soal = 'pertanyaan'+ke;

  //   const form = document.querySelector('form#kuis');
  //   const section = document.querySelector('section#pertanyaan');
  //   const cardbaru = document.createElement('div');
  //   const cardbodybaru = document.createElement('div');
  //   const divbaru = document.createElement('div');
  //   const labelbaru = document.createElement('label');
  //   const inputbaru = document.createElement('input');
  //   const teksbaru = document.createTextNode('Pertanyaan ke-'+ke);

  //   cardbaru.setAttribute('class', 'card mt-1 pertanyaan');
  //   cardbodybaru.setAttribute('class', 'card-body '+soal);
  //   divbaru.setAttribute('class', 'form-group '+name);
  //   labelbaru.setAttribute('for', name);
  //   inputbaru.setAttribute('type', 'text');
  //   inputbaru.setAttribute('class', 'form-control');
  //   inputbaru.setAttribute('nama', name);
  //   inputbaru.setAttribute('id', name);
  //   inputbaru.setAttribute('value', '');
  //   labelbaru.appendChild(teksbaru);
  //   divbaru.appendChild(labelbaru);
  //   divbaru.appendChild(inputbaru);
  //   cardbodybaru.appendChild(divbaru);
  //   cardbaru.appendChild(cardbodybaru);
  //   section.appendChild(cardbaru);
  //   form.appendChild(section);
  //   alert('Pertanyaan ke-'+ke+ ' ditambahakan');
  // });
  
  // tbhpilih.addEventListener('click', function(){
  //   const jumpertanyaan = document.querySelectorAll('div.pertanyaan');
  //   const tanyaanke = jumpertanyaan.length;
  //   const soal = 'pertanyaan'+tanyaanke;
  //   const jumpilihan = document.querySelectorAll('div.card-body.'+soal+' div.row.pilihan');
  //   const pilihanke = jumpilihan.length + 1;
  //   const name = 'pilihan'+pilihanke;

  //   const cardbody = document.querySelector('div.card-body.'+soal);
  //   const divrowbaru = document.createElement('div');
  //   const divcolbaru1 = document.createElement('div');
  //   const divcolbaru2 = document.createElement('div');
  //   const divteksbaru = document.createElement('div');
  //   const divcheckbaru = document.createElement('div');
  //   const teksbaru = document.createElement('input');
  //   const labelteksbaru = document.createElement('label');
  //   const isilabelteks = document.createTextNode('Pilihan '+pilihanke);
  //   const checkbaru = document.createElement('input');
  //   const labelcheckkbaru = document.createElement('label');
  //   const isilabelcheck = document.createTextNode('Benar');

  //   divrowbaru.setAttribute('class', 'row pilihan');
  //   divcolbaru1.setAttribute('class', 'col-2');
  //   divcheckbaru.setAttribute('class', 'form-check d-inline '+name);
  //   checkbaru.setAttribute('class', 'form-check-input');
  //   checkbaru.setAttribute('type', 'checkbox');
  //   checkbaru.setAttribute('value', '');
  //   checkbaru.setAttribute('id', 'bnr'+name+soal);
  //   checkbaru.setAttribute('nama', 'bnr'+name+soal);
  //   checkbaru.style.marginTop = '70%';
  //   labelcheckkbaru.setAttribute('for', 'bnr'+name+soal);
  //   labelcheckkbaru.setAttribute('class', 'form-check-label');
  //   labelcheckkbaru.style.marginTop = '54%';
  //   labelcheckkbaru.appendChild(isilabelcheck);
    
  //   divcolbaru2.setAttribute('class', 'col-10');
  //   divteksbaru.setAttribute('class', 'form-group');
  //   labelteksbaru.setAttribute('for', name+soal);
  //   teksbaru.setAttribute('type', 'text');
  //   teksbaru.setAttribute('class', 'form-control w-100');
  //   teksbaru.setAttribute('id', name+soal);
  //   teksbaru.setAttribute('nama', name+soal);
  //   teksbaru.setAttribute('placeholder', 'Masukkan pilihan');
  //   labelteksbaru.appendChild(isilabelteks);

  //   divcheckbaru.appendChild(checkbaru);
  //   divcheckbaru.appendChild(labelcheckkbaru);
  //   divcolbaru1.appendChild(divcheckbaru);

  //   divteksbaru.appendChild(labelteksbaru);
  //   divteksbaru.appendChild(teksbaru);
  //   divcolbaru2.appendChild(divteksbaru);

  //   divrowbaru.appendChild(divcolbaru2);
  //   divrowbaru.appendChild(divcolbaru1);
  //   cardbody.appendChild(divrowbaru);
  //   alert('Pilihan ke-'+pilihanke+' dari Pertanyaan ke-'+tanyaanke+' ditambahkan')
    
  //   const benar = document.querySelector('input#bnr'+name+soal);
  //   benar.addEventListener('change', function() {
  //     benar.value = benar.checked ? 1 : 0;
  //     alert(benar.value);
  //   });
  // });
</script>
<script>
  const centang = document.querySelector('#individu');
  const pilihan2a = document.querySelector('#pilihan2abenar');
  const pilihan2b = document.querySelector('#pilihan2bbenar');
  const pilihan3a = document.querySelector('#pilihan3abenar');
  const pilihan3b = document.querySelector('#pilihan3bbenar');
  const pilihan3c = document.querySelector('#pilihan3cbenar');
  const pilihan4a = document.querySelector('#pilihan4abenar');
  const pilihan4b = document.querySelector('#pilihan4bbenar');
  const pilihan4c = document.querySelector('#pilihan4cbenar');
  const pilihan4d = document.querySelector('#pilihan4dbenar');
  const pilihan5a = document.querySelector('#pilihan5abenar');
  const pilihan5b = document.querySelector('#pilihan5bbenar');
  const pilihan5c = document.querySelector('#pilihan5cbenar');
  const pilihan5d = document.querySelector('#pilihan5dbenar');
  const pilihan5e = document.querySelector('#pilihan5ebenar');
  
  const editpilihan = document.querySelectorAll('#pilihanbenar');

  centang.addEventListener('change', function() {
    centang.value = centang.checked ? 1 : 0;
  });
  
  pilihan2a.addEventListener('change', function() {
    pilihan2a.value = pilihan2a.checked ? 1 : 0;
  });
  pilihan2b.addEventListener('change', function() {
    pilihan2b.value = pilihan2b.checked ? 1 : 0;
  });

  pilihan3a.addEventListener('change', function() {
    pilihan3a.value = pilihan3a.checked ? 1 : 0;
  });
  pilihan3b.addEventListener('change', function() {
    pilihan3b.value = pilihan3b.checked ? 1 : 0;
  });
  pilihan3c.addEventListener('change', function() {
    pilihan3c.value = pilihan3c.checked ? 1 : 0;
  });

  pilihan4a.addEventListener('change', function() {
    pilihan4a.value = pilihan4a.checked ? 1 : 0;
  });
  pilihan4b.addEventListener('change', function() {
    pilihan4b.value = pilihan4b.checked ? 1 : 0;
  });
  pilihan4c.addEventListener('change', function() {
    pilihan4c.value = pilihan4c.checked ? 1 : 0;
  });
  pilihan4d.addEventListener('change', function() {
    pilihan4d.value = pilihan4d.checked ? 1 : 0;
  });

  pilihan5a.addEventListener('change', function() {
    pilihan5a.value = pilihan5a.checked ? 1 : 0;
  });
  pilihan5b.addEventListener('change', function() {
    pilihan5b.value = pilihan5b.checked ? 1 : 0;
  });
  pilihan5c.addEventListener('change', function() {
    pilihan5c.value = pilihan5c.checked ? 1 : 0;
  });
  pilihan5d.addEventListener('change', function() {
    pilihan5d.value = pilihan5d.checked ? 1 : 0;
  });
  pilihan5e.addEventListener('change', function() {
    pilihan5e.value = pilihan5e.checked ? 1 : 0;
  });
  
  for(let i = 0; i < editpilihan.length; i++){
  editpilihan[i].addEventListener('change', function() {
    editpilihan[i].value = editpilihan[i].checked ? 1 : 0;
  });
  }

</script>
@endsection