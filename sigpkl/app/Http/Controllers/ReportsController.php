<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Placement;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Session;

class ReportsController extends Controller
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
        $rules = [
            'judul' => 'required',
            'filap' => 'required|file|max:50120',
        ];

        $messages = [
            'judul.required'    => 'Judul wajib diisi',
            'filap.required'    => 'File wajib diisi',
            'filap.file'        => 'Harus berupa file',
            'filap.max'        => 'File maximal 50 Mb',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $nis = Student::where('id_user', Auth::user()->id)->first();

        if ($request->hasFile('filap')) {
            # ada file
            $filenameWithExt = $request->file('filap')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('filap')->getClientOriginalExtension();
            $filenameSimpan = 'laporan' . $nis->nis . '_' . $filename . '_' . time() . '.' . $extention;
            $path = $request->file('filap')->storeAs('laporan', $filenameSimpan);

            $simpan = new Report;
            $simpan->nis = strtolower($nis->nis);
            $simpan->judul = ucwords(strtolower($request->judul));
            $simpan->laporan = $filenameSimpan;
            $save = $simpan->save();

            if ($save) {
                Session::flash('success', 'Mengupload laporan berhasil');
                return redirect('/laporan');
            }
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        } else {
            // tidak ada file
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function laporan()
    {
        if (Auth::user()->is_guru == 1) {
            $ni = Teacher::where('id_user', Auth::user()->id)->first();
            $siswa = Placement::where('n_induk', $ni->n_induk)->get();
            $laporan = Report::all();
            $data = 0;
            foreach ($laporan as $l) {
                foreach ($siswa as $s) {
                    if ($l->nis == $s->nis) {
                        $data = $data + 1;
                    }
                }
            }
            return view('multi.laporan', compact('laporan', 'siswa', 'data'));
        } elseif (Auth::user()->is_siswa == 1) {
            $nis = Student::where('id_user', Auth::user()->id)->first();
            $laporan = Report::where('nis', $nis->nis)->first();
            $data = Report::where('nis', $nis->nis)->count();
            return view('multi.laporan', compact('laporan', 'data'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    public function getNama($nis)
    {
        $siswa = Student::where('nis', $nis)->first();
        $nama = $siswa->nama;
        return $nama;
    }

    public function getkelas($nis)
    {
        $siswa = Student::where('nis', $nis)->first();
        $nama = $siswa->kelas;
        return $nama;
    }

    public function respon_laporan(Request $request)
    {
        $rules = [
            'kritik' => 'required|min:16|max:255',
        ];

        $messages = [
            'kritik.required'    => 'Tanggapan wajib diisi',
            'kritik.min'        => 'File minimal 16 karakter',
            'kritik.max'        => 'File maximal 255 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $simpan = Report::where('nis', $request->nis)
            ->update([
                'respon' => ucwords(strtolower($request->kritik)),
            ]);

        if ($simpan) {
            Session::flash('success', 'Berhasil! Mengupload laporan berhasil');
            return redirect('/laporan');
        }
        Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        return view('multi.editlaporan', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'judul' => 'required',
            'filap' => 'required|file|max:50120',
        ];

        $messages = [
            'judul.required'    => 'Judul wajib diisi',
            'filap.required'    => 'File wajib diisi',
            'filap.file'        => 'Harus berupa file',
            'filap.max'        => 'File maximal 50 Mb',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $nis = Student::where('id_user', Auth::user()->id)->first();

        if ($request->hasFile('filap')) {
            # ada file
            $filenameWithExt = $request->file('filap')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('filap')->getClientOriginalExtension();
            $filenameSimpan = 'laporan' . $nis->nis . '_' . $filename . '_' . time() . '.' . $extention;
            $path = $request->file('filap')->storeAs('laporan', $filenameSimpan);

            $simpan = Report::where('id', $request->idr)
                ->update([
                    'nis' => strtolower($nis->nis),
                    'judul' => ucwords(strtolower($request->judul)),
                    'laporan' => $filenameSimpan,
                ]);

            if ($simpan) {
                Session::flash('success', 'Berhasil! Mengupload laporan berhasil');
                return redirect('/laporan');
            }
            Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        } else {
            // tidak ada file
            Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function lihat_laporan(Report $report)
    {
        return '<embed type="application/pdf" src="/storage/laporan/' . $report->laporan . '" width="100%" height="100%"></embed>';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
