<?php

namespace App\Http\Controllers;

use App\Models\Enigma;
use App\Models\Task;
use App\Models\Quiz;
use App\Models\Placement;
use App\Models\Industrie;
use App\Models\Student;
use App\Models\Major;
use App\Models\Myjob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use DB;

class TasksController extends Controller
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
        if (Auth::user()->is_admin == 1) {
            $jurusan = Major::all();
            $siswa = Student::select('*')->orderBy('kelas', 'asc')->orderBy('nama', 'asc')->get();
            return view('multi.buattugas', compact('jurusan', 'siswa'));
        } elseif (Auth::user()->is_industri == 1) {
            $indu = Industrie::where('id_user', Auth::user()->id)->first();
            $tem = Placement::where('id_industri', $indu->id)->get();
            $siswa = Student::all();
            return view('multi.buattugas', compact('siswa', 'tem'));
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
            'judul'         => 'required|min:4|max:100',
            'keterangan'    => 'required|min:16',
            'file'          => 'nullable|file|max:10000',
            'jurusan'       => 'nullable',
            'tangakhir'     => 'required|date',
            'wakakhir'      => 'required',
        ];

        $messages = [
            'judul.required'        => 'Judul wajib diisi',
            'judul.min'             => 'Judul mijudulmal 4 karakter',
            'judul.max'             => 'Judul maksimal 100 karakter',
            'keterangan.required'   => 'Keterangan wajib diisi',
            'keterangan.min'        => 'Keterangan minimal 16 karakter',
            'tangakhir.required'    => 'Alamat wajib diisi',
            'tangakhir.date'        => 'Harus berupa tanggal',
            'wakakhir.required'     => 'Kota wajib diisi',
            'file.file'        => 'Harus berupa file',
            'file.max'         => 'Maksismal 10 mb',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        if ($request->hasFile('file')) {
            # ada file
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('file')->getClientOriginalExtension();
            $filenameSimpan = 'tugas' . Auth::user()->id . '_' . $filename . '_' . time() . '.' . $extention;

            $path = $request->file('file')->storeAs('tugas', $filenameSimpan);

            $tugas = new Task;
            $tugas->judul = ucwords(strtolower($request->judul));
            $tugas->keterangan = ucfirst(strtolower($request->keterangan));
            $tugas->file = $filenameSimpan;
            $tugas->oleh = strtolower($request->id);
            $tugas->jurusan = ucwords(strtolower($request->jurusan));
            $tugas->tangakhir = $request->tangakhir;
            $tugas->wakakhir = $request->wakakhir;
            $save = $tugas->save();

            if ($save) {
                Session::flash('success', 'Berhasil! Tugas berhasil dibuat');
                return redirect('/tugas_siswa');
            }
            Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        } else {
            // tidak ada 

            $tugas = new Task;
            $tugas->judul = ucwords(strtolower($request->judul));
            $tugas->keterangan = ucfirst(strtolower($request->keterangan));
            $tugas->oleh = strtolower($request->id);
            $tugas->jurusan = ucwords(strtolower($request->jurusan));
            $tugas->tangakhir = $request->tangakhir;
            $tugas->wakakhir = $request->wakakhir;
            $save = $tugas->save();

            if ($save) {
                Session::flash('success', 'Berhasil! Tugas berhasil dibuat');
                return redirect('/tugas_siswa');
            }
            Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tugas_siswa()
    {
        if (Auth::user()->is_admin == 1) {
            $tugas = Task::where('oleh', Auth::user()->id)->orderby('created_at', 'desc')->get();
            $jumtug = Task::where('oleh', Auth::user()->id)->count();
            $kuis = Quiz::where('oleh', Auth::user()->id)->orderby('created_at', 'desc')->get();
            $jumkuis = Quiz::where('oleh', Auth::user()->id)->count();
            return view('multi.tugas', compact('tugas', 'jumtug', 'kuis', 'jumkuis'));
        } elseif (Auth::user()->is_industri == 1) {
            $tugas = Task::where('oleh', Auth::user()->id)->orderby('created_at', 'desc')->get();
            $jumtug = Task::where('oleh', Auth::user()->id)->count();
            return view('multi.tugas', compact('tugas', 'jumtug'));
        } elseif (Auth::user()->is_siswa == 1) {
            $siswa = Student::where('id_user', Auth::user()->id)->first();
            $idi = Placement::where('nis', $siswa->nis)->first();
            $tugas_sch = Task::where('jurusan', $siswa->jurusan)->orderby('created_at', 'desc')->get();
            $jumtug_sch = Task::where('jurusan', $siswa->jurusan)->count();
            $kuis = Quiz::where('jurusan', $siswa->jurusan)->orWhere('untuk', $siswa->nis)->orderBy('created_at', 'desc')->get();
            $jumkuis = Quiz::where('jurusan', $siswa->jurusan)->orWhere('untuk', $siswa->nis)->count();
            if ($idi == null) {
                return view('multi.tugas', compact('idi', 'tugas_sch', 'kuis', 'jumkuis'));
            } else {
                $indu = Industrie::where('id', $idi->id_industri)->first();
                $tugas = Task::where('oleh', $indu->id_user)->orWhere('untuk', $siswa->nis)->orderby('created_at', 'desc')->get();
                $jumtug = Task::where('oleh', $indu->id_user)->count();
                $mytugas = Myjob::where('nis', $siswa->nis)->get();
                return view('multi.tugas', compact('idi', 'tugas', 'jumtug', 'mytugas', 'tugas_sch', 'kuis', 'jumkuis', 'jumtug_sch'));
            }
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    public function getUntuk($nis)
    {
        $siswa = Student::where('nis', $nis)->first();
        return $siswa;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $jurusan = Major::all();
        return view('multi.edittugas', compact('task', 'jurusan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $rules = [
            'judul'         => 'required|min:4|max:100',
            'keterangan'    => 'required|min:16',
            'file'          => 'nullable|file|max:10000',
            'jurusan'       => 'nullable',
            'tangakhir'     => 'required|date',
            'wakakhir'      => 'required',
        ];

        $messages = [
            'judul.required'        => 'Judul wajib diisi',
            'judul.min'             => 'Judul mijudulmal 4 karakter',
            'judul.max'             => 'Judul maksimal 100 karakter',
            'keterangan.required'   => 'Keterangan wajib diisi',
            'keterangan.min'        => 'Keterangan minimal 16 karakter',
            'tangakhir.required'    => 'Alamat wajib diisi',
            'tangakhir.date'        => 'Harus berupa tanggal',
            'wakakhir.required'     => 'Kota wajib diisi',
            'file.file'        => 'Harus berupa file',
            'file.max'         => 'Maksismal 10 mb',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        if ($request->hasFile('file')) {
            # ada file
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('file')->getClientOriginalExtension();
            $filenameSimpan = 'tugas' . Auth::user()->id . '_' . $filename . '_' . time() . '.' . $extention;

            $path = $request->file('file')->storeAs('tugas', $filenameSimpan);

            $save = Task::where('id', $request->idt)
                ->update([
                    'judul'         => ucwords(strtolower($request->judul)),
                    'keterangan'    => ucfirst(strtolower($request->keterangan)),
                    'file'          => $filenameSimpan,
                    'jurusan'       => ucwords(strtolower($request->jurusan)),
                    'tangakhir'     => $request->tangakhir,
                    'wakakhir'      => $request->wakakhir,
                ]);

            if ($save) {
                Session::flash('success', 'Berhasil! Tugas berhasil dibuat');
                return redirect('/tugas_siswa');
            }
            Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        } else {
            // tidak ada
            $save = Task::where('id', $request->idt)
                ->update([
                    'judul'         => ucwords(strtolower($request->judul)),
                    'keterangan'    => ucfirst(strtolower($request->keterangan)),
                    'jurusan'       => ucwords(strtolower($request->jurusan)),
                    'tangakhir'     => $request->tangakhir,
                    'wakakhir'      => $request->wakakhir,
                ]);

            if ($save) {
                Session::flash('success', 'Berhasil! Tugas berhasil dibuat');
                return redirect('/tugas_siswa');
            }
            Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
