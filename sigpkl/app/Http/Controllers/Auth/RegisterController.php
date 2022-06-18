<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Industrie;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Province;
use App\Models\Citie;
use App\Models\Classe;
use App\Models\Major;
use App\Models\Menu;
use App\Models\Score;
use App\Models\School;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        $sch = School::where('id', 1)->first();
        $provinsi = Province::select('*')->orderby('provinsi')->get();
        $kota = Citie::select('*')->orderby('kota')->orderby('jk')->get();
        $jurusan = Major::all();
        $kelas = Classe::all();
        $get = Menu::where('menu', "Registrasi Siswa")->first();
        $regsis = $get->aktif;
        $get = Menu::where('menu', "Registrasi Guru")->first();
        $reguru = $get->aktif;
        $get = Menu::where('menu', "Registrasi Industri")->first();
        $regind = $get->aktif;
        return view('auth.register', compact('provinsi', 'kota', 'jurusan', 'kelas', 'sch', 'regsis', 'reguru', 'regind'));
    }

    public function registrasi_admin()
    {
        $get = Menu::where('menu', "Registrasi Admin")->first();
        $res = $get->aktif;
        return view('auth.registeradmin', compact('res'));
    }

    public function regist_guru(Request $request)
    {
        // return $request->input();
        $rules = [
            'ni'                    => 'required|numeric|digits_between:16,18',
            'nama_guru'             => 'required|min:2|max:50',
            'jk_guru'               => 'required',
            'jurusan_guru'          => 'required',
            'alamat_guru'           => 'required',
            'kota_guru'             => 'required',
            'provinsi_guru'         => 'required',
            'email_guru'            => 'required|email|unique:users,email',
            'n_wa_guru'             => 'required|numeric|digits_between:11,15|unique:users,n_wa',
            'username_guru'         => 'required|unique:users,username',
            'passwordguru'          => [
                'required_with:password_confirmation',
                'min:8',
                'max:12',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised(),
            ],
        ];

        $messages = [
            'ni.required'                => 'Nomor Induk wajib diisi',
            'ni.digits_between'          => 'Nomor Induk 16 - 18 karakter',
            'ni.numeric'                 => 'Nomor Induk harus berupa angka',
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
            'n_wa_guru.numeric'          => 'Nomor HP harus berupa angka',
            'n_wa_guru.digits_between'   => 'Nomor HP 11 - 15 karakter',
            'username_guru.required'     => 'Username wajib diisi',
            'username_guru.unique'       => 'Username sudah terdaftar',
            'passwordguru.required'     => 'Password wajib diisi',
            'passwordguru.confirmed'    => 'Password tidak sama dengan konfirmasi password',
            'passwordguru.min'          => 'Password minimal 8 karakter',
            'passwordguru.max'          => 'Password maksimal 12 karakter',
            'passwordguru_confirmation.required'  => 'Konfirmasi Password wajib diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = new User;
        $user->name = ucwords(strtolower($request->nama_guru));
        $user->username = strtolower($request->username_guru);
        $user->email = strtolower($request->email_guru);
        $user->n_wa = strtolower($request->n_wa_guru);
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->password = Hash::make($request->passwordguru);
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
                Session::flash('success', 'Register berhasil! Silahkan login untuk mengakses data');
                return redirect()->route('flogin');
            } else {
                Session::flash('fai', 'Register gagal! Silahkan ulangi beberapa saat lagi');
                return redirect()->back();
            }
        } else {
            Session::flash('fai', 'Register gagal! Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
    }

    public function regist_industri(Request $request)
    {
        // return $request;
        $rules = [
            'nama_indu'             => 'required|min:2|max:50',
            'nama_ketua'            => 'required|min:2|max:50',
            'ni_ketua'              => 'nullable|numeric|min:10|max:18',
            'terjur1'              => 'nullable',
            'terjur2'              => 'nullable',
            'terjur3'              => 'nullable',
            'terjur4'              => 'nullable',
            'terjur5'              => 'nullable',
            'bidang'                => 'required',
            'alamat_indu'           => 'required',
            'kota_indu'             => 'required',
            'provinsi_indu'         => 'required',
            'email_indu'            => 'required|email|unique:users,email',
            'n_wa_indu'             => 'required|numeric|digits_between:11,15|unique:users,n_wa',
            'latitude'              => 'required',
            'longitude'             => 'required',
            'username_indu'         => 'required|unique:users,username',
            'passwordindu'          => [
                'required_with:password_confirmation',
                'min:8',
                'max:12',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised(),
            ],
        ];

        $messages = [
            'nama_indu.required'         => 'Nama Perusahaan/Industri/Instansi wajib diisi',
            'nama_indu.min'              => 'Nama Perusahaan/Industri/Instansi minimal 2 karakter',
            'nama_indu.max'              => 'Nama Perusahaan/Industri/Instansi maksimal 50 karakter',
            'nama_ketua.required'        => 'Nama Pimpinan wajib diisi',
            'nama_ketua.min'             => 'Nama Pimpinan minimal 2 karakter',
            'nama_ketua.max'             => 'Nama Pimpinan maksimal 50 karakter',
            'ni_ketua.min'               => 'NIP Pimpinan minimal 10 karakter',
            'ni_ketua.max'               => 'NIP Pimpinan maksimal 18 karakter',
            'ni_ketua.numeric'           => 'NIP Pimpinan harus berupa angka',
            'bidang.required'            => 'Bidang wajib diisi',
            'alamat_indu.required'       => 'Alamat wajib diisi',
            'kota_indu.required'         => 'Kota wajib diisi',
            'provinsi_indu.required'     => 'Provinsi wajib diisi',
            'email_indu.required'        => 'Email wajib diisi',
            'email_indu.email'           => 'Email tidak valid',
            'email_indu.unique'          => 'Email sudah terdaftar',
            'n_wa_indu.required'         => 'Nomor HP wajib diisi',
            'n_wa_indu.unique'           => 'Nomor HP sudah terdaftar',
            'n_wa_indu.numeric'          => 'Nomor HP harus berupa angka',
            'n_wa_indu.digits_between'   => 'Nomor HP 11 - 15 karakter',
            'latitude.required'          => 'Latitude wajib diisi',
            'longitude.required'         => 'Longitude wajib diisi',
            'username_indu.required'     => 'Username wajib diisi',
            'username_indu.unique'       => 'Username sudah terdaftar',
            'passwordindu.required'     => 'Password wajib diisi',
            'passwordindu.confirmed'    => 'Password tidak sama dengan konfirmasi password',
            'passwordindu.min'          => 'Password minimal 8 karakter',
            'passwordindu.max'          => 'Password maksimal 12 karakter',
            'passwordindu_confirmation.required'  => 'Konfirmasi Password wajib diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = new User;
        $user->name = ucwords(strtolower($request->nama_indu));
        $user->username = strtolower($request->username_indu);
        $user->email = strtolower($request->email_indu);
        $user->n_wa = strtolower($request->n_wa_indu);
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->password = Hash::make($request->passwordindu);
        $user->is_admin = false;
        $user->is_guru = false;
        $user->is_industri = true;
        $user->is_siswa = false;
        $regist = $user->save();

        if ($regist) {

            $mj = app('App\Http\Controllers\Auth\RegisterController')->getmj($request->terjur1, $request->terjur2, $request->terjur3, $request->terjur4, $request->terjur5, $request->mj[1], $request->mj[2], $request->mj[3], $request->mj[4], $request->mj[5]);

            $iduser = DB::table('users')->where('email', $request->email_indu)->value('id');

            $indu = new Industrie;
            $indu->nama = ucwords(strtolower($request->nama_indu));
            $indu->bidang = ucwords(strtolower($request->bidang));
            $indu->menerima_jurusan = ucwords(strtolower($mj));
            $indu->alamat = ucwords(strtolower($request->alamat_indu));
            $indu->kota = ucwords(strtolower($request->kota_indu));
            $indu->provinsi = ucwords(strtolower($request->provinsi_indu));
            $indu->email = strtolower($request->email_indu);
            $indu->n_wa = strtolower($request->n_wa_indu);
            $indu->latitude = strtolower($request->latitude);
            $indu->longitude = strtolower($request->longitude);
            $indu->ketua = ucwords(strtolower($request->nama_ketua));
            $indu->ni_ketua = strtolower($request->ni_ketua);
            $indu->id_user = $iduser;
            $industrie = $indu->save();
            if ($industrie) {
                Session::flash('success', 'Register berhasil! Silahkan login untuk mengakses data');
                return redirect()->route('flogin');
            } else {
                Session::flash('fai', 'Register gagal! Silahkan ulangi beberapa saat lagi');
                return redirect()->back();
            }
        } else {
            Session::flash('fai', 'Register gagal! Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
    }

    public function getmj($tj1 = null, $tj2 = null, $tj3 = null, $tj4 = null, $tj5 = null, $mj1 = null, $mj2 = null, $mj3 = null, $mj4 = null, $mj5 = null)
    {
        if ($tj1 != null) {
            $mj = "" . $mj1 . "";
            if ($tj2 != null) {
                $mj = "" . $mj1 . " , " . $mj2 . "";
                if ($tj3 != null) {
                    $mj = "" . $mj1 . " , " . $mj2 . " , " . $mj3 . "";
                    if ($tj4 != null) {
                        $mj = "" . $mj1 . " , " . $mj2 . " , " . $mj3 . " , " . $mj4 . "";
                        if ($tj5 != null) {
                            $mj = "" . $mj1 . " , " . $mj2 . " , " . $mj3 . " , " . $mj4 . " , " . $mj5 . "";
                        }
                    } elseif ($tj5 != null) {
                        $mj = "" . $mj1 . " , " . $mj2 . " , " . $mj3 . " , " . $mj5 . "";
                    }
                } elseif ($tj4 != null) {
                    $mj = "" . $mj1 . " , " . $mj2 . " , " . $mj4 . "";
                    if ($tj5 != null) {
                        $mj = "" . $mj1 . " , " . $mj2 . " , " . $mj4 . " , " . $mj5 . "";
                    }
                } elseif ($tj5 != null) {
                    $mj = "" . $mj1 . " , " . $mj2 . " , " . $mj5 . "";
                }
            } elseif ($tj3 != null) {
                $mj = "" . $mj1 . " , " . $mj3 . "";
                if ($tj4 != null) {
                    $mj = "" . $mj1 . " , " . $mj3 . " , " . $mj4 . "";
                    if ($tj5 != null) {
                        $mj = "" . $mj1 . " , " . $mj3 . " , " . $mj4 . " , " . $mj5 . "";
                    }
                } elseif ($tj5 != null) {
                    $mj = "" . $mj1 . " , " . $mj3 . " , " . $mj5 . "";
                }
            } elseif ($tj4 != null) {
                $mj = "" . $mj1 . " , " . $mj4 . "";
                if ($tj5 != null) {
                    $mj = "" . $mj1 . " , " . $mj4 . " , " . $mj5 . "";
                }
            } elseif ($tj5 != null) {
                $mj = "" . $mj1 . " , " . $mj5 . "";
            }
        } elseif ($tj2 != null) {
            $mj = "" . $mj2 . "";
            if ($tj3 != null) {
                $mj = "" . $mj2 . " , " . $mj3 . "";
                if ($tj4 != null) {
                    $mj = "" . $mj2 . " , " . $mj3 . " , " . $mj4 . "";
                    if ($tj5 != null) {
                        $mj = "" . $mj2 . " , " . $mj3 . " , " . $mj4 . " , " . $mj5 . "";
                    }
                } elseif ($tj5 != null) {
                    $mj = "" . $mj2 . " , " . $mj3 . " , " . $mj5 . "";
                }
            } elseif ($tj4 != null) {
                $mj = "" . $mj2 . " , " . $mj4 . "";
                if ($tj5 != null) {
                    $mj = "" . $mj2 . " , " . $mj4 . " , " . $mj5 . "";
                }
            } elseif ($tj5 != null) {
                $mj = "" . $mj2 . " , " . $mj5 . "";
            }
        } elseif ($tj3 != null) {
            $mj = "" . $mj3 . "";
            if ($tj4 != null) {
                $mj = "" . $mj3 . " , " . $mj4 . "";
                if ($tj5 != null) {
                    $mj = "" . $mj3 . " , " . $mj4 . " , " . $mj5 . "";
                }
            } elseif ($tj5 != null) {
                $mj = "" . $mj3 . " , " . $mj5 . "";
            }
        } elseif ($tj4 != null) {
            $mj = "" . $mj4 . "";
            if ($tj5 != null) {
                $mj = "" . $mj4 . " , " . $mj5 . "";
            }
        } elseif ($tj5 != null) {
            $mj = "" . $mj5 . "";
        } else {
            $mj = null;
        }
        return $mj;
    }

    public function regist_siswa(Request $request)
    {
        // return $request->input();
        $rules = [
            'nis'                   => 'required|numeric|digits:10',
            'nama'                  => 'required|min:2|max:50',
            'jk'                    => 'required',
            'jurusan'               => 'required',
            'kelas'                 => 'required',
            'alamat'                => 'required',
            'kota'                  => 'required',
            'provinsi'              => 'required',
            'email'                 => 'required|email|unique:users,email',
            'n_wa'                  => 'required|numeric|digits_between:11,15|unique:users,n_wa',
            'username'              => 'required|unique:users,username',
            'password'              => [
                'required_with:password_confirmation',
                'min:8',
                'max:12',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised(),
            ],
        ];

        $messages = [
            'nis.required'          => 'Nomor Induk Siswa wajib diisi',
            'nis.digits'              => 'Nomor Induk Siswa harus 10 karakter',
            'nis.numeric'           => 'Nomor Induk Siswa harus berupa angka',
            'nama.required'         => 'Nama Lengkap wajib diisi',
            'nama.min'              => 'Nama lengkap minimal 2 karakter',
            'nama.max'              => 'Nama lengkap maksimal 50 karakter',
            'jk.required'           => 'Jenis Kelamin wajib diisi',
            'jurusan.required'      => 'Jurusan wajib diisi',
            'kelas.required'        => 'Kelas wajib diisi',
            'alamat.required'       => 'Alamat wajib diisi',
            'kota.required'         => 'Kota wajib diisi',
            'provinsi.required'     => 'Provinsi wajib diisi',
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'email.unique'          => 'Email sudah terdaftar',
            'n_wa.required'         => 'Nomor HP wajib diisi',
            'n_wa.unique'           => 'Nomor HP sudah terdaftar',
            'n_wa.digits_between'   => 'Nomor HP 11 - 15 karakter',
            'n_wa.numeric'          => 'Nomor HP harus berupa angka',
            'username.required'     => 'Username wajib diisi',
            'username.unique'       => 'Username sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password',
            'password.min'          => 'Password minimal 8 karakter',
            'password.max'          => 'Password maksimal 12 karakter',
            'password_confirmation.required'  => 'Konfirmasi Password wajib diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = new User;
        $user->name = ucwords(strtolower($request->nama));
        $user->username = strtolower($request->username);
        $user->email = strtolower($request->email);
        $user->n_wa = strtolower($request->n_wa);
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->password = Hash::make($request->password);
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
                    Session::flash('success', 'Register berhasil! Silahkan login untuk mengakses data');
                    return redirect()->route('flogin');
                }
                Session::flash('fai', 'Register gagal! Silahkan ulangi beberapa saat lagi');
                return redirect()->back();
            } else {
                Session::flash('fai', 'Register gagal! Silahkan ulangi beberapa saat lagi');
                return redirect()->back();
            }
        } else {
            Session::flash('fai', 'Register gagal! Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
    }

    public function regist_admin(Request $request)
    {
        // return $request->input();
        $rules = [
            'name'              => 'required|min:2|max:50',
            'email_admin'       => 'required|email|unique:users,email',
            'n_wa_admin'        => 'required|numeric|digits_between:11,15|unique:users,n_wa',
            'username_admin'    => 'required|unique:users,username',
            'passwordadmin'     => [
                'required_with:password_confirmation',
                'min:8',
                'max:12',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised(),
            ],
        ];

        $messages = [
            'name.required'         => 'Nama Lengkap wajib diisi',
            'name.min'              => 'Nama lengkap minimal 2 karakter',
            'name.max'              => 'Nama lengkap maksimal 50 karakter',
            'email_admin.required'        => 'Email wajib diisi',
            'email_admin.email'           => 'Email tidak valid',
            'email_admin.unique'          => 'Email sudah terdaftar',
            'n_wa_admin.required'         => 'Nomor HP wajib diisi',
            'n_wa_admin.unique'           => 'Nomor HP sudah terdaftar',
            'n_wa_admin.numeric'          => 'Nomor HP harus berupa angka',
            'n_wa_admin.digits_between'   => 'Nomor HP 11 - 15 karakter',
            'username_admin.required'     => 'Username wajib diisi',
            'username_admin.unique'       => 'Username sudah terdaftar',
            'passwordadmin.required'     => 'Password wajib diisi',
            'passwordadmin.confirmed'    => 'Password tidak sama dengan konfirmasi password',
            'passwordadmin.min'          => 'Password minimal 8 karakter',
            'passwordadmin.max'          => 'Password maksimal 12 karakter',
            'passwordadmin_confirmation.required'  => 'Konfirmasi Password wajib diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = new User;
        $user->name = ucwords(strtolower($request->name));
        $user->username = strtolower($request->username_admin);
        $user->email = strtolower($request->email_admin);
        $user->n_wa = strtolower($request->n_wa_admin);
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->password = Hash::make($request->passwordadmin);
        $user->is_admin = true;
        $user->is_guru = false;
        $user->is_industri = false;
        $user->is_siswa = false;
        $regist = $user->save();

        if ($regist) {
            Session::flash('success', 'Register berhasil! Silahkan login untuk mengakses data');
            return redirect()->route('flogin');
        } else {
            Session::flash('fai', 'Register gagal! Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
    }

    // public function ajax(Request $request, $id)
    // {

    //     $all = new Kota;

    //     $kabta = $all->where('id_provinsi', $id)->get();

    //     return response()->json($kabta);
    // }
}
