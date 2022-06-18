<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use App\Models\Industrie;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Calendar;
use App\Models\Menu;
use App\Models\Myjob;
use App\Models\Myquiz;
use App\Models\Placement;
use App\Models\Presence;
use App\Models\Quiz;
use App\Models\Task;
use App\Models\Test;
use App\Models\Visit;
use Illuminate\Http\Request;
use Carbon;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Session;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function bantuan()
    {
        return view('bantuan');
    }
    public function index()
    {
        $sch = School::where('id', 1)->first();
        if (Auth::user()->is_admin == 1) {
            $guru = Teacher::all()->count();
            $bnyksiswa = Student::all()->count();
            $indu = Industrie::all()->count();
            $jumterima = Placement::select('nis')->count();
            $jumnerima = Placement::select('id_industri')->count();
            $ind = Industrie::all();
            foreach ($ind as $in) {
                $industri[] = app('App\Http\Controllers\HomeController')->getInd($in->id);
                $bnyksiswas = Placement::where('id_industri', $in->id)->count();

                if ($bnyksiswas == 1) {
                    $siswas = Placement::where('id_industri', $in->id)->first();
                    $sw[] = Student::where('nis', $siswas->nis)->first();
                    $siswa[] = $sw;
                } elseif ($bnyksiswas > 1) {
                    $siswas = Placement::where('id_industri', $in->id)->get();
                    foreach ($siswas as $ss) {
                        $cek = Placement::where('id_industri', $in->id)->where('nis', $ss->nis)->first();
                        if ($cek != null) {
                            $sw[] = Student::where('nis', $ss->nis)->first();
                        }
                    }
                    $siswa[] = $sw;
                } elseif ($bnyksiswas <= 0) {
                    $siswa[] = null;
                }
            }
            $json1 = json_encode(array('results1' => $industri));
            $json2 = json_encode(array('results2' => $siswa));
            return view('home', compact('indu', 'guru', 'bnyksiswa', 'sch', 'jumterima', 'jumnerima', 'industri', 'siswa', 'json1', 'json2'));
        } elseif (Auth::user()->is_guru == 1) {
            $guru = Teacher::where('id_user', Auth::user()->id)->first();
            $siswa = Placement::where('n_induk', $guru->n_induk)->select('nis')->count();
            $indu = Placement::where('n_induk', $guru->n_induk)->select('id_industri')->count();
            $data = Test::where('pembimbing', $guru->n_induk)->orWhere('penguji', $guru->n_induk)->get();
            $kunjungan = Visit::where('n_induk', $guru->n_induk)->count();
            return view('home', compact('data', 'indu', 'guru', 'siswa', 'sch', 'kunjungan'));
        } elseif (Auth::user()->is_industri == 1) {
            $ind = Industrie::where('id_user', Auth::user()->id)->first();
            $siswa = Placement::where('id_industri', $ind->id)->select('nis')->count();
            $indu = Industrie::all();
            foreach ($indu as $in) {
                if ($in->id_user == Auth::user()->id) {
                    $industri[] = app('App\Http\Controllers\HomeController')->getInd($in->id);
                    $bnyksiswas = Placement::where('id_industri', $in->id)->count();

                    if ($bnyksiswas == 1) {
                        $siswas = Placement::where('id_industri', $in->id)->first();
                        $sw[] = Student::where('nis', $siswas->nis)->first();
                        $students[] = $sw;
                    } elseif ($bnyksiswas > 1) {
                        $siswas = Placement::where('id_industri', $in->id)->get();
                        foreach ($siswas as $ss) {
                            $cek = Placement::where('id_industri', $in->id)->where('nis', $ss->nis)->first();
                            if ($cek != null) {
                                $sw[] = Student::where('nis', $ss->nis)->first();
                            }
                        }
                        $students[] = $sw;
                    } elseif ($bnyksiswas <= 0) {
                        $students[] = null;
                    }
                }
            }
            $siswamagang = DB::table('placements')
                ->join('students', 'placements.nis', '=', 'students.nis')
                ->select('students.nama', 'students.kelas', 'students.jurusan', 'placements.*')
                ->where('placements.id_industri', $ind->id)
                ->get();
            $absen = Calendar::where('id_industri', $ind->id)->where('masuk', 1)->count();
            $tugas = Task::where('oleh', $ind->id_user)->count();
            $json1 = json_encode(array('results' => $industri));
            $json2 = json_encode(array('results' => $students));
            return view('home', compact('indu', 'siswa', 'json1', 'json2', 'tugas', 'absen', 'siswamagang', 'students', 'industri'));
        } elseif (Auth::user()->is_siswa == 1) {
            $siswa = Student::where('id_user', Auth::user()->id)->first();
            $waktu = Placement::where('nis', $siswa->nis)->first();
            $quiz = Quiz::where('jurusan', $siswa->jurusan)->orWhere('untuk', $siswa->nis)->count();
            $indu = Placement::where('nis', $siswa->nis)->first();
            if ($indu != null) {
                $idui = Industrie::where('id', $indu->id_industri)->first();
                $jadw = Calendar::where('id_industri', $indu->id)->where('masuk', 1)->get();
                $absen = Calendar::where('id_industri', $indu->id)->where('masuk', 1)->count();
                $tgs = Task::where('oleh', $idui->id_user)->orWhere('jurusan', $siswa->jurusan)->orWhere('untuk', $siswa->nis)->count();
                $tugas = Task::where('oleh', $idui->id_user)->orWhere('jurusan', $siswa->jurusan)->orWhere('untuk', $siswa->nis)->get();
                $jumtugas = $tgs + $quiz;
            } else {
                $idui = null;
                $jadw = null;
                $absen = 0;
                $tgs = 0;
                $tugas = null;
                $jumtugas = 0;
            }
            $hadir = Presence::where('nis', $siswa->nis)->where('hadir', 1)->count();
            $kuis = Quiz::where('jurusan', $siswa->jurusan)->orWhere('untuk', $siswa->nis)->get();
            $tugasku = Myjob::where('nis', $siswa->nis)->count();
            $kuisku = Myquiz::where('nis', $siswa->nis)->count();
            $jumtugasku = $tugasku + $kuisku;
            $data = Test::where('nis', $siswa->nis)->first();
            return view('home', compact('sch', 'jumtugas', 'jumtugasku', 'absen', 'hadir', 'data', 'waktu', 'indu', 'jadw', 'tugas', 'kuis'));
        }
    }

    public function getInd($idi)
    {
        $ind = Industrie::where('id', $idi)->first();
        return $ind;
    }

    public function getSiswas($idi)
    {
        $bss = Placement::where('id_industri', $idi)->count();
        if ($bss == 1) {
            $ss = Placement::where('id_industri', $idi)->first();
            $siswas = Student::where('nis', $ss->nis)->first();
            return $siswas;
        } else {
            $ss = Placement::where('id_industri', $idi)->get();
            $x = 1;
            foreach ($ss as $s) {
                $siswas[$x] = Student::where('nis', $s->nis)->first();
                $x++;
            }
            return $siswas;
        }
    }

    public function getSiswa($nis)
    {
        $siswa = Student::where('nis', $nis)->first();
        return $siswa;
    }

    public function getStatusTugas($idt, $ids)
    {
        $siswa = Student::where('id_user', $ids)->first();
        $mytgs = Myjob::where('id_tugas', $idt)->where('nis', $siswa->nis)->first();
        return $mytgs;
    }

    public function getStatusKuis($idt, $ids)
    {
        $siswa = Student::where('id_user', $ids)->first();
        $mytgs = Myquiz::where('id_kuis', $idt)->where('nis', $siswa->nis)->first();
        return $mytgs;
    }

    public function logout()
    {
        if (session()->has('LoggedUser')) {
            session()->pull('LoggedUser');
            return redirect()->route('flogin');
        }
    }

    public function getdftaw()
    {
        $get = School::select('*')->where('id', 1)->first();
        $res = date('Ymd', strtotime($get->dft_mulai));
        if ($get->dft_mulai == null) {
            $res = null;
            return $res;
        }
        return $res;
    }
    public function getdftakh()
    {
        $get = School::select('*')->where('id', 1)->first();
        $res = date('Ymd', strtotime($get->dft_sampai));
        if ($get->dft_sampai == null) {
            $res = null;
            return $res;
        }
        return $res;
    }

    public function getcariaw()
    {
        $get = School::select('*')->where('id', 1)->first();
        $res = date('Ymd', strtotime($get->clk_mulai));
        if ($get->clk_mulai == null) {
            $res = null;
            return $res;
        }
        return $res;
    }
    public function getcariakh()
    {
        $get = School::select('*')->where('id', 1)->first();
        $res = date('Ymd', strtotime($get->clk_sampai));
        if ($get->clk_sampai == null) {
            $res = null;
            return $res;
        }
        return $res;
    }

    public function getkegaw()
    {
        $get = School::select('*')->where('id', 1)->first();
        $res = date('Ymd', strtotime($get->pkl_mulai));
        if ($get->pkl_mulai == null) {
            $res = null;
            return $res;
        }
        return $res;
    }
    public function getkegakh()
    {
        $get = School::select('*')->where('id', 1)->first();
        $res = date('Ymd', strtotime($get->pkl_sampai));
        if ($get->pkl_sampai == null) {
            $res = null;
            return $res;
        }
        return $res;
    }

    public function getnyusaw()
    {
        $get = School::select('*')->where('id', 1)->first();
        $res = date('Ymd', strtotime($get->lap_mulai));
        if ($get->lap_mulai == null) {
            $res = null;
            return $res;
        }
        return $res;
    }
    public function getnyusakh()
    {
        $get = School::select('*')->where('id', 1)->first();
        $res = date('Ymd', strtotime($get->lap_sampai));
        if ($get->lap_sampai == null) {
            $res = null;
            return $res;
        }
        return $res;
    }

    public function getujiaw()
    {
        $get = School::select('*')->where('id', 1)->first();
        $res = date('Ymd', strtotime($get->uji_mulai));
        if ($get->uji_mulai == null) {
            $res = null;
            return $res;
        }
        return $res;
    }
    public function getujiakh()
    {
        $get = School::select('*')->where('id', 1)->first();
        $res = date('Ymd', strtotime($get->uji_sampai));
        if ($get->uji_sampai == null) {
            $res = null;
            return $res;
        }
        return $res;
    }

    public function geteditdtuji()
    {
        $get = School::select('*')->where('id', 1)->first();
        $res = date('Ymd', strtotime($get->uji_mulai));
        if ($get->uji_mulai == null) {
            $res = null;
            return $res;
        } else {
            $am = $get->uji_mulai;
            $res = date('Ymd', strtotime($am));
            return $res;
        }
    }

    public function getbniaw()
    {
        $get = School::select('*')->where('id', 1)->first();
        $res = date('Ymd', strtotime($get->pkl_sampai));
        if ($get->pkl_sampai == null) {
            $res = null;
            return $res;
        } else {
            $am = $get->pkl_sampai;
            $res = date('Ymd', strtotime($am));
            return $res;
        }
    }
    public function getbniakh()
    {
        $get = School::select('*')->where('id', 1)->first();
        $res = date('Ymd', strtotime($get->pkl_sampai));
        if ($get->pkl_sampai == null) {
            $res = null;
            return $res;
        } else {
            $am = $get->pkl_sampai;
            $res = date('Ymd', strtotime($am));
            return $res;
        }
    }

    public function getniakh()
    {
        $get = School::select('*')->where('id', 1)->first();
        $res = date('Ymd', strtotime($get->uji_sampai));
        if ($get->uji_sampai == null) {
            $res = null;
            return $res;
        } else {
            $am = $get->uji_sampai;
            $res = date('Ymd', strtotime($am));
            return $res;
        }
    }

    public function getaktif($menu)
    {
        $get = Menu::where('menu', $menu)->first();
        $res = $get->aktif;
        return $res;
    }
}
