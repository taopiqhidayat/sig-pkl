@extends('layout.main')

@section('title', 'Mengisi Kuis')

@section('mystyle')
{{-- <style>
  .w-5 {
    display: none;
  }
</style> --}}
@endsection

@section('isi')
@if (Auth::user()->is_siswa == 1)
<div class="container">
  <h3>MENGISI KUIS</h3>
  <div class="row">

    <div class="col-sm-12 col-md-8">
      <div class="card mb-2">
        <div class="card-body">
          <h4 class=" card-title">{{ $quiz->kuis}}</h4>
          <h6 class=" card-subtitle mb-2 text-muted">Batas Waktu: {{ $quiz->tangakhir}} {{ $quiz->wakakhir}}</h6>
        </div>
      </div>
      {{-- <form action="{{route('isi_kuis')}}" method="post">
      @csrf --}}
      @foreach ($tanyaan as $tanya)
      @php
      $choices = app('App\Http\Controllers\QuizzesController')->getPilihin($tanya->id);
      $jch = app('App\Http\Controllers\QuizzesController')->jumPilihin($tanya->id);
      $jchb = app('App\Http\Controllers\QuizzesController')->jumPilihinBenar($tanya->id);
      @endphp
      <div class="card mb-1">
        <div class="card-body">
          <label for="pertanyaan">{{ $tanyaan->count() * ($tanyaan->currentPage() - 1) + $loop->iteration }}.
            {{$tanya->tanyaan}} (Pilih {{$jchb}})</label>
          <hr>
          @if ($jchb === 1)
          @foreach ($choices as $ch)
          @php
          $dich = app('App\Http\Controllers\QuizzesController')->getdich($ch->id);
          @endphp
          <form action="{{route('isi_kuis')}}" method="post" id="fkuis">
            @csrf
            <input type="hidden" name="idk" id="idk" value="{{$quiz->id}}">
            <input type="hidden" name="idt" id="idt" value="{{$tanya->id}}">
            <input type="hidden" name="hini" id="hini" value="{{$tanyaan->currentPage()}}">
            <input type="hidden" name="hakhir" id="hakhir" value="{{$tanyaan->lastPage()}}">
            <input type="hidden" name="jch" id="jch" value="{{$jch}}">
            <input type="hidden" name="jchb" id="jchb" value="{{$jchb}}">
            <section id="rbb{{$ch->id}}">
              <input type="hidden" name="idrb" id="idrb" value="{{$ch->id}}">
              <div class=" form-check" id="fcrbb">
                @if ($dich == 1)
                <input type="radio" class=" form-check-input" value="0" name="rbb" id="rbb" checked>
                @else
                <input type="radio" class=" form-check-input" value="0" name="rbb" id="rbb">
                @endif
                <label for="rbb" class=" form-check-label">{{ $ch->pilihan }}</label>
              </div>
            </section>
          </form>
          @endforeach
          @elseif ($jchb >= 2)
          <form action="{{route('isi_kuis')}}" method="post" id="kuisf">
            @csrf
            <input type="hidden" name="idk" id="idk" value="{{$quiz->id}}">
            <input type="hidden" name="idt" id="idt" value="{{$tanya->id}}">
            <input type="hidden" name="hini" id="hini" value="{{$tanyaan->currentPage()}}">
            <input type="hidden" name="hakhir" id="hakhir" value="{{$tanyaan->lastPage()}}">
            <input type="hidden" name="jch" id="jch" value="{{$jch}}">
            <input type="hidden" name="jchb" id="jchb" value="{{$jchb}}">
            @foreach ($choices as $ch)
            @php
            $dich = app('App\Http\Controllers\QuizzesController')->getdich($ch->id);
            @endphp
            <input type="hidden" name="idcb[]" id="idcb" value="{{$ch->id}}">
            <input type="hidden" name="cbt[{{$ch->id}}]" id="cbt" value="0">
            <div class=" form-check">
              @if ($dich == 1)
              <input type="checkbox" class=" form-check-input" value="0" name="cbb{{$loop->iteration}}" id="cbb"
                checked>
              @else
              <input type="checkbox" class=" form-check-input" value="0" name="cbb{{$loop->iteration}}" id="cbb">
              @endif
              <label for="cbb" class=" form-check-label">{{ $ch->pilihan}}</label>
            </div>
            @endforeach
            @if ($tanyaan->currentPage() == $tanyaan->lastPage())
            <button type="submit" class=" btn btn-primary mt-3">Selesai</button>
            @else
            <button type="submit" class=" btn btn-primary mt-3">Selanjutnya</button>
            @endif
            @endif
          </form>
        </div>
      </div>
      @endforeach
      @php
      $jwb = 0;
      @endphp
      @foreach ($tanyaanget as $tanya)
      @php
      $jwb = $jwb + app('App\Http\Controllers\QuizzesController')->getSdhJwb($tanya->id);
      @endphp
      @endforeach
      @if ($kuisni != null && $jwb == $banyaktny)
      <a class=" btn btn-primary d-inline float-right" onclick="cnfkuis()">Selesai</a>
      @endif
      <div class=" text-gray-600 bg-secondary-50">
        {{ $tanyaan->links() }}
      </div>
      {{-- </form> --}}
    </div>
    <div class=" col-md-4">
      <div class=" row row-cols-md-5">
        @foreach ($tanyaanget as $tanya)
        <div class=" col-sm-4 col-md-2 align-self-center">
          @php
          $jawab = app('App\Http\Controllers\QuizzesController')->getSdhJwb($tanya->id);
          @endphp
          @if ($jawab == 1)
          <div class=" card border-success card-body p-0"
            style="width: 50px; height: 50px; max-width: 50px; ,max-height: 50px;">
            <div class=" row col p-2 align-self-center">
              <span class=" align-self-center text-success">{{ $loop->iteration }}</span>
            </div>
          </div>
          @else
          <div class=" card border-danger card-body p-0"
            style="width: 50px; height: 50px; max-width: 50px; ,max-height: 50px;">
            <div class=" row col p-2 align-self-center">
              <span class=" align-self-center text-danger">{{ $loop->iteration }}</span>
            </div>
          </div>
          @endif
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endif
@endsection

@section('script')
<script>
  // $('#tny2chb').change(function(){
  //   $('#kuisf').submit();
  // });
  const rbb = document.querySelectorAll('#rbb');
  const fc = document.querySelectorAll('#fkuis');
  const cbb = document.querySelectorAll('#cbb');

  for(let i=0; i < rbb.length; i++){
    rbb[i].addEventListener('change', function() {
      rbb[i].value = rbb[i].checked ? 1 : 0;
      fc[i].submit();
    });
  }
  
  for(let i=0; i < cbb.length; i++){
    cbb[i].addEventListener('change', function() {
      cbb[i].value = cbb[i].checked ? 1 : 0;
    });
  }

function cnfkuis(){
  var res = confirm('Apakah Anda yakin ingin selesai? Jika memilih Yes maka akan keluar dan Anda tidak bisa merubah hasil pekerjaan Anda.')
  if (res === true) {
    window.location = 'http://127.0.0.1:8000/tugas_siswa';
  }
}
</script>
@endsection