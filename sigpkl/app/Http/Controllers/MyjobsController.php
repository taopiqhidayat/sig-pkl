<?php

namespace App\Http\Controllers;

use App\Models\Myjob;
use App\Models\Task;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Session;
// use PDF;

class MyjobsController extends Controller
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
    public function serahkan(Request $request)
    {
        $rules = [
            'file'          => 'required|file|max:30720',
        ];

        $messages = [
            'file.file'        => 'Harus berupa file',
            'file.max'         => 'Maksismal 30 mb',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $nis = Student::where('id_user', $request->ids)->first();

        if ($request->hasFile('file')) {
            # ada file
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('file')->getClientOriginalExtension();
            $filenameSimpan = 'haskerja' . $nis->nis . '_' . $filename . '_' . time() . '.' . $extention;

            $path = $request->file('file')->storeAs('haskerja', $filenameSimpan);
            $cek = Myjob::where('id_tugas', $request->idt)->where('nis', $nis->nis)->first();

            if ($cek != null) {
                $save = Myjob::where('id_tugas', $request->idt)->where('nis', $nis->nis)
                    ->update([
                        'nis' => $nis->nis,
                        'id_tugas' => $request->idt,
                        'file' => $filenameSimpan,
                    ]);
            } else {
                $sim = new Myjob;
                $sim->nis = $nis->nis;
                $sim->id_tugas = $request->idt;
                $sim->file = $filenameSimpan;
                $save = $sim->save();
            }

            if ($save) {
                Session::flash('success', 'Tugas berhasil dibuat');
                return redirect('/tugas_siswa');
            }
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        } else {
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Myjob  $myjob
     * @return \Illuminate\Http\Response
     */
    public function show(Myjob $myjob)
    {
        //
    }

    public function hasil_kerja($id)
    {
        if (Auth::user()->is_admin == 1) {
            $tugas_sch = Task::where('oleh', Auth::user()->id)->where('id', $id)->orderby('created_at', 'desc')->first();
            $haskersis = DB::table('myjobs')
                ->join('students', 'myjobs.nis', '=', 'students.nis')
                ->select('students.nama', 'students.kelas', 'students.jurusan', 'myjobs.id as id', 'myjobs.id_tugas', 'myjobs.file', 'myjobs.nilai', 'myjobs.nis', 'myjobs.updated_at')
                ->where('myjobs.id_tugas', $tugas_sch->id)
                ->get();
            $data = Myjob::where('id_tugas', $tugas_sch->id)->get()->count();
            return view('multi.hasilkerja', compact('tugas_sch', 'haskersis', 'data'));
        } elseif (Auth::user()->is_industri == 1) {
            $tugas = Task::where('oleh', Auth::user()->id)->where('id', $id)->orderby('created_at', 'desc')->first();
            $haskersis = DB::table('myjobs')
                ->join('students', 'myjobs.nis', '=', 'students.nis')
                ->select('students.nama', 'students.kelas', 'students.jurusan', 'myjobs.id as id', 'myjobs.id_tugas', 'myjobs.file', 'myjobs.nilai', 'myjobs.nis', 'myjobs.updated_at')
                ->where('myjobs.id_tugas', $tugas->id)
                ->get();
            $data = Myjob::where('id_tugas', $tugas->id)->get()->count();
            return view('multi.hasilkerja', compact('tugas', 'haskersis', 'data'));
        }
    }

    public function file_tugas(Myjob $myjob)
    {
        // $pdf = PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif'])->loadview(asset('/storage/haskerja/' . $myjob->file));
        // return $pdf->setPaper('a4')->stream();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Myjob  $myjob
     * @return \Illuminate\Http\Response
     */
    public function edit(Myjob $myjob)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Myjob  $myjob
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Myjob $myjob)
    {
        $rules = [
            'nilai'          => 'required|numeric|min:10|max:100',
        ];

        $messages = [
            'nilai.required'    => 'Nilai wajib diisi',
            'nilai.min'         => 'Penilaian dimulai dari 10 - 100',
            'nilai.max'         => 'Penilaian dimulai dari 10 - 100',
            'nilai.numeric'     => 'Harus berupa angka bilangan bulat',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $save = Myjob::where('id_tugas', $request->idt && 'nis', $request->nis)->orwhere('id', $request->idhks)
            ->update([
                'nilai' => $request->nilai,
            ]);

        if ($save) {
            Session::flash('success', 'Tugas berhasil diberi nilai');
            return redirect('/hasil_kerja/' . $request->idt);
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Myjob  $myjob
     * @return \Illuminate\Http\Response
     */
    public function destroy(Myjob $myjob)
    {
        //
    }
}
