<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Industrie;
use App\Models\Student;
use App\Models\School;
use App\Models\Placement;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Session;
use Carbon;
use Carbon\Carbon as CarbonCarbon;
use DateTime;
use Prophecy\Call\Call;
use Whoops\Run;

class CalendarsController extends Controller
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
        $id = Industrie::where('id_user', $request->idi)->first();
        $sim = new Calendar;
        $sim->tanggal = $request->tang;
        $sim->masuk = $request->masuk;
        $sim->id_industri = $id->id;
        $save = $sim->save();

        if ($save) {
            Session::flash('success', 'Penentuan jadwal berhasil');
            return redirect('/absensi');
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function show(Calendar $calendar)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function absensi()
    {
        if (Auth::user()->is_industri == 1) {
            $idi = Industrie::where('id_user', Auth::user()->id)->first();
            $data = Calendar::where('id_industri', $idi->id)->count();
            $jadw = Calendar::where('id_industri', $idi->id)->orderBy('tanggal')->get();
            $aw = School::where('id', 1)->first();
            $akh = School::where('id', 1)->first();
            $ty = date('Y', strtotime($aw->pkl_mulai));
            $tm = date('m', strtotime($aw->pkl_mulai));
            $td = date('d', strtotime($aw->pkl_mulai));
            $t1 = CarbonCarbon::createFromDate($ty, $tm, $td);
            $t2 = CarbonCarbon::createFromDate($ty, $tm, $td);
            $t3 = CarbonCarbon::createFromDate($ty, $tm, $td);
            $h = CarbonCarbon::createFromDate($ty, $tm, $td);
            $t1 = $t1->subDay();
            $t2 = $t2->subDay();
            $t3 = $t3->subDay();
            $h = $h->subDay();
            $mt = date('Y', strtotime($aw->pkl_mulai));
            $st = date('Y', strtotime($akh->pkl_sampai));
            $b1 = date('m', strtotime($aw->pkl_mulai));
            $b2 = date('m', strtotime($akh->pkl_sampai));
            $jhk1 = cal_days_in_month(CAL_GREGORIAN, $b1, $mt);
            $jhk2 = cal_days_in_month(CAL_GREGORIAN, $b2, $st);
            $jhk = $jhk1 + $jhk2;
            $tang = array();
            $hari = array();
            return view('multi.absensi', compact('jadw', 'data', 'jhk', 'tang', 'hari', 't1', 't2', 't3', 'h'));
        } elseif (Auth::user()->is_siswa == 1) {
            $siswa = Student::where('id_user', Auth::user()->id)->first();
            $indu = Placement::where('nis', $siswa->nis)->first();
            if ($indu == null) {
                return view('multi.absensi', compact('indu'));
            } else {
                $absen = Calendar::where('id_industri', $indu->id_industri)->where('masuk', 1)->orderBy('tanggal', 'asc')->get();
                $data = Calendar::where('id_industri', $indu->id_industri)->where('masuk', 1)->count();
                return view('multi.absensi', compact('indu', 'absen', 'data'));
            }
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    public function cekHadir($id, $idk)
    {
        $siswa = Student::where('id_user', $id)->first();
        $hadir = Presence::where('nis', $siswa->nis)->where('id_kalender', $idk)->first();
        if ($hadir == null) {
            return 0;
        } elseif ($hadir->hadir == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public function kehadiran($id)
    {
        $idi = Industrie::where('id_user', Auth::user()->id)->first();
        $jadw = Calendar::where('id', $id)->first();
        $kehadiran = Presence::where('id_kalender', $id)->get();
        $siswa = DB::table('placements')
            ->join('students', 'placements.nis', '=', 'students.nis')
            ->select('students.nis', 'students.nama', 'students.jurusan', 'students.kelas', 'placements.*')
            ->where('id_industri', $idi->id)
            ->get();
        return view('multi.kehadiran', compact('jadw', 'kehadiran', 'siswa'));
    }

    public function cekKehadiran($id, $nis)
    {
        $kehadiran = Presence::where('id_kalender', $id)->where('nis', $nis)->first();
        if ($kehadiran == null) {
            return 0;
        } elseif ($kehadiran->hadir == 1) {
            return 1;
        } else {
            return 0;
        }
    }
    public function cekFiKeh($id, $nis)
    {
        $kehadiran = Presence::where('id_kalender', $id)->where('nis', $nis)->first();
        if ($kehadiran == null) {
            return null;
        } elseif ($kehadiran->hadir == 1) {
            return $kehadiran->file;
        } else {
            return null;
        }
    }
    public function cekIdh($id, $nis)
    {
        $kehadiran = Presence::where('id_kalender', $id)->where('nis', $nis)->first();
        if ($kehadiran == null) {
            return null;
        } elseif ($kehadiran->hadir == 1) {
            return $kehadiran->id;
        } else {
            return $kehadiran->id;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calendar $calendar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calendar $calendar)
    {
        //
    }
}
