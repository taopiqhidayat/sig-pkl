<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Industrie;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\School;
use App\Models\Placement;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Session;
use PDF;

class SubmissionsController extends Controller
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
        $ajuan = DB::table('submissions')
            ->join('industries', 'submissions.id_industri', '=', 'industries.id')
            ->select('industries.nama', 'industries.alamat', 'industries.id')
            ->orderBy('industries.id')
            ->get();
        return view('admin.pengajuansiswa', compact('ajuan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($idi)
    {
        if (Auth::user()->is_siswa == 1) {
            $siswa = Student::where('id_user', Auth::user()->id)->first();
            $industri = Industrie::where('id', $idi)->first();
            $sch = School::where('id', 1)->first();
            return view('siswa.mengajukan', compact('siswa', 'industri', 'sch'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    public function print($idi)
    {
        $industri = Industrie::where('id', $idi)->first();
        $ajuan = Submission::where('id_industri', $idi)->first();
        $diterima = Submission::where('id_industri', $idi)->where('diterima', 1)->count();
        $siswa = DB::table('submissions')
            ->join('students', 'submissions.nis', '=', 'students.nis')
            ->select('students.nama', 'students.jurusan', 'students.kelas')
            ->where('id_industri', $idi)
            ->get();
        $siswaterima = DB::table('submissions')
            ->join('students', 'submissions.nis', '=', 'students.nis')
            ->select('students.nama', 'students.jurusan', 'students.kelas')
            ->where('id_industri', $idi)
            ->where('diterima', 1)
            ->get();
        $sch = School::where('id', 1)->first();

        $path = base_path('public/images/jabar.png');
        $tyve = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $gambar = 'data:image/' . $tyve . ';base64,' . base64_encode($data);

        $pdf = PDF::setOptions(['defaultFont' => 'times-new-roman', 'isHtml5ParseEnabled' => true, 'isRemoteEnabled' => true])->loadview('siswa.ajuanprint', compact('siswa', 'industri', 'sch', 'ajuan', 'diterima', 'siswaterima', 'gambar'));
        return $pdf->setPaper('a4')->stream();
        // return $pdf->download('laporan-pegawai-pdf');
        // return view('siswa.ajuanprint', compact('siswa', 'industri', 'sch', 'ajuan', 'diterima', 'siswaterima', 'gambar'));
    }

    public function print_balasan($idi)
    {
        $industri = Industrie::where('id', $idi)->first();
        $ajuan = Submission::where('id_industri', $idi)->first();
        $diterima = Submission::where('id_industri', $idi)->where('diterima', 1)->count();
        $siswa = DB::table('submissions')
            ->join('students', 'submissions.nis', '=', 'students.nis')
            ->select('students.nama', 'students.jurusan', 'students.kelas')
            ->where('id_industri', $idi)
            ->get();
        $siswaterima = DB::table('submissions')
            ->join('students', 'submissions.nis', '=', 'students.nis')
            ->select('students.nama', 'students.jurusan', 'students.kelas', 'submissions.*')
            ->where('id_industri', $idi)
            ->get();
        $sch = School::where('id', 1)->first();
        $pdf = PDF::setOptions(['defaultFont' => 'times-new-roman', 'isHtml5ParseEnabled' => true, 'isRemoteEnabled' => true])->loadview('siswa.balasanprint', compact('siswa', 'industri', 'sch', 'ajuan', 'diterima', 'siswaterima'));
        return $pdf->setPaper('a4')->stream();
        // return $pdf->download('laporan-pegawai-pdf');
        // return view('siswa.ajuanprint', compact('siswa', 'industri', 'sch', 'ajuan', 'diterima', 'siswaterima'));
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
            'nis'       => 'required|size:10',
            'idi'       => 'required',
            'mulai'     => 'required|date',
            'sampai'    => 'required|date',
        ];

        $messages = [
            'nis.required'           => 'Nomor Induk Siswa wajib diisi',
            'nis.size'                => 'Nomor Induk harus 10 karakter',
            'idi.required'         => 'ID wajib diisi',
            'mulai.required'           => 'Tanggal awal wajib diisi',
            'mulai.date'           => 'Harus berupa tanggal',
            'sampai.required'      => 'Tanggal akhir wajib diisi',
            'sampai.date'      => 'Harus berupa tanggal',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $simpan = new Submission;
        $simpan->nis = strtolower($request->nis);
        $simpan->id_industri = strtolower($request->idi);
        $simpan->mulai = $request->mulai;
        $simpan->sampai = $request->sampai;
        $save = $simpan->save();

        if ($save) {
            Session::flash('success', 'Pengajuan PKL berhasil');
            return redirect()->route('plh_industri');
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function show(Submission $submission)
    {
        //
    }

    public function detail_pengajuan($id)
    {
        $industri = Industrie::where('id', $id)->first();
        $siswa = DB::table('submissions')
            ->join('students', 'submissions.nis', '=', 'students.nis')
            ->select('students.*', 'submissions.*')
            ->where('id_industri', $id)
            ->get();
        return view('admin.detailpengajuan', compact('industri', 'siswa'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pengajuan()
    {
        if (Auth::user()->is_industri == 1) {
            $idi = Industrie::where('id_user', Auth::user()->id)->first();
            $data = Submission::where('id_industri', $idi->id)->count();
            $aju = DB::table('submissions')
                ->join('students', 'submissions.nis', '=', 'students.nis')
                ->select('students.*', 'submissions.*')
                ->where('submissions.id_industri', $idi->id)
                ->get();
            return view('industri.pengajuan', compact('aju', 'data', 'idi'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    public function terima_pengajuan(Request $request)
    {
        $rules = [
            'masuk'       => 'required',
            'keluar'       => 'required',
        ];

        $messages = [
            'masuk.required'           => 'Jam masuk wajib diisi',
            'keluar.required'      => 'Jam keluar wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $simpan1 = Submission::where('id', $request->id)
            ->update([
                'waktu_masuk' => $request->masuk,
                'waktu_keluar' => $request->keluar,
                'diterima' => 1,
            ]);


        if ($simpan1) {
            $sch = School::where('id', 1)->first();
            $idi = Industrie::where('id_user', Auth::user()->id)->first();
            $gururand = Teacher::orderByRaw('RAND()')->take(1)->first();

            $simpan2 = new Placement;
            $simpan2->nis = $request->nis;
            $simpan2->n_induk = $gururand->n_induk;
            $simpan2->id_industri = $idi->id;
            $simpan2->mulai = $sch->pkl_mulai;
            $simpan2->sampai = $sch->pkl_sampai;
            $simpan2->waktu_masuk = $request->masuk;
            $simpan2->waktu_keluar = $request->keluar;
            $save = $simpan2->save();
            if ($save) {
                $bimbing = Placement::where('nis', $request->nis)->first();
                $gururand2 = Teacher::orderByRaw('RAND()')->take(1)->first();
                $simpan3 = new Test;
                $simpan3->nis = $request->nis;
                $simpan3->pembimbing = $bimbing->n_induk;
                $simpan3->penguji = $gururand2->n_induk;
                $save2 = $simpan3->save();
                if ($save2) {
                    Session::flash('success', 'Penerimaan PKL berhasil');
                    return redirect('/pengajuan/');
                }
                Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
                return redirect()->back();
            }
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    public function tolak_pengajuan(Request $request)
    {
        $simpan = Submission::where('id', $request->id)
            ->update([
                'diterima' => 0,
            ]);

        if ($simpan) {
            Session::flash('success', 'Penolakan PKL berhasil');
            return redirect('/pengajuan');
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function edit(Submission $submission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Submission $submission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Submission $submission)
    {
        //
    }
}
