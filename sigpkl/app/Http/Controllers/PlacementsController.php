<?php

namespace App\Http\Controllers;

use App\Models\Placement;
use App\Models\Industrie;
use App\Models\Teacher;
use App\Models\Test;
use App\Models\Student;
use App\Models\School;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;

class PlacementsController extends Controller
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
    public function index(Request $request)
    {
        if (Auth::user()->is_admin == 1) {
            $penempatan = DB::table('placements')
                ->join('students', 'placements.nis', '=', 'students.nis')
                ->join('teachers', 'placements.n_induk', '=', 'teachers.n_induk')
                ->join('industries', 'placements.id_industri', '=', 'industries.id')
                ->select('placements.*', 'students.nama as nama_siswa', 'students.jurusan', 'students.kelas', 'teachers.nama as nama_guru', 'industries.nama as nama_indu')
                ->orderBy('students.jurusan', 'asc')
                ->orderBy('students.kelas', 'asc')
                ->orderBy('students.nama', 'asc')
                ->where('students.nama', 'like', "%" . $request->keywrd . "%")
                ->orwhere('students.jurusan', 'like', "%" . $request->keywrd . "%")
                ->orwhere('students.kelas', 'like', "%" . $request->keywrd . "%")
                ->orwhere('teachers.nama', 'like', "%" . $request->keywrd . "%")
                ->orwhere('industries.nama', 'like', "%" . $request->keywrd . "%")
                ->paginate(25);
            $cari = DB::table('placements')
                ->join('students', 'placements.nis', '=', 'students.nis')
                ->join('teachers', 'placements.n_induk', '=', 'teachers.n_induk')
                ->join('industries', 'placements.id_industri', '=', 'industries.id')
                ->select('placements.*', 'students.nama as nama_siswa', 'students.jurusan', 'students.kelas', 'teachers.nama as nama_guru', 'industries.nama as nama_indu')
                ->orderBy('students.jurusan', 'asc')
                ->orderBy('students.kelas', 'asc')
                ->orderBy('students.nama', 'asc')
                ->where('students.nama', 'like', "%" . $request->keywrd . "%")
                ->orwhere('students.jurusan', 'like', "%" . $request->keywrd . "%")
                ->orwhere('students.kelas', 'like', "%" . $request->keywrd . "%")
                ->orwhere('teachers.nama', 'like', "%" . $request->keywrd . "%")
                ->orwhere('industries.nama', 'like', "%" . $request->keywrd . "%")
                ->count();
            $data = Placement::select('*')->count();
            return view('admin.datapenempatan', compact('penempatan', 'data', 'cari'));
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
        if (Auth::user()->is_admin == 1) {
            $siswa = Student::select('*')->orderby('kelas', 'asc')->orderby('nama', 'asc')->get();
            $guru = Teacher::select('*')->orderby('jurusan', 'asc')->orderby('nama', 'asc')->get();
            $industri = Industrie::select('*')->orderby('nama', 'asc')->get();
            $sch = School::where('id', 1)->first();
            return view('admin.tambahpenempatan', compact('siswa', 'guru', 'industri', 'sch'));
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
            'siswa'     => 'required',
            'guru'      => 'required',
            'industri'  => 'required',
            'mulai'     => 'required|date',
            'sampai'    => 'required|date',
        ];

        $messages = [
            'siswa.required'    => 'Siswa wajib diisi',
            'guru.required'     => 'Guru wajib diisi',
            'industri.required' => 'Industri wajib diisi',
            'mulai.required'    => 'Tanggal Mulai PKL wajib diisi',
            'mulai.date'        => 'Data harus berupa tanggal',
            'sampai.required'   => 'Tanggal Akhir PKL wajib diisi',
            'sampai.date'       => 'Data harus berupa tanggal',
            'masuk.required'    => 'Email wajib diisi',
            'keluar.required'   => 'Nomor HP wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $save = new Placement;
        $save->nis =  strtolower($request->siswa);
        $save->n_induk =  strtolower($request->guru);
        $save->id_industri =  strtolower($request->industri);
        $save->mulai =  $request->mulai;
        $save->sampai =  $request->sampai;
        $save->waktu_masuk =  $request->masuk;
        $save->waktu_keluar =  $request->keluar;
        $tempat = $save->save();

        if ($tempat) {
            $bimbing = Placement::where('nis', $request->siswa)->first();
            $gururand2 = Teacher::orderByRaw('RAND()')->take(1)->first();
            $simpan3 = new Test;
            $simpan3->nis = $request->siswa;
            $simpan3->pembimbing = $bimbing->n_induk;
            $simpan3->penguji = $gururand2->n_induk;
            $save2 = $simpan3->save();
            if ($save2) {
                Session::flash('success', 'Berhasil! Penempatan siswa sudah dilakukan');
                return redirect()->route('kd_penempatan');
            }
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
        Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Placement  $placement
     * @return \Illuminate\Http\Response
     */
    public function show(Placement $placement)
    {
        if (Auth::user()->is_admin == 1) {
            $penempatan = DB::table('placements')
                ->join('students', 'placements.nis', '=', 'students.nis')
                ->join('teachers', 'placements.n_induk', '=', 'teachers.n_induk')
                ->join('industries', 'placements.id_industri', '=', 'industries.id')
                ->select('placements.*', 'students.nama as nama_siswa', 'students.jurusan', 'students.kelas', 'teachers.nama as nama_guru', 'industries.nama as nama_indu')
                ->where('placements.id', $placement->id)
                ->orderBy('students.jurusan', 'asc')
                ->orderBy('students.kelas', 'asc')
                ->orderBy('students.nama', 'asc')
                ->get();
            return view('admin.detailpenempatan', compact('placement', 'penempatan'));
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
    public function data_siswa(Request $request)
    {
        if (Auth::user()->is_guru == 1) {
            $ni = Teacher::where('id_user', Auth::user()->id)->first();
            $data = DB::table('placements')
                ->join('students', 'placements.nis', '=', 'students.nis')
                ->join('industries', 'placements.id_industri', '=', 'industries.id')
                ->select('students.nama as nama_siswa', 'students.jurusan', 'students.kelas', 'industries.nama as nama_indu', 'industries.n_wa', 'industries.latitude', 'industries.longitude', 'industries.alamat')
                ->where('placements.n_induk', $ni->n_induk)
                ->where('students.nama', 'like', "%" . $request->keywrd . "%")
                ->where('students.jurusan', 'like', "%" . $request->keywrd . "%")
                ->where('students.kelas', 'like', "%" . $request->keywrd . "%")
                ->where('industries.nama', 'like', "%" . $request->keywrd . "%")
                ->count();
            $ind = Placement::where('n_induk', $ni->n_induk)->get();
            foreach ($ind as $in) {
                $industri[] = app('App\Http\Controllers\PlacementsController')->getInd($in->id_industri);
                $siswa[] = app('App\Http\Controllers\PlacementsController')->getSiswas($in->id_industri);
            }
            $json1 = json_encode(array('results1' => $industri));
            $json2 = json_encode(array('results2' => $siswa));
            $sistem = DB::table('placements')
                ->join('students', 'placements.nis', '=', 'students.nis')
                ->join('industries', 'placements.id_industri', '=', 'industries.id')
                ->select('students.nama as nama_siswa', 'students.jurusan', 'students.kelas', 'industries.nama as nama_indu', 'industries.n_wa', 'industries.latitude', 'industries.longitude', 'industries.alamat')
                ->where('placements.n_induk', $ni->n_induk)
                ->where('students.nama', 'like', "%" . $request->keywrd . "%")
                ->where('students.jurusan', 'like', "%" . $request->keywrd . "%")
                ->where('students.kelas', 'like', "%" . $request->keywrd . "%")
                ->where('industries.nama', 'like', "%" . $request->keywrd . "%")
                ->paginate(10);
            return view('multi.datasiswa', compact('data', 'sistem', 'siswa', 'industri', 'json1', 'json2'));
        } elseif (Auth::user()->is_industri == 1) {
            $idi = Industrie::where('id_user', Auth::user()->id)->first();
            $data = DB::table('placements')
                ->join('students', 'placements.nis', '=', 'students.nis')
                ->join('teachers', 'placements.n_induk', '=', 'teachers.n_induk')
                ->select('students.nama as nama_siswa', 'students.jurusan', 'students.kelas', 'teachers.nama as nama_guru', 'teachers.n_wa')
                ->where('placements.id_industri', $idi->id)
                ->where('students.nama', 'like', "%" . $request->keywrd . "%")
                ->where('students.jurusan', 'like', "%" . $request->keywrd . "%")
                ->where('students.kelas', 'like', "%" . $request->keywrd . "%")
                ->count();
            $siswa = DB::table('placements')
                ->join('students', 'placements.nis', '=', 'students.nis')
                ->join('teachers', 'placements.n_induk', '=', 'teachers.n_induk')
                ->select('students.nama as nama_siswa', 'students.jurusan', 'students.kelas', 'teachers.nama as nama_guru', 'teachers.n_wa')
                ->where('placements.id_industri', $idi->id)
                ->where('students.nama', 'like', "%" . $request->keywrd . "%")
                ->where('students.jurusan', 'like', "%" . $request->keywrd . "%")
                ->where('students.kelas', 'like', "%" . $request->keywrd . "%")
                ->paginate(10);
            return view('multi.datasiswa', compact('data', 'siswa'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    public function getInd($idi)
    {
        $ind = Industrie::where('id', $idi)->first();
        return $ind;
    }

    public function getSiswas($idi)
    {
        $ss = Placement::where('id_industri', $idi)->get();
        foreach ($ss as $s) {
            $siswa[] = app('App\Http\Controllers\PlacementsController')->getSiswa($s->nis);;
        }
        return $siswa;
    }

    public function getSiswa($nis)
    {
        $siswa = Student::where('nis', $nis)->first();
        return $siswa;
    }

    public function penentuan_penguji(Request $request)
    {
        $data = DB::table('placements')
            ->join('students', 'placements.nis', '=', 'students.nis')
            ->join('teachers', 'placements.n_induk', '=', 'teachers.n_induk')
            ->select('placements.*', 'students.nama as nama_siswa', 'students.jurusan', 'students.kelas', 'teachers.nama as nama_guru')
            ->where('students.nama', 'like', "%" . $request->keywrd . "%")
            ->orwhere('students.jurusan', 'like', "%" . $request->keywrd . "%")
            ->orwhere('students.kelas', 'like', "%" . $request->keywrd . "%")
            ->orwhere('teachers.nama', 'like', "%" . $request->keywrd . "%")
            ->paginate(25);
        $jumdata = DB::table('placements')
            ->join('students', 'placements.nis', '=', 'students.nis')
            ->join('teachers', 'placements.n_induk', '=', 'teachers.n_induk')
            ->select('placements.*', 'students.nama as nama_siswa', 'students.jurusan', 'students.kelas', 'teachers.nama as nama_guru')
            ->where('students.nama', 'like', "%" . $request->keywrd . "%")
            ->orwhere('students.jurusan', 'like', "%" . $request->keywrd . "%")
            ->orwhere('students.kelas', 'like', "%" . $request->keywrd . "%")
            ->orwhere('teachers.nama', 'like', "%" . $request->keywrd . "%")
            ->count();
        $tes = DB::table('tests')
            ->join('teachers', 'tests.penguji', '=', 'teachers.n_induk')
            ->select('teachers.nama', 'tests.*')
            ->where('teachers.nama', 'like', "%" . $request->keywrd . "%")
            ->paginate(25);
        $jumtes = DB::table('tests')
            ->join('teachers', 'tests.penguji', '=', 'teachers.n_induk')
            ->select('teachers.nama', 'tests.*')
            ->where('teachers.nama', 'like', "%" . $request->keywrd . "%")
            ->count();
        return view('admin.penentuanpenguji', compact('data', 'tes', 'jumtes', 'jumdata'));
    }

    public function edit_penguji($nis)
    {
        $guru = Teacher::select('*')->orderBy('jurusan', 'asc')->orderBy('nama', 'asc')->get();
        $test = Test::where('tests.nis', $nis)->first();
        $uji = Teacher::where('n_induk', $test->penguji)->first();
        $bimbing = Teacher::where('n_induk', $test->pembimbing)->first();
        $siswa = Student::where('nis', $test->nis)->first();
        return view('admin.editpenguji', compact('guru', 'bimbing', 'uji', 'siswa', 'test'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function penilaian()
    {
        if (Auth::user()->is_industri == 1) {
            $idi = Industrie::where('id_user', Auth::user()->id)->first();
            $magang = DB::table('placements')
                ->join('students', 'placements.nis', '=', 'students.nis')
                ->select('students.nama', 'students.kelas', 'students.jurusan', 'students.id_user',  'placements.*')
                ->where('placements.id_industri', $idi->id)
                ->get();
            $data = Placement::where('id_industri', $idi->id)->count();
            $scre = Score::all();
            return view('multi.penilaian', compact('magang', 'data', 'scre'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Placement  $placement
     * @return \Illuminate\Http\Response
     */
    public function edit(Placement $placement)
    {
        if (Auth::user()->is_admin == 1) {
            $siswa = Student::where('nis', $placement->nis)->first();
            $guru = Teacher::select('*')->orderby('jurusan', 'asc')->orderby('nama', 'asc')->get();
            $awal_guru = Teacher::where('n_induk', $placement->n_induk)->first();
            $industri = Industrie::select('*')->orderby('nama', 'asc')->get();
            $awal_industri = Industrie::where('id', $placement->id_industri)->first();
            return view('admin.editpenempatan', compact('placement', 'siswa', 'guru', 'industri', 'awal_guru', 'awal_industri'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Placement  $placement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Placement $placement)
    {
        $rules = [
            'guru'      => 'required',
            'industri'  => 'required',
            'mulai'     => 'required|date',
            'sampai'    => 'required|date',
        ];

        $messages = [
            'guru.required'     => 'Guru wajib diisi',
            'industri.required' => 'Industri wajib diisi',
            'mulai.required'    => 'Tanggal Mulai PKL wajib diisi',
            'mulai.date'        => 'Data harus berupa tanggal',
            'sampai.required'   => 'Tanggal Akhir PKL wajib diisi',
            'sampai.date'       => 'Data harus berupa tanggal',
            'masuk.required'    => 'Email wajib diisi',
            'keluar.required'   => 'Nomor HP wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $save = Placement::where('id', $request->id)
            ->update([
                'n_induk' => $request->guru,
                'id_industri' => $request->industri,
                'mulai'     => $request->mulai,
                'sampai'    => $request->sampai,
                'waktu_masuk'     => $request->masuk,
                'waktu_keluar'    => $request->keluar,
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        if ($save) {
            Session::flash('success', 'Berhasil! Penempatan siswa sudah dilakukan');
            return redirect()->route('kd_penempatan');
        }
        Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }
}
