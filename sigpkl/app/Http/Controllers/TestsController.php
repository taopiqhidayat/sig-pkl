<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Test;
use App\Models\Report;
use App\Models\Presentation;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Session;

class TestsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uji()
    {
        if (Auth::user()->is_guru == 1) {
            $ni = Teacher::where('id_user', Auth::user()->id)->first();
            $uji = DB::table('tests')
                ->join('students', 'tests.nis', '=', 'students.nis')
                ->select('students.*', 'tests.*')
                ->where('pembimbing', $ni->n_induk)
                ->orwhere('penguji', $ni->n_induk)
                ->get();
            $data = Test::where('pembimbing', $ni->n_induk)->orwhere('penguji', $ni->n_induk)->count();
            return view('guru.pengujian', compact('uji', 'data'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    public function getni1($nis)
    {
        $ni = Teacher::where('id_user', Auth::user()->id)->first();
        $test = Test::where('nis', $nis)->first();
        $cek1 = Report::where('nis', $nis)->first();

        if ($test->pembimbing == $ni->n_induk) {
            $ret = $cek1->nilai_a;
            return $ret;
        } elseif ($test->penguji == $ni->n_induk) {
            $ret = $cek1->nilai_b;
            return $ret;
        }
    }

    public function getni2($nis)
    {
        $ni = Teacher::where('id_user', Auth::user()->id)->first();
        $test = Test::where('nis', $nis)->first();
        $cek2 = Presentation::where('nis', $nis)->first();

        if ($test->pembimbing == $ni->n_induk) {
            $ret = $cek2->nilai_a;
            return $ret;
        } elseif ($test->penguji == $ni->n_induk) {
            $ret = $cek2->nilai_b;
            return $ret;
        }
    }

    public function getIdLaporan($nis)
    {
        $re = Report::where('nis', $nis)->first();
        if ($re != null) {
            $ret = $re->id;
            return $ret;
        } else {
            return null;
        }
    }

    public function getIdPresentasi($nis)
    {
        $sen = Presentation::where('nis', $nis)->first();
        if ($sen != null) {
            $ret = $sen->id;
            return $ret;
        } else {
            return null;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'penguji'       => 'required',
            'tanggal'       => 'required|date',
            'waktu'         => 'required',
        ];

        $messages = [
            'penguji.required'      => 'Penguji wajib diisi',
            'tanggal.required'      => 'Tanggal wajib diisi',
            'tanggal.date'          => 'Data beruapa tanggal',
            'waktu.required'        => 'Waktu wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $save = Test::where('nis', $request->nis)
            ->update([
                'penguji'       => $request->penguji,
                'tanggal'       => $request->tanggal,
                'waktu'         => $request->waktu,
                'updated_at'    => \Carbon\Carbon::now(),
            ]);
        if ($save) {
            Session::flash('success', 'Berhasil! Data penguji tealah ditetapkan');
            return redirect()->route('penentuan_penguji');
        }
        Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        //
    }
}
