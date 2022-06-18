<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Province;
use App\Models\Citie;
use App\Models\Major;
use App\Models\Classe;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Session;

class StudentsController extends Controller
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
        if (Auth::user()->is_admin) {
            $siswa = Student::select('*')->orderby('jurusan', 'asc')->orderby('kelas', 'asc')->orderby('nama', 'asc')->where('nama', 'like', "%" . $request->keywrd . "%")->orwhere('jurusan', 'like', "%" . $request->keywrd . "%")->orwhere('kelas', 'like', "%" . $request->keywrd . "%")->paginate(25);
            $cari = Student::select('*')->where('nama', 'like', "%" . $request->keywrd . "%")->orwhere('jurusan', 'like', "%" . $request->keywrd . "%")->orwhere('kelas', 'like', "%" . $request->keywrd . "%")->count();
            $data = Student::select('*')->count();
            return view('admin.datasiswa', compact('siswa', 'data', 'cari'));
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
            $provinsi = Province::select('*')->orderby('provinsi')->get();
            $kota = Citie::select('*')->orderby('kota')->orderby('jk')->get();
            $jurusan = Major::all();
            $kelas = Classe::all();
            return view('admin.tambahsiswa', compact('provinsi', 'kota', 'jurusan', 'kelas'));
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
            'nis'       => 'required|size:10',
            'nama'      => 'required|min:2|max:50',
            'jk'        => 'required',
            'jurusan'   => 'required',
            'kelas'     => 'required',
            'alamat'    => 'required',
            'kota'      => 'required',
            'provinsi'  => 'required',
            'email'     => 'required|email',
            'n_wa'      => 'required',
        ];

        $messages = [
            'nis.required'      => 'Nomor Induk Siswa wajib diisi',
            'nis.size'          => 'Nomor Induk Siswa harus 10 karakter',
            'nama.required'     => 'Nama Lengkap wajib diisi',
            'nama.min'          => 'Nama lengkap minimal 2 karakter',
            'nama.max'          => 'Nama lengkap maksimal 50 karakter',
            'jk.required'       => 'Jenis Kelamin wajib diisi',
            'jurusan.required'  => 'Jurusan wajib diisi',
            'kelas.required'    => 'Kelas wajib diisi',
            'alamat.required'   => 'Alamat wajib diisi',
            'kota.required'     => 'Kota wajib diisi',
            'provinsi.required' => 'Provinsi wajib diisi',
            'email.required'    => 'Email wajib diisi',
            'email.email'       => 'Email tidak valid',
            'n_wa.required'     => 'Nomor HP wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = new User;
        $user->name = ucwords(strtolower($request->nama));
        $user->username = strtolower('siswa' . $request->email);
        $user->email = strtolower($request->email);
        $user->n_wa = strtolower($request->n_wa);
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->password = Hash::make('Smkn10Garut');
        $user->is_admin = false;
        $user->is_guru = false;
        $user->is_industri = false;
        $user->is_siswa = true;
        $regist = $user->save();

        if ($regist) {
            $iduser = DB::table('users')->where('email', $request->email)->value('id');

            $student = new Student;
            $student->nis = strtolower($request->nis);
            $student->nama = ucwords(strtolower($request->nama));
            $student->jk = ucwords(strtolower($request->jk));
            $student->jurusan = ucwords(strtolower($request->jurusan));
            $student->kelas = ucwords(strtolower($request->kelas));
            $student->alamat = ucwords(strtolower($request->alamat));
            $student->kota = ucwords(strtolower($request->kota));
            $student->provinsi = ucwords(strtolower($request->provinsi));
            $student->email = strtolower($request->email);
            $student->n_wa = strtolower($request->n_wa);
            $student->id_user = $iduser;
            $siswa = $student->save();
            if ($siswa) {
                $nia = new Score;
                $nia->nis = strtolower($request->nis);
                $save = $nia->save();
                if ($save) {
                    Session::flash('success', 'Berhasil! Penambahan data siswa berhasil');
                    return redirect()->route('kd_siswa');
                }
                Session::flash('fai', 'Register gagal! Silahkan ulangi beberapa saat lagi');
                return redirect()->back();
            } else {
                Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
                return redirect()->back();
            }
        } else {
            Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return view('admin.detailsiswa', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        if (Auth::user()->is_admin == 1) {
            $provinsi = Province::select('*')->orderby('provinsi')->get();
            $kota = Citie::select('*')->orderby('kota')->orderby('jk')->get();
            $jurusan = Major::all();
            $kelas = Classe::all();
            return view('admin.editsiswa', compact('student', 'provinsi', 'kota', 'jurusan', 'kelas'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $ceken = User::where('id', $request->ids)->first();
        if ($ceken->email == $request->email_guru && $ceken->n_wa == $request->n_wa_guru) {
            $rules = [
                'nis'       => 'required|size:10',
                'nama'      => 'required|min:2|max:50',
                'jk'        => 'required',
                'jurusan'   => 'required',
                'kelas'     => 'required',
                'alamat'    => 'required',
                'kota'      => 'required',
                'provinsi'  => 'required',
                'email'     => 'required|email',
                'n_wa'      => 'required',
            ];
        } elseif ($ceken->email == $request->email_guru) {
            $rules = [
                'nis'       => 'required|size:10',
                'nama'      => 'required|min:2|max:50',
                'jk'        => 'required',
                'jurusan'   => 'required',
                'kelas'     => 'required',
                'alamat'    => 'required',
                'kota'      => 'required',
                'provinsi'  => 'required',
                'email'     => 'required|email',
                'n_wa'      => 'required|unique:users,n_wa',
            ];
        } elseif ($ceken->n_wa == $request->n_wa_guru) {
            $rules = [
                'nis'       => 'required|size:10',
                'nama'      => 'required|min:2|max:50',
                'jk'        => 'required',
                'jurusan'   => 'required',
                'kelas'     => 'required',
                'alamat'    => 'required',
                'kota'      => 'required',
                'provinsi'  => 'required',
                'email'     => 'required|email|unique:users,email',
                'n_wa'      => 'required',
            ];
        } else {
            $rules = [
                'nis'       => 'required|size:10',
                'nama'      => 'required|min:2|max:50',
                'jk'        => 'required',
                'jurusan'   => 'required',
                'kelas'     => 'required',
                'alamat'    => 'required',
                'kota'      => 'required',
                'provinsi'  => 'required',
                'email'     => 'required|email|unique:users,email',
                'n_wa'      => 'required|unique:users,n_wa',
            ];
        }

        $messages = [
            'nis.required'      => 'Nomor Induk Siswa wajib diisi',
            'nis.size'          => 'Nomor Induk Siswa harus 10 karakter',
            'nama.required'     => 'Nama Lengkap wajib diisi',
            'nama.min'          => 'Nama lengkap minimal 2 karakter',
            'nama.max'          => 'Nama lengkap maksimal 50 karakter',
            'jk.required'       => 'Jenis Kelamin wajib diisi',
            'jurusan.required'  => 'Jurusan wajib diisi',
            'kelas.required'    => 'Kelas wajib diisi',
            'alamat.required'   => 'Alamat wajib diisi',
            'kota.required'     => 'Kota wajib diisi',
            'provinsi.required' => 'Provinsi wajib diisi',
            'email.required'    => 'Email wajib diisi',
            'email.email'       => 'Email tidak valid',
            'n_wa.required'     => 'Nomor HP wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = User::where('id', $request->ids)
            ->update([
                'name' => $request->nama,
                'email' => $request->email,
                'n_wa' => $request->n_wa,
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        if ($user) {
            $siswa = Student::where('id_user', $request->ids)
                ->update([
                    'nis'         => $request->nis,
                    'nama'         => $request->nama,
                    'jk'           => $request->jk,
                    'jurusan'      => $request->jurusan,
                    'kelas'        => $request->kelas,
                    'alamat'       => $request->alamat,
                    'kota'         => $request->kota,
                    'provinsi'     => $request->provinsi,
                    'email'        => $request->email,
                    'n_wa'         => $request->n_wa,
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            if ($siswa) {
                Session::flash('success', 'Berhasil! Prubahan data siswa berhasil');
                return redirect()->route('kd_siswa');
            }
            Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
        Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        User::destroy($student->id_user);
        Student::destroy($student->id);
        Session::flash('success', 'Berhasil! Penghapusan data guru berhasil');
        return redirect()->route('kd_siswa');
    }
}
