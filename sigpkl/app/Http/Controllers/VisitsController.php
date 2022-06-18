<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Teacher;
use App\Models\Industrie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Session;

class VisitsController extends Controller
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
        if (Auth::user()->is_guru == 1) {
            $ni = Teacher::where('id_user', Auth::user()->id)->first();
            $kunjung = DB::table('visits')
                ->join('industries', 'visits.id_industri', '=', 'industries.id')
                ->select('industries.nama', 'visits.*')
                ->where('visits.n_induk', $ni->n_induk)
                ->get();
            $data = Visit::where('n_induk', $ni->n_induk)->count();
            return view('multi.kunjungan', compact('kunjung', 'data'));
        } elseif (Auth::user()->is_admin == 1) {
            $kunjung = DB::table('visits')
                ->join('industries', 'visits.id_industri', '=', 'industries.id')
                ->select('industries.nama', 'visits.*')
                ->get();
            $data = Visit::all()->count();
            return view('multi.kunjungan', compact('kunjung', 'data'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->is_guru == 1) {
            $industri = Industrie::select('*')->orderby('nama', 'asc')->get();
            return view('guru.tambahkunjungan', compact('industri'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'industri' => 'required',
            'knsiswa' => 'required',
            'knindu' => 'required',
            'khnsiswa' => 'nullable',
            'khnindu' => 'nullable',
            'kinsiswa' => 'required',
        ];

        $messages = [
            'industri.required'    => 'Industi wajib diisi',
            'knsiswa.required'    => 'Kondisi Siswa wajib diisi',
            'knindu.required'    => 'Kondisi Industri wajib diisi',
            'kinsiswa.required'    => 'Kinerja Siswa wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $ni = Teacher::where('id_user', Auth::user()->id)->first();

        $simpan = new Visit;
        $simpan->n_induk = $ni->n_induk;
        $simpan->id_industri = $request->industri;
        $simpan->kondisi_siswa = ucfirst(strtolower($request->knsiswa));
        $simpan->kondisi_industri = ucfirst(strtolower($request->knindu));
        $simpan->keluhan_siswa = ucfirst(strtolower($request->khnsiswa));
        $simpan->keluhan_industri = ucfirst(strtolower($request->khnindu));
        $simpan->kinerja_siswa = ucfirst(strtolower($request->kinsiswa));
        $save = $simpan->save();

        if ($save) {
            Session::flash('success', 'Berhasil! Mengisi laporan kunjunga');
            return redirect('/kunjungan');
        }
        Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function show(Visit $visit)
    {
        if (Auth::user()->is_admin == 1 or Auth::user()->is_guru == 1) {
            $indu = Industrie::where('id', $visit->id_industri)->first();
            return view('multi.detailkunjungan', compact('visit', 'indu'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function edit(Visit $visit)
    {
        if (Auth::user()->is_guru) {
            $indu = Industrie::where('id', $visit->id_industri)->first();
            $industri = Industrie::select('*')->orderby('nama', 'asc')->get();
            return view('guru.editkunjungan', compact('visit', 'industri', 'indu'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visit $visit)
    {
        $rules = [
            'industri' => 'required',
            'knsiswa' => 'required',
            'knindu' => 'required',
            'khnsiswa' => 'nullable',
            'khnindu' => 'nullable',
            'kinsiswa' => 'nullable',
        ];

        $messages = [
            'industri.required'    => 'Industi wajib diisi',
            'knsiswa.required'    => 'Kondisi Siswa wajib diisi',
            'knindu.required'    => 'Kondisi Industri wajib diisi',
            'kinsiswa.required'    => 'Kinerja Siswa wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $ni = Teacher::select('n_induk')->where('id_user', Auth::user()->id);

        $simpan = Visit::where('');
        $simpan->n_induk = $ni;
        $simpan->id_industri = strtolower($request->industri);
        $simpan->kondisi_siswa = ucfirst(strtolower($request->knsiswa));
        $simpan->kondisi_industri = ucfirst(strtolower($request->knindu));
        $simpan->keluhan_siswa = ucfirst(strtolower($request->khnsiswa));
        $simpan->keluhan_industri = ucfirst(strtolower($request->khnindu));
        $simpan->kinerja_siswa = ucfirst(strtolower($request->kinsiswa));
        $save = $simpan->save();

        if ($save) {
            Session::flash('success', 'Berhasil! Mengisi laporan kunjunga');
            return redirect('/kunjungan');
        }
        Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visit $visit)
    {
        //
    }
}
