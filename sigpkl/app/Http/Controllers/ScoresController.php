<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Score;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Industrie;
use App\Models\Placement;
use App\Models\Presentation;
use App\Models\Report;
use App\Models\Calendar;
use App\Models\Presence;
use App\Models\Task;
use App\Models\Myjob;
use App\Models\Quiz;
use App\Models\Myquiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Session;

class ScoresController extends Controller
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
        if (Auth::user()->is_admin == 1) {
            $nilai = DB::table('students')
                ->join('scores', 'students.nis', '=', 'scores.nis')
                ->select('students.nama', 'students.jurusan', 'students.kelas', 'scores.id', 'scores.nilai_akhir', 'scores.nis as nis')
                ->orderby('jurusan', 'asc')
                ->orderby('kelas', 'asc')
                ->orderby('nama', 'asc')
                ->get();
            $data = Score::select('*')->count();
            return view('admin.lapnilai', compact('nilai', 'data'));
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
        //
    }

    public function beri_penilaian($id)
    {
        if (Auth::user()->is_industri == 1) {
            $siswa = Student::where('id_user', $id)->first();
            $magang = DB::table('placements')
                ->join('students', 'placements.nis', '=', 'students.nis')
                ->select('students.nama', 'students.kelas', 'students.jurusan', 'placements.*')
                ->where('placements.nis', $siswa->nis)
                ->get();
            $scre = Score::where('nis', $siswa->nis)->first();
            return view('multi.beripenilaian', compact('magang', 'scre'));
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
            'laporan'          => 'required|numeric|min:10|max:100',
            'presentasi'          => 'required|numeric|min:10|max:100',
        ];

        $messages = [
            'laporan.required'    => 'Nilai Laporan wajib diisi',
            'laporan.min'         => 'Penilaian dimulai dari 10 - 100',
            'laporan.max'         => 'Penilaian dimulai dari 10 - 100',
            'laporan.numeric'     => 'Harus berupa angka bilangan bulat',
            'presentasi.required'    => 'Nilai Presentasi wajib diisi',
            'presentasi.min'         => 'Penilaian dimulai dari 10 - 100',
            'presentasi.max'         => 'Penilaian dimulai dari 10 - 100',
            'presentasi.numeric'     => 'Harus berupa angka bilangan bulat',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $ni = Teacher::where('id_user', Auth::user()->id)->first();
        $test = Test::where('nis', $request->nis)->first();

        if ($test->pembimbing == $ni->n_induk) {
            $save = Report::where('nis', $request->nis)
                ->update([
                    'nilai_a' => $request->laporan,
                ]);

            $save2 = Presentation::where('nis', $request->nis)
                ->update([
                    'nilai_a' => $request->presentasi,
                ]);

            if ($save && $save2) {
                $cek1 = Report::where('nis', $request->nis)->first();
                $cek2 = Presentation::where('nis', $request->nis)->first();

                if ($cek1->nilai_b != null && $cek2->nilai_b != null) {
                    $nilaporan = ($cek1->nilai_a + $cek1->nilai_b) / 2;
                    $nipresentasi = ($cek2->nilai_a + $cek2->nilai_b) / 2;
                    $save3 = Score::where('nis', $request->nis)
                        ->update([
                            'nilai_laporan' => $nilaporan,
                            'nilai_presentasi' => $nipresentasi,
                        ]);

                    if ($save3) {
                        $idui = Placement::where('nis', $request->nis)->first();
                        $jumabsen = Calendar::where('id_industri', $idui->id_industri)->where('masuk', 1)->count();
                        $jumhadir = Presence::where('nis', $request->nis)->where('hadir', 1)->count();
                        $niabsen = ($jumhadir / $jumabsen) * 100;

                        $ceknisem = Score::where('nis', $request->nis)->first();

                        $save4 = Score::where('nis', $request->nis)
                            ->update([
                                'nilai_absensi' => $niabsen,
                            ]);

                        if ($save4 || $niabsen == $ceknisem->nilai_absensi) {
                            $siswa = Student::where('nis', $request->nis)->first();
                            $sch = User::where('is_admin', 1)->first();
                            $indu = Industrie::where('id', $idui->id_industri)->first();
                            $tugas = Myjob::where('nis', $request->nis)->sum('nilai');
                            $kuis = Myquiz::where('nis', $request->nis)->sum('nilai');
                            $jumtugind = Task::where('oleh', $indu->id_user)->count();
                            $jumtugsch = Task::where('oleh', $sch->id)->where('jurusan', $siswa->jurusan)->count();
                            $jumtugindsch = Task::where('untuk', $request->nis)->count();
                            $jumkuis = Quiz::where('jurusan', $siswa->jurusan)->count();
                            $nitugas = ($tugas + $kuis) / ($jumtugind + $jumtugsch + $jumkuis + $jumtugindsch);

                            $save5 = Score::where('nis', $request->nis)
                                ->update([
                                    'nilai_tugas' => $nitugas,
                                ]);

                            if ($save5 || $nitugas == $ceknisem->nilai_tugas) {
                                $nini = Score::where('nis', $request->nis)->first();
                                $jumni = (($nini->nilai_absensi * 0.1) + ($nini->nilai_tugas * 0.2) + ($nini->nilai_laporan * 0.25) + ($nini->nilai_presentasi * 0.25) + ($nini->nilai_pemlapangan * 0.2));

                                $save6 = Score::where('nis', $request->nis)
                                    ->update([
                                        'nilai_akhir' => $jumni,
                                    ]);

                                if ($save6) {
                                    Session::flash('success', 'Penilaian siswa telah dilakukan');
                                    return redirect('/pengujian');
                                } elseif ($jumni == $ceknisem->nilai_akhir) {
                                    Session::flash('fai', 'Tidak ada perubahan nilai');
                                    return redirect()->back();
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
                    Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
                    return redirect()->back();
                }
                Session::flash('success', 'Penilaian siswa telah dilakukan');
                return redirect('/pengujian');
            }
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        } elseif ($test->penguji == $ni->n_induk) {
            $save = Report::where('nis', $request->nis)
                ->update([
                    'nilai_b' => $request->laporan,
                ]);

            $save2 = Presentation::where('nis', $request->nis)
                ->update([
                    'nilai_b' => $request->presentasi,
                ]);

            if ($save && $save2) {
                $cek1 = Report::where('nis', $request->nis)->first();
                $cek2 = Presentation::where('nis', $request->nis)->first();

                if ($cek1->nilai_a != null && $cek2->nilai_a != null) {
                    $laporan = ($cek1->nilai_a + $cek1->nilai_b) / 2;
                    $presentasi = ($cek2->nilai_a + $cek2->nilai_b) / 2;
                    $save3 = Score::where('nis', $request->nis)
                        ->update([
                            'nilai_laporan' => $laporan,
                            'nilai_presentasi' => $presentasi,
                        ]);

                    if ($save3) {
                        $idui = Placement::where('nis', $request->nis)->first();
                        $jumabsen = Calendar::where('id_industri', $idui->id_industri)->where('masuk', 1)->count();
                        $jumhadir = Presence::where('nis', $request->nis)->where('hadir', 1)->count();
                        $niabsen = ($jumhadir / $jumabsen) * 100;

                        $ceknisem = Score::where('nis', $request->nis)->first();

                        $save4 = Score::where('nis', $request->nis)
                            ->update([
                                'nilai_absensi' => $niabsen,
                            ]);

                        if ($save4 || $niabsen == $ceknisem->nilai_absensi) {
                            $siswa = Student::where('nis', $request->nis)->first();
                            $sch = User::where('is_admin', 1)->first();
                            $indu = Industrie::where('id', $idui->id_industri)->first();
                            $tugas = Myjob::where('nis', $request->nis)->sum('nilai');
                            $kuis = Myquiz::where('nis', $request->nis)->sum('nilai');
                            $jumtugind = Task::where('oleh', $indu->id_user)->count();
                            $jumtugsch = Task::where('oleh', $sch->id)->where('jurusan', $siswa->jurusan)->count();
                            $jumtugindsch = Task::where('untuk', $request->nis)->count();
                            $jumkuis = Quiz::where('jurusan', $siswa->jurusan)->count();
                            $nitugas = ($tugas + $kuis) / ($jumtugind + $jumtugsch + $jumkuis + $jumtugindsch);

                            $save5 = Score::where('nis', $request->nis)
                                ->update([
                                    'nilai_tugas' => $nitugas,
                                ]);

                            if ($save5 || $nitugas == $ceknisem->nilai_tugas) {
                                $nini = Score::where('nis', $request->nis)->first();
                                $jumni = (($nini->nilai_absensi * 0.1) + ($nini->nilai_tugas * 0.2) + ($nini->nilai_laporan * 0.25) + ($nini->nilai_presentasi * 0.25) + ($nini->nilai_pemlapangan * 0.2));

                                $save6 = Score::where('nis', $request->nis)
                                    ->update([
                                        'nilai_akhir' => $jumni,
                                    ]);

                                if ($save6) {
                                    Session::flash('success', 'Penilaian siswa telah dilakukan');
                                    return redirect('/pengujian');
                                } elseif ($jumni == $ceknisem->nilai_akhir) {
                                    Session::flash('fai', 'Tidak ada perubahan nilai');
                                    return redirect()->back();
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
                    Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
                    return redirect()->back();
                }
                Session::flash('success', 'Penilaian siswa telah dilakukan');
                return redirect('/pengujian');
            }
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function show(Score $score)
    {
        $siswa = Student::where('nis', $score->nis)->first();
        $nilai = Score::where('nis', $score->nis)->first();
        $data = Score::where('nis', $score->nis)->count();
        return view('admin.detailnilai', compact('siswa', 'nilai', 'data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function nilai_saya()
    {
        if (Auth::user()->is_siswa == 1) {
            $siswa = Student::where('id_user', Auth::user()->id)->first();
            $nilai = Score::where('nis', $siswa->nis)->first();
            $data = Score::where('nis', $siswa->nis)->count();
            return view('siswa.nilai', compact('siswa', 'nilai', 'data'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function edit(Score $score)
    {
        $siswa = Student::where('nis', $score->nis)->first();
        $nilai = Score::where('id', $score->id)->first();
        return view('admin.editnilai', compact('nilai', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Score $score)
    {
        $rules = [
            'nilai_absensi'     => 'required|numeric|min:10|max:100',
            'nilai_tugas'       => 'required|numeric|min:10|max:100',
            'nilai_laporan'     => 'required|numeric|min:10|max:100',
            'nilai_presentasi'  => 'required|numeric|min:10|max:100',
            'nisik'             => 'required|numeric|min:10|max:100',
            'nidis'             => 'required|numeric|min:10|max:100',
            'nitrm'             => 'required|numeric|min:10|max:100',
            'niker'             => 'required|numeric|min:10|max:100',
        ];

        $messages = [
            'nilai_absensi.required'    => 'Nilai Absensi wajib diisi',
            'nilai_absensi.min'         => 'Penilaian dimulai dari 10 - 100',
            'nilai_absensi.max'         => 'Penilaian dimulai dari 10 - 100',
            'nilai_absensi.numeric'     => 'Harus berupa angka bilangan bulat',
            'nilai_tugas.required'    => 'Nilai Tugas wajib diisi',
            'nilai_tugas.min'         => 'Penilaian dimulai dari 10 - 100',
            'nilai_tugas.max'         => 'Penilaian dimulai dari 10 - 100',
            'nilai_tugas.numeric'     => 'Harus berupa angka bilangan bulat',
            'nilai_laporan.required'    => 'Nilai Laporan wajib diisi',
            'nilai_laporan.min'         => 'Penilaian dimulai dari 10 - 100',
            'nilai_laporan.max'         => 'Penilaian dimulai dari 10 - 100',
            'nilai_laporan.numeric'     => 'Harus berupa angka bilangan bulat',
            'nilai_presentasi.required'    => 'Nilai Presentasi wajib diisi',
            'nilai_presentasi.min'         => 'Penilaian dimulai dari 10 - 100',
            'nilai_presentasi.max'         => 'Penilaian dimulai dari 10 - 100',
            'nilai_presentasi.numeric'     => 'Harus berupa angka bilangan bulat',
            'nisik.required'    => 'Nilai Sikap wajib diisi',
            'nisik.min'         => 'Penilaian dimulai dari 10 - 100',
            'nisik.max'         => 'Penilaian dimulai dari 10 - 100',
            'nisik.numeric'     => 'Harus berupa angka bilangan bulat',
            'nidis.required'    => 'Nilai Kedisiplinan wajib diisi',
            'nidis.min'         => 'Penilaian dimulai dari 10 - 100',
            'nidis.max'         => 'Penilaian dimulai dari 10 - 100',
            'nidis.numeric'     => 'Harus berupa angka bilangan bulat',
            'nitrm.required'    => 'Nilai Ketarampilan wajib diisi',
            'nitrm.min'         => 'Penilaian dimulai dari 10 - 100',
            'nitrm.max'         => 'Penilaian dimulai dari 10 - 100',
            'nitrm.numeric'     => 'Harus berupa angka bilangan bulat',
            'niker.required'    => 'Nilai Kerapian wajib diisi',
            'niker.min'         => 'Penilaian dimulai dari 10 - 100',
            'niker.max'         => 'Penilaian dimulai dari 10 - 100',
            'niker.numeric'     => 'Harus berupa angka bilangan bulat',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $rtrt = ($request->nisik + $request->nidis + $request->nitrm + $request->niker) / 4;

        $save = Score::where('nis', $request->nis)
            ->update([
                'nilai_absensi' => $request->nilai_absensi,
                'nilai_tugas' => $request->nilai_tugas,
                'nilai_laporan' => $request->nilai_laporan,
                'nilai_presentasi' => $request->nilai_presentasi,
                'nisik_indu' => $request->nisik,
                'nidis_indu' => $request->nidis,
                'nitrm_indu' => $request->nitrm,
                'niker_indu' => $request->niker,
                'nilai_pemlapangan' => $rtrt,
            ]);

        if ($save) {
            $nini = Score::where('nis', $request->nis)->first();
            $jumni = (($nini->nilai_absensi * 0.1) + ($nini->nilai_tugas * 0.2) + ($nini->nilai_laporan * 0.25) + ($nini->nilai_presentasi * 0.25) + ($nini->nilai_pemlapangan * 0.2));

            $save2 = Score::where('nis', $request->nis)
                ->update([
                    'nilai_akhir' => $jumni,
                ]);

            if ($save2) {
                Session::flash('success', 'Berhasil diberi nilai');
                return redirect('/laporan_nilai');
            }
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    public function nilai_penilaian(Request $request, Score $score)
    {
        $rules = [
            'nisik'          => 'required|numeric|min:10|max:100',
            'nidis'          => 'required|numeric|min:10|max:100',
            'nitrm'          => 'required|numeric|min:10|max:100',
            'niker'          => 'required|numeric|min:10|max:100',
        ];

        $messages = [
            'nisik.required'    => 'Nilai Sikap wajib diisi',
            'nisik.min'         => 'Penilaian dimulai dari 10 - 100',
            'nisik.max'         => 'Penilaian dimulai dari 10 - 100',
            'nisik.numeric'     => 'Harus berupa angka bilangan bulat',
            'nidis.required'    => 'Nilai Kedisiplinan wajib diisi',
            'nidis.min'         => 'Penilaian dimulai dari 10 - 100',
            'nidis.max'         => 'Penilaian dimulai dari 10 - 100',
            'nidis.numeric'     => 'Harus berupa angka bilangan bulat',
            'nitrm.required'    => 'Nilai Keterampilan wajib diisi',
            'nitrm.min'         => 'Penilaian dimulai dari 10 - 100',
            'nitrm.max'         => 'Penilaian dimulai dari 10 - 100',
            'nitrm.numeric'     => 'Harus berupa angka bilangan bulat',
            'niker.required'    => 'Nilai Kerapian wajib diisi',
            'niker.min'         => 'Penilaian dimulai dari 10 - 100',
            'niker.max'         => 'Penilaian dimulai dari 10 - 100',
            'niker.numeric'     => 'Harus berupa angka bilangan bulat',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $rtrt = ($request->nisik + $request->nidis + $request->nitrm + $request->niker) / 4;

        $save = Score::where('nis', $request->nis)->orwhere('id', $request->ids)
            ->update([
                'nisik_indu' => $request->nisik,
                'nidis_indu' => $request->nidis,
                'nitrm_indu' => $request->nitrm,
                'niker_indu' => $request->niker,
                'nilai_pemlapangan' => $rtrt,
            ]);

        if ($save) {
            Session::flash('success', 'Tugas berhasil diberi nilai');
            return redirect('/penilaian');
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function destroy(Score $score)
    {
        //
    }
}
