@extends('layout.main')

@section('title', 'Edit Kuis')

@section('isi')
@if (Auth::user()->is_admin == 1)
<div class="container">
  <h3>EDIT KUIS</h3>

  <div class="row">

    <div class="col-sm-12 col-md-8 overflow-auto shadow-sm" style="max-height: 480px;">
      @if ($quiz != null)
      <div class="card mb-2">
        <div class="card-body">
          <form action="{{route('update_kuis')}}" method="post" id="kuis">
            @csrf
            <input type="hidden" name="id" id="id" value="{{$quiz->id}}">
            <div class="form-group">
              <label for="kuis">Nama Kuis</label>
              <input type="text" class="form-control form-control-user" id="kuis" name="kuis"
                placeholder="Masukkan Nama Kuis..." value="{{ $quiz->kuis ?? old('kuis') }}">
              <span class="text-danger">@error('kuis') {{ $message }} @enderror</span>
            </div>
            <div class="form-group">
              <label for="jurusan">Jurusan</label>
              <select class="form-control form-select form-select-md" name="jurusan" id="jurusan">
                <option value="">Pilih Jurusan</option>
                @foreach( $jurusan as $data )
                @if ($quiz->jurusan)
                <option value="{{ $quiz->jurusan }}">{{ $quiz->jurusan }}</option>
                @endif
                <option value="{{ $data->jurusan }}">{{ $data->jurusan }}</option>
                @endforeach
              </select>
              <span class="text-danger">@error('jurusan') {{ $message }} @enderror</span>
            </div>
            <div class=" row">
              <div class=" col-md-5 mt-1">
                <div class="form-check d-inline">
                  @if ($quiz->untuk != null)
                  <input class="form-check-input" type="checkbox" value="1" id="individu" name="individu" checked>
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
                    @if ($quiz->untuk != null && $quiz->untuk == $data->nis)
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
                  placeholder="Masukkan Terakhir Pengiriman..." value="{{ $quiz->tangakhir ?? old('tangakhir') }}">
                <span class="text-danger">@error('tangakhir') {{ $message }} @enderror</span>
              </div>
              <div class="col-sm-6">
                <label for="wakakhir">Waktu</label>
                <input type="time" class="form-control form-control-user" id="wakakhir" name="wakakhir"
                  placeholder="Masukkan Terakhir Pengiriman..." value="{{ $quiz->wakakhir ?? old('wakakhir') }}">
                <span class="text-danger">@error('wakakhir') {{ $message }} @enderror</span>
              </div>
            </div>
            <div>
              <button type="submit" class="btn btn-warning d-inline">Edit</button>
          </form>
          <a class=" btn btn-primary d-inline" data-bs-toggle="collapse" href="#collaseTbhTanyaan" role="button"
            aria-expanded="false" aria-controls="collaseTbhTanyaan">Tambah Pertanyaan</a>
          {{-- <form action="" method="post" class=" d-inline">
            @csrf
            <input type="hidden" name="idk" id="idk" value="{{$quiz->id}}">
            <button type="submit" class="btn btn-danger mr-2 d-inline">Hapus</button>
          </form> --}}
        </div>
        <div class=" collapse" id="collaseTbhTanyaan">
          <div class=" card card-body mt-2">
            <form action="{{ route('store_edit_tanyaan') }}" method="post">
              @csrf
              <input type="hidden" name="idk" id="idk" value="{{$quiz->id}}">
              <div class=" form-group">
                <label for="tanyaan">Pertanyaan</label>
                <input type="text" class=" form-control" name="tanyaan" id="tanyaan" value="{{old('tanyaan')}}"
                  placeholder="Masukkan pertanyaan">
                <span class="text-danger">@error('tanyaan') {{ $message }} @enderror</span>
                <button type="submit" class=" btn btn-primary mt-2">Tambah</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    @foreach ($tanyaan as $tanya)
    @php
    $choices = app('App\Http\Controllers\QuizzesController')->getPilihin($tanya->id);
    $jch = app('App\Http\Controllers\QuizzesController')->jumPilihin($tanya->id);
    $jchb = app('App\Http\Controllers\QuizzesController')->jumPilihinBenar($tanya->id);
    @endphp
    <div class="card mb-1">
      <div class="card-body">
        <form action="{{route('update_tanyaan')}}" method="post">
          @csrf
          <input type="hidden" name="idk" id="idk" value="{{$quiz->id}}">
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
        <form action="/hapus_tanyaan/{{$tanya->id}}" method="post" class=" d-inline">
          @csrf
          @method('delete')
          <input type="hidden" name="idt" id="idt" value="{{$tanya->id}}">
          <button type="submit" class=" btn btn-danger d-inline">Hapus</button>
        </form>
      </div>
      <div class=" collapse" id="collaseTbhPilihan">
        <div class=" card card-body mt-2">
          <form action="{{ route('store_edit_pilihan') }}" method="post" id="tambahpilihan">
            @csrf
            <input type="hidden" name="idk" id="idk" value="{{$quiz->id}}">
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
                  <input type="checkbox" class=" form-check-input" name="pilihanbenar" id="pilihanbenar" value="1"
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
      <form action="{{route('update_pilihan')}}" method="post" id="editpilihan">
        @csrf
        <input type="hidden" name="idk" id="idk" value="{{$quiz->id}}">
        <input type="hidden" name="id" value="{{ $ch->id }}">
        <div class=" row">
          <div class=" col-md-10">
            <div class=" form-group">
              <label for="pilihan">Pilihan ke-{{ $loop->iteration }}</label>
              <input type="text" class=" form-control" name="pilihan" id="pilihan"
                value="{{ $ch->pilihan ?? old('pilihan') }}">
              <span class="text-danger">@error('pilihan') {{ $message }} @enderror</span>
            </div>
          </div>
          <div class=" col-md-2">
            <div class=" form-check">
              @if ($ch->benar == 0 || $ch->benar == null)
              <input type="checkbox" class=" form-check-input" value="0" name="pilihanbenar" id="pilihanbenar"
                style="margin-top: 70%;">
              @else
              <input type="checkbox" class=" form-check-input" value="1" name="pilihanbenar" id="pilihanbenar"
                style="margin-top: 70%;">
              @endif
              <label for="pilihanbenar" class=" form-check-label" style="margin-top: 92%;">Benar</label>
            </div>
          </div>
        </div>
        <div>
          <button type="submit" class="btn btn-warning d-inline">Edit</button>
      </form>
      <form action="/hapus_pilihan/{{$ch->id}}" method="post" class=" d-inline">
        @csrf
        @method('delete')
        <input type="hidden" name="idp" id="idp" value="{{$ch->id}}">
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
<a href="/tugas_siswa" class=" btn btn-primary mt-2">Selesai</a>
</div>
@endif
@endsection

@section('script')
<script>
  const centang = document.querySelector('#individu');
  const editpilihan = document.querySelectorAll('#editpilihan #pilihanbenar');
  const tambahpilihan = document.querySelectorAll('#tambahpilihan #pilihanbenar');

  centang.addEventListener('change', function() {
    centang.value = centang.checked ? 1 : 0;
  });

  for(let i = 0; i < editpilihan.length; i++){
  editpilihan[i].addEventListener('change', function() {
    editpilihan[i].value = editpilihan[i].checked ? 1 : 0;
  });
  }
  
  for(let i = 0; i < editpilihan.length; i++){
  tambahpilihan[i].addEventListener('change', function() {
    tambahpilihan[i].value = tambahpilihan[i].checked ? 1 : 0;
  });
  }

</script>
@endsection