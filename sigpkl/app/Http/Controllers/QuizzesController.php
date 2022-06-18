<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Enigma;
use App\Models\Choice;
use App\Models\Major;
use App\Models\Myquiz;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Session;

class QuizzesController extends Controller
{
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
    public function create($idk = null)
    {
        if (Auth::user()->is_admin == 1) {
            $jurusan = Major::all();
            $siswa = Student::select('*')->orderBy('kelas', 'asc')->orderBy('nama', 'asc')->get();
            $kuis = Quiz::where('id', $idk)->first();
            $tanyaan = Enigma::where('id_kuis', $idk)->get();
            $pilihan = Choice::all();
            return view('multi.buatkuis', compact('jurusan', 'siswa', 'kuis', 'idk', 'tanyaan', 'pilihan'));
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
        if ($request->individu == 1) {
            $rules = [
                'kuis' => 'required|min:5|max:128',
                'jurusan' => 'nullable',
                'siswa' => 'required',
                'tangakhir' => 'required|date',
                'wakakhir' => 'required',
            ];

            $messages = [
                'kuis.required'    => 'Nama Kuis wajib diisi',
                'kuis.min'        => 'Nama Kuis minimal 5 karakter',
                'kuis.max'        => 'Nama Kuis maximal 128 karakter',
                'siswa.required'    => 'Siswa wajib diisi',
                'tangakhir.required'    => 'Tanggal wajib diisi',
                'wakakhir.required'    => 'Harus berupa tanggal',
                'wakakhir.required'    => 'Waktu wajib diisi',
            ];
        } else {
            $rules = [
                'kuis' => 'required|min:5|max:128',
                'jurusan' => 'required',
                'individu' => 'nullable',
                'siswa' => 'nullable',
                'tangakhir' => 'required|date',
                'wakakhir' => 'required',
            ];

            $messages = [
                'kuis.required'    => 'Nama Kuis wajib diisi',
                'kuis.min'        => 'Nama Kuis minimal 5 karakter',
                'kuis.max'        => 'Nama Kuis maximal 128 karakter',
                'jurusan.required'    => 'Jurusan wajib diisi',
                'tangakhir.required'    => 'Tanggal wajib diisi',
                'wakakhir.required'    => 'Harus berupa tanggal',
                'wakakhir.required'    => 'Waktu wajib diisi',
            ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        if ($request->individu == 1) {
            $sim = new Quiz;
            $sim->kuis = ucwords(strtolower($request->kuis));
            $sim->oleh = Auth::user()->id;
            $sim->jurusan = ucwords(strtolower($request->jurusan));
            $sim->untuk = strtolower($request->siswa);
            $sim->tangakhir = $request->tangakhir;
            $sim->wakakhir = $request->wakakhir;
            $save = $sim->save();
        } else {
            $sim = new Quiz;
            $sim->kuis = ucwords(strtolower($request->kuis));
            $sim->oleh = Auth::user()->id;
            $sim->jurusan = ucwords(strtolower($request->jurusan));
            $sim->tangakhir = $request->tangakhir;
            $sim->wakakhir = $request->wakakhir;
            $save = $sim->save();
        }

        if ($save) {
            $idk = Quiz::where('oleh', Auth::user()->id)->orderBy('created_at', 'desc')->first();
            Session::flash('success', 'Membuat kuis berhasil, lanjutkan membuat soal');
            return redirect('/buat_kuis/' . $idk->id);
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        $tanyaan = Enigma::where('id_kuis', $quiz->id)->get();
        $jurusan = Major::all();
        $siswa = Student::select('*')->orderBy('kelas', 'asc')->orderBy('nama', 'asc')->get();
        return view('multi.editkuis', compact('quiz', 'tanyaan', 'jurusan', 'siswa'));
    }

    public function getPilihin($kirim)
    {
        $ch = Choice::where('id_tanyaan', $kirim)->get();
        return $ch;
    }
    public function jumPilihin($kirim)
    {
        $jch = Choice::where('id_tanyaan', $kirim)->count();
        return $jch;
    }
    public function jumPilihinBenar($kirim)
    {
        $jchb = Choice::where('id_tanyaan', $kirim)->where('benar', 1)->count();
        return $jchb;
    }

    public function isiKuis(Quiz $quiz)
    {
        $siswa = Student::where('id_user', Auth::user()->id)->first();
        $tanyaan = Enigma::where('id_kuis', $quiz->id)->paginate(1);
        $tanyaanget = Enigma::where('id_kuis', $quiz->id)->get();
        $banyaktny = Enigma::where('id_kuis', $quiz->id)->count();
        $kuisni = Myquiz::where('nis', $siswa->nis)->where('id_kuis', $quiz->id)->first();
        $answers = Answer::select('id_tanyaan')->where('nis', $siswa->nis)->where('id_kuis', $quiz->id)->first();
        return view('multi.isikuis', compact('quiz', 'tanyaan', 'tanyaanget', 'kuisni', 'answers', 'banyaktny'));
    }

    public function getSdhJwb($idt)
    {
        $siswa = Student::where('id_user', Auth::user()->id)->first();
        $jwb = Answer::where('nis', $siswa->nis)->where('id_tanyaan', $idt)->first();
        if ($jwb != null) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getdich($idch)
    {
        $siswa = Student::where('id_user', Auth::user()->id)->first();
        $jwb = Answer::where('nis', $siswa->nis)->where('id_pilihan', $idch)->where('dipilih', 1)->first();
        if ($jwb != null) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        if ($request->individu == 1) {
            $rules = [
                'kuis' => 'required|min:5|max:128',
                'jurusan' => 'nullable',
                'siswa' => 'required',
                'tangakhir' => 'required|date',
                'wakakhir' => 'required',
            ];

            $messages = [
                'kuis.required'    => 'Nama Kuis wajib diisi',
                'kuis.min'        => 'Nama Kuis minimal 5 karakter',
                'kuis.max'        => 'Nama Kuis maximal 128 karakter',
                'siswa.required'    => 'Siswa wajib diisi',
                'tangakhir.required'    => 'Tanggal wajib diisi',
                'wakakhir.required'    => 'Harus berupa tanggal',
                'wakakhir.required'    => 'Waktu wajib diisi',
            ];
        } else {
            $rules = [
                'kuis' => 'required|min:5|max:128',
                'jurusan' => 'required',
                'individu' => 'nullable',
                'siswa' => 'nullable',
                'tangakhir' => 'required|date',
                'wakakhir' => 'required',
            ];

            $messages = [
                'kuis.required'    => 'Nama Kuis wajib diisi',
                'kuis.min'        => 'Nama Kuis minimal 5 karakter',
                'kuis.max'        => 'Nama Kuis maximal 128 karakter',
                'jurusan.required'    => 'Jurusan wajib diisi',
                'tangakhir.required'    => 'Tanggal wajib diisi',
                'wakakhir.required'    => 'Harus berupa tanggal',
                'wakakhir.required'    => 'Waktu wajib diisi',
            ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        if ($request->individu == 1) {
            $save = Quiz::where('id', $request->id)
                ->update([
                    'kuis' => ucwords(strtolower($request->kuis)),
                    'oleh' => Auth::user()->id,
                    'jurusan' => ucwords(strtolower($request->jurusan)),
                    'untuk' => strtolower($request->siswa),
                    'tangakhir' => $request->tangakhir,
                    'wakakhir' => $request->wakakhir,
                ]);
        } else {
            $save = Quiz::where('id', $request->id)
                ->update([
                    'kuis' => ucwords(strtolower($request->kuis)),
                    'oleh' => Auth::user()->id,
                    'jurusan' => ucwords(strtolower($request->jurusan)),
                    'tangakhir' => $request->tangakhir,
                    'wakakhir' => $request->wakakhir,
                ]);
        }

        if ($save) {
            Session::flash('success', 'Mengubah kuis berhasil');
            return redirect('/edit_kuis/' . $request->id);
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    public function update_buat_kuis(Request $request, Quiz $quiz)
    {
        if ($request->individu == 1) {
            $rules = [
                'kuis' => 'required|min:5|max:128',
                'jurusan' => 'nullable',
                'siswa' => 'required',
                'tangakhir' => 'required|date',
                'wakakhir' => 'required',
            ];

            $messages = [
                'kuis.required'    => 'Nama Kuis wajib diisi',
                'kuis.min'        => 'Nama Kuis minimal 5 karakter',
                'kuis.max'        => 'Nama Kuis maximal 128 karakter',
                'siswa.required'    => 'Siswa wajib diisi',
                'tangakhir.required'    => 'Tanggal wajib diisi',
                'wakakhir.required'    => 'Harus berupa tanggal',
                'wakakhir.required'    => 'Waktu wajib diisi',
            ];
        } else {
            $rules = [
                'kuis' => 'required|min:5|max:128',
                'jurusan' => 'required',
                'individu' => 'nullable',
                'siswa' => 'nullable',
                'tangakhir' => 'required|date',
                'wakakhir' => 'required',
            ];

            $messages = [
                'kuis.required'    => 'Nama Kuis wajib diisi',
                'kuis.min'        => 'Nama Kuis minimal 5 karakter',
                'kuis.max'        => 'Nama Kuis maximal 128 karakter',
                'jurusan.required'    => 'Jurusan wajib diisi',
                'tangakhir.required'    => 'Tanggal wajib diisi',
                'wakakhir.required'    => 'Harus berupa tanggal',
                'wakakhir.required'    => 'Waktu wajib diisi',
            ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        if ($request->individu == 1) {
            $save = Quiz::where('id', $request->id)
                ->update([
                    'kuis' => ucwords(strtolower($request->kuis)),
                    'oleh' => Auth::user()->id,
                    'jurusan' => ucwords(strtolower($request->jurusan)),
                    'untuk' => strtolower($request->siswa),
                    'tangakhir' => $request->tangakhir,
                    'wakakhir' => $request->wakakhir,
                ]);
        } else {
            $save = Quiz::where('id', $request->id)
                ->update([
                    'kuis' => ucwords(strtolower($request->kuis)),
                    'oleh' => Auth::user()->id,
                    'jurusan' => ucwords(strtolower($request->jurusan)),
                    'tangakhir' => $request->tangakhir,
                    'wakakhir' => $request->wakakhir,
                ]);
        }

        if ($save) {
            Session::flash('success', 'Membuat kuis berhasil, lanjutkan membuat soal');
            return redirect('/buat_kuis/' . $request->id);
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
