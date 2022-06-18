<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Models\Province;
use App\Models\Citie;
use App\Models\Major;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Session;

class TeachersController extends Controller
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
            $guru = Teacher::select('*')->orderby('jurusan', 'asc')->orderby('nama', 'asc')->where('nama', 'like', "%" . $request->keywrd . "%")->orwhere('jurusan', 'like', "%" . $request->keywrd . "%")->paginate(15);
            $cari = Teacher::select('*')->where('nama', 'like', "%" . $request->keywrd . "%")->orwhere('jurusan', 'like', "%" . $request->keywrd . "%")->count();
            $data = Teacher::select('*')->count();
            return view('admin.dataguru', compact('guru', 'data', 'cari'));
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
            return view('admin.tambahguru', compact('provinsi', 'kota', 'jurusan', 'kelas'));
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
            'ni'                    => 'required|min:16|max:18',
            'nama_guru'             => 'required|min:2|max:50',
            'jk_guru'               => 'required',
            'jurusan_guru'          => 'required',
            'alamat_guru'           => 'required',
            'kota_guru'             => 'required',
            'provinsi_guru'         => 'required',
            'email_guru'            => 'required|email|unique:users,email',
            'n_wa_guru'             => 'required|unique:users,n_wa',
        ];

        $messages = [
            'ni.required'           => 'Nomor Induk wajib diisi',
            'ni.min'                => 'Nomor Induk minimal 16 karakter',
            'ni.max'                => 'Nomor Induk maksimal 18 karakter',
            'nama_guru.required'         => 'Nama Lengkap wajib diisi',
            'nama_guru.min'              => 'Nama lengkap minimal 2 karakter',
            'nama_guru.max'              => 'Nama lengkap maksimal 50 karakter',
            'jk_guru.required'           => 'Jenis Kelamin wajib diisi',
            'jurusan_guru.required'      => 'Jurusan wajib diisi',
            'kelas_guru.required'        => 'Kelas wajib diisi',
            'alamat_guru.required'       => 'Alamat wajib diisi',
            'kota_guru.required'         => 'Kota wajib diisi',
            'provinsi_guru.required'     => 'Provinsi wajib diisi',
            'email_guru.required'        => 'Email wajib diisi',
            'email_guru.email'           => 'Email tidak valid',
            'email_guru.unique'          => 'Email sudah terdaftar',
            'n_wa_guru.required'         => 'Nomor HP wajib diisi',
            'n_wa_guru.unique'           => 'Nomor HP sudah terdaftar',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = new User;
        $user->name = ucwords(strtolower($request->nama_guru));
        $user->username = strtolower('guru' . $request->email_guru);
        $user->email = strtolower($request->email_guru);
        $user->n_wa = strtolower($request->n_wa_guru);
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->password = Hash::make('Smkn10Garut');
        $user->is_admin = false;
        $user->is_guru = true;
        $user->is_industri = false;
        $user->is_siswa = false;
        $regist = $user->save();

        if ($regist) {
            $iduser = DB::table('users')->where('email', $request->email_guru)->value('id');

            $tech = new Teacher;
            $tech->n_induk = strtolower($request->ni);
            $tech->nama = ucwords(strtolower($request->nama_guru));
            $tech->jk = ucwords(strtolower($request->jk_guru));
            $tech->jurusan = ucwords(strtolower($request->jurusan_guru));
            $tech->alamat = ucwords(strtolower($request->alamat_guru));
            $tech->kota = ucwords(strtolower($request->kota_guru));
            $tech->provinsi = ucwords(strtolower($request->provinsi_guru));
            $tech->email = strtolower($request->email_guru);
            $tech->n_wa = strtolower($request->n_wa_guru);
            $tech->id_user = $iduser;
            $guru = $tech->save();
            if ($guru) {
                Session::flash('success', 'Berhasil! Penambahan data guru berhasil');
                return redirect()->route('kd_guru');
            } else {
                Session::flash('fai', ['' => 'Gagal! Silahkan ulangi beberapa saat lagi']);
                return redirect()->back();
            }
        } else {
            Session::flash('fai', ['' => 'Gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        if (Auth::user()->is_admin == 1) {
            return view('admin.detailguru', compact('teacher'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        if (Auth::user()->is_admin == 1) {
            $provinsi = Province::select('*')->orderby('provinsi')->get();
            $kota = Citie::select('*')->orderby('kota')->orderby('jk')->get();
            $jurusan = Major::all();
            $kelas = Classe::all();
            return view('admin.editguru', compact('teacher', 'provinsi', 'kota', 'jurusan', 'kelas'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $ceken = User::where('id', $request->idg)->first();
        if ($ceken->email == $request->email_guru && $ceken->n_wa == $request->n_wa_guru) {
            $rules = [
                'ni'                    => 'required|min:16|max:18',
                'nama_guru'             => 'required|min:2|max:50',
                'jk_guru'               => 'required',
                'jurusan_guru'          => 'required',
                'alamat_guru'           => 'required',
                'kota_guru'             => 'required',
                'provinsi_guru'         => 'required',
                'email_guru'            => 'required|email',
                'n_wa_guru'             => 'required',
            ];
        } elseif ($ceken->email == $request->email_guru) {
            $rules = [
                'ni'                    => 'required|min:16|max:18',
                'nama_guru'             => 'required|min:2|max:50',
                'jk_guru'               => 'required',
                'jurusan_guru'          => 'required',
                'alamat_guru'           => 'required',
                'kota_guru'             => 'required',
                'provinsi_guru'         => 'required',
                'email_guru'            => 'required|email',
                'n_wa_guru'             => 'required|unique:users,n_wa',
            ];
        } elseif ($ceken->n_wa == $request->n_wa_guru) {
            $rules = [
                'ni'                    => 'required|min:16|max:18',
                'nama_guru'             => 'required|min:2|max:50',
                'jk_guru'               => 'required',
                'jurusan_guru'          => 'required',
                'alamat_guru'           => 'required',
                'kota_guru'             => 'required',
                'provinsi_guru'         => 'required',
                'email_guru'            => 'required|email|unique:users,email',
                'n_wa_guru'             => 'required',
            ];
        } else {
            $rules = [
                'ni'                    => 'required|min:16|max:18',
                'nama_guru'             => 'required|min:2|max:50',
                'jk_guru'               => 'required',
                'jurusan_guru'          => 'required',
                'alamat_guru'           => 'required',
                'kota_guru'             => 'required',
                'provinsi_guru'         => 'required',
                'email_guru'            => 'required|email|unique:users,email',
                'n_wa_guru'             => 'required|unique:users,n_wa',
            ];
        }

        $messages = [
            'ni.required'           => 'Nomor Induk wajib diisi',
            'ni.min'                => 'Nomor Induk minimal 16 karakter',
            'ni.max'                => 'Nomor Induk maksimal 18 karakter',
            'nama_guru.required'         => 'Nama Lengkap wajib diisi',
            'nama_guru.min'              => 'Nama lengkap minimal 2 karakter',
            'nama_guru.max'              => 'Nama lengkap maksimal 50 karakter',
            'jk_guru.required'           => 'Jenis Kelamin wajib diisi',
            'jurusan_guru.required'      => 'Jurusan wajib diisi',
            'kelas_guru.required'        => 'Kelas wajib diisi',
            'alamat_guru.required'       => 'Alamat wajib diisi',
            'kota_guru.required'         => 'Kota wajib diisi',
            'provinsi_guru.required'     => 'Provinsi wajib diisi',
            'email_guru.required'        => 'Email wajib diisi',
            'email_guru.email'           => 'Email tidak valid',
            'email_guru.unique'          => 'Email sudah terdaftar',
            'n_wa_guru.required'         => 'Nomor HP wajib diisi',
            'n_wa_guru.unique'           => 'Nomor HP sudah terdaftar',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = User::where('id', $request->idg)
            ->update([
                'name' => $request->nama_guru,
                'email' => $request->email_guru,
                'n_wa' => $request->n_wa_guru,
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        if ($user) {
            $guru = Teacher::where('id_user', $request->idg)
                ->update([
                    'nama'         => $request->nama_guru,
                    'jk'           => $request->jk_guru,
                    'jurusan'      => $request->jurusan_guru,
                    'alamat'       => $request->alamat_guru,
                    'kota'         => $request->kota_guru,
                    'provinsi'     => $request->provinsi_guru,
                    'email'        => $request->email_guru,
                    'n_wa'         => $request->n_wa_guru,
                    'updated_at' => \Carbon\Carbon::now(),
                ]);

            if ($guru) {
                Session::flash('success', 'Berhasil! Prubahan data guru berhasil');
                return redirect()->route('kd_guru');
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
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        User::destroy($teacher->id_user);
        Teacher::destroy($teacher->id);
        Session::flash('success', 'Berhasil! Penghapusan data guru berhasil');
        return redirect()->route('kd_guru');
    }
}
