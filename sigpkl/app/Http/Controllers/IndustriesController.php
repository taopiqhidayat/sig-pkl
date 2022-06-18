<?php

namespace App\Http\Controllers;

use App\Models\Industrie;
use App\Models\User;
use App\Models\Province;
use App\Models\Placement;
use App\Models\Citie;
use App\Models\Major;
use App\Models\Classe;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Session;

class IndustriesController extends Controller
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
            $industri = Industrie::select()->orderby('nama', 'asc')->where('nama', 'like', "%" . $request->keywrd . "%")->orwhere('bidang', 'like', "%" . $request->keywrd . "%")->paginate(25);
            $cari = Industrie::select()->orderby('nama', 'asc')->where('nama', 'like', "%" . $request->keywrd . "%")->orwhere('bidang', 'like', "%" . $request->keywrd . "%")->count();
            $data = Industrie::select('*')->count();
            return view('admin.dataindustri', compact('industri', 'data', 'cari'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    public function pilih_industri(Request $request)
    {
        if (Auth::user()->is_siswa == 1) {
            $siswa = Student::where('id_user', Auth::user()->id)->first();
            $diterima = Placement::where('nis', $siswa->nis)->first();
            $terima = DB::table('placements')
                ->join('industries', 'placements.id_industri', '=', 'industries.id')
                ->select('industries.nama', 'industries.bidang', 'industries.alamat')
                ->where('placements.nis', $siswa->nis)
                ->first();
            $industri = Industrie::select('*')
                ->where('menerima_jurusan', '=', $siswa->jurusan)
                ->orwhere('menerima_jurusan', '=', null)
                ->where('nama', 'like', "%" . $request->keywrd . "%")
                ->orwhere('bidang', 'like', "%" . $request->keywrd . "%")
                ->orderby('nama', 'asc')
                ->get();
            $data = Industrie::select('*')
                ->where('menerima_jurusan', '=', $siswa->jurusan)
                ->orwhere('menerima_jurusan', '=', null)
                ->where('nama', 'like', "%" . $request->keywrd . "%")
                ->orwhere('bidang', 'like', "%" . $request->keywrd . "%")
                ->orderby('nama', 'asc')
                ->count();
            $json = json_encode(array('results' => $industri));
            return view('siswa.pilihindustri', compact('industri', 'json', 'data', 'diterima', 'terima'));
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
            return view('admin.tambahindustri', compact('provinsi', 'kota', 'jurusan', 'kelas'));
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
            'nama_indu'             => 'required|min:2|max:50',
            'nama_ketua'            => 'required|min:2|max:50',
            'ni_ketua'              => 'nullable|min:10|max:18',
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
            'n_wa_indu'             => 'required|unique:users,n_wa',
            'latitude'              => 'required',
            'longitude'             => 'required',
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
            'bidang.required'            => 'Bidang wajib diisi',
            'alamat_indu.required'       => 'Alamat wajib diisi',
            'kota_indu.required'         => 'Kota wajib diisi',
            'provinsi_indu.required'     => 'Provinsi wajib diisi',
            'email_indu.required'        => 'Email wajib diisi',
            'email_indu.email'           => 'Email tidak valid',
            'email_indu.unique'          => 'Email sudah terdaftar',
            'n_wa_indu.required'         => 'Nomor HP wajib diisi',
            'n_wa_indu.unique'           => 'Nomor HP sudah terdaftar',
            'latitude.required'          => 'Latitude wajib diisi',
            'longitude.required'         => 'Longitude wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = new User;
        $user->name = ucwords(strtolower($request->nama_indu));
        $user->username = strtolower('indu' . $request->email_indu);
        $user->email = strtolower($request->email_indu);
        $user->n_wa = strtolower($request->n_wa_indu);
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->password = Hash::make('Smkn10Garut');
        $user->is_admin = false;
        $user->is_guru = false;
        $user->is_industri = true;
        $user->is_siswa = false;
        $regist = $user->save();

        if ($regist) {
            $mj = app('App\Http\Controllers\Auth\IndustriesController')->getmj($request->terjur1, $request->terjur2, $request->terjur3, $request->terjur4, $request->terjur5, $request->mj[1], $request->mj[2], $request->mj[3], $request->mj[4], $request->mj[5]);

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
                return redirect()->route('kd_industri');
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Industrie  $industrie
     * @return \Illuminate\Http\Response
     */
    public function show(Industrie $industrie)
    {
        if (Auth::user()->is_admin == 1) {
            return view('admin.detailindustri', compact('industrie'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Industrie  $industrie
     * @return \Illuminate\Http\Response
     */
    public function edit(Industrie $industrie)
    {
        $provinsi = Province::select('*')->orderby('provinsi')->get();
        $kota = Citie::select('*')->orderby('kota')->orderby('jk')->get();
        $jurusan = Major::all();
        $kelas = Classe::all();
        return view('admin.editindustri', compact('industrie', 'provinsi', 'kota', 'jurusan', 'kelas'));
    }

    public function getjt($jurusan)
    {
        $indu = Industrie::where('id_user', Auth::user()->id)->where('menerima_jurusan', 'like', "%" . $jurusan . "%")->first();
        if ($indu != null) {
            $ada = 1;
        } else {
            $ada = 0;
        }
        return $ada;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Industrie  $industrie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Industrie $industrie)
    {
        $ceken = User::where('id', $request->idi)->first();
        if ($ceken->email == $request->email_indu && $ceken->n_wa == $request->n_wa_indu) {
            $rules = [
                'nama_indu'             => 'required|min:2|max:50',
                'nama_ketua'            => 'required|min:2|max:50',
                'ni_ketua'              => 'nullable|min:10|max:18',
                'terjur1'              => 'nullable',
                'terjur2'              => 'nullable',
                'terjur3'              => 'nullable',
                'terjur4'              => 'nullable',
                'terjur5'              => 'nullable',
                'bidang'                => 'required',
                'alamat_indu'           => 'required',
                'kota_indu'             => 'required',
                'provinsi_indu'         => 'required',
                'email_indu'            => 'required|email',
                'n_wa_indu'             => 'required',
                'latitude'              => 'required',
                'longitude'             => 'required',
            ];
        } elseif ($ceken->email == $request->email_indu) {
            $rules = [
                'nama_indu'             => 'required|min:2|max:50',
                'nama_ketua'            => 'required|min:2|max:50',
                'ni_ketua'              => 'nullable|min:10|max:18',
                'terjur1'              => 'nullable',
                'terjur2'              => 'nullable',
                'terjur3'              => 'nullable',
                'terjur4'              => 'nullable',
                'terjur5'              => 'nullable',
                'bidang'                => 'required',
                'alamat_indu'           => 'required',
                'kota_indu'             => 'required',
                'provinsi_indu'         => 'required',
                'email_indu'            => 'required|email',
                'n_wa_indu'             => 'required|unique:users,n_wa',
                'latitude'              => 'required',
                'longitude'             => 'required',
            ];
        } elseif ($ceken->n_wa == $request->n_wa_indu) {
            $rules = [
                'nama_indu'             => 'required|min:2|max:50',
                'nama_ketua'            => 'required|min:2|max:50',
                'ni_ketua'              => 'nullable|min:10|max:18',
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
                'n_wa_indu'             => 'required',
                'latitude'              => 'required',
                'longitude'             => 'required',
            ];
        } else {
            $rules = [
                'nama_indu'             => 'required|min:2|max:50',
                'nama_ketua'            => 'required|min:2|max:50',
                'ni_ketua'              => 'nullable|min:10|max:18',
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
                'n_wa_indu'             => 'required|unique:users,n_wa',
                'latitude'              => 'required',
                'longitude'             => 'required',
            ];
        }

        $messages = [
            'nama_indu.required'         => 'Nama Perusahaan/Industri/Instansi wajib diisi',
            'nama_indu.min'              => 'Nama Perusahaan/Industri/Instansi minimal 2 karakter',
            'nama_indu.max'              => 'Nama Perusahaan/Industri/Instansi maksimal 50 karakter',
            'nama_ketua.required'        => 'Nama Pimpinan wajib diisi',
            'nama_ketua.min'             => 'Nama Pimpinan minimal 2 karakter',
            'nama_ketua.max'             => 'Nama Pimpinan maksimal 50 karakter',
            'ni_ketua.min'               => 'NIP Pimpinan minimal 10 karakter',
            'ni_ketua.max'               => 'NIP Pimpinan maksimal 18 karakter',
            'bidang.required'            => 'Bidang wajib diisi',
            'alamat_indu.required'       => 'Alamat wajib diisi',
            'kota_indu.required'         => 'Kota wajib diisi',
            'provinsi_indu.required'     => 'Provinsi wajib diisi',
            'email_indu.required'        => 'Email wajib diisi',
            'email_indu.email'           => 'Email tidak valid',
            'email_indu.unique'          => 'Email sudah terdaftar',
            'n_wa_indu.required'         => 'Nomor HP wajib diisi',
            'n_wa_indu.unique'           => 'Nomor HP sudah terdaftar',
            'latitude.required'          => 'Latitude wajib diisi',
            'longitude.required'         => 'Longitude wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = User::where('id', $request->idi)
            ->update([
                'name' => $request->nama_indu,
                'email' => $request->email_indu,
                'n_wa' => $request->n_wa_indu,
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        if ($user) {
            $mj = app('App\Http\Controllers\Auth\IndustriesController')->getmj($request->terjur1, $request->terjur2, $request->terjur3, $request->terjur4, $request->terjur5, $request->mj[1], $request->mj[2], $request->mj[3], $request->mj[4], $request->mj[5]);

            $iduser = DB::table('users')->where('email', $request->email_indu)->value('id');

            $industrie = Industrie::where('id_user', $request->idi)
                ->update([
                    'nama' => ucwords(strtolower($request->nama_indu)),
                    'bidang' => ucwords(strtolower($request->bidang)),
                    'menerima_jurusan' => ucwords(strtolower($mj)),
                    'alamat' => ucwords(strtolower($request->alamat_indu)),
                    'kota' => ucwords(strtolower($request->kota_indu)),
                    'provinsi' => ucwords(strtolower($request->provinsi_indu)),
                    'email' => strtolower($request->email_indu),
                    'n_wa' => strtolower($request->n_wa_indu),
                    'latitude' => strtolower($request->latitude),
                    'longitude' => strtolower($request->longitude),
                    'ketua' => ucwords(strtolower($request->nama_ketua)),
                    'ni_ketua' => strtolower($request->ni_ketua),
                ]);

            if ($industrie) {
                Session::flash('success', 'Register berhasil! Silahkan login untuk mengakses data');
                return redirect()->route('kd_industri');
            } else {
                Session::flash('fai', 'Register gagal! Silahkan ulangi beberapa saat lagi');
                return redirect()->back();
            }
        }
        Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Industrie  $industrie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Industrie $industrie)
    {
        User::destroy($industrie->id_user);
        Industrie::destroy($industrie->id);
        Session::flash('success', 'Berhasil! Penghapusan data guru berhasil');
        return redirect()->route('kd_industri');
    }
}
