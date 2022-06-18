<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Industrie;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Province;
use App\Models\Citie;
use App\Models\Classe;
use App\Models\Major;
use App\Models\School;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Session;
use Carbon;

class UsersControler extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profil()
    {
        if (Auth::user()->is_admin == 1) {
            $sch = School::where('id', 1)->first();
            $user = User::where('id', Auth::user()->id)->first();
            return view('profil', compact('user', 'sch'));
        }
        if (Auth::user()->is_guru == 1) {
            $user = User::where('id', Auth::user()->id)->first();
            $guru = Teacher::where('id_user', Auth::user()->id)->first();
            return view('profil', compact('guru', 'user'));
        }
        if (Auth::user()->is_industri == 1) {
            $user = User::where('id', Auth::user()->id)->first();
            $indu = Industrie::where('id_user', Auth::user()->id)->first();
            return view('profil', compact('indu', 'user'));
        }
        if (Auth::user()->is_siswa == 1) {
            $user = User::where('id', Auth::user()->id)->first();
            $siswa = Student::where('id_user', Auth::user()->id)->first();
            return view('profil', compact('siswa', 'user'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_profil()
    {
        if (Auth::user()->is_admin == 1) {
            $sch = School::where('id', 1)->first();
            $user = User::where('id', Auth::user()->id)->first();
            return view('editprofil', compact('user', 'sch'));
        }
        if (Auth::user()->is_guru == 1) {
            $provinsi = Province::select('*')->orderby('provinsi')->get();
            $kota = Citie::select('*')->orderby('kota')->orderby('jk')->get();
            $jurusan = Major::all();
            $user = User::where('id', Auth::user()->id)->first();
            $guru = Teacher::where('id_user', Auth::user()->id)->first();
            return view('editprofil', compact('guru', 'user', 'provinsi', 'kota', 'jurusan'));
        }
        if (Auth::user()->is_industri == 1) {
            $provinsi = Province::select('*')->orderby('provinsi')->get();
            $kota = Citie::select('*')->orderby('kota')->orderby('jk')->get();
            $user = User::where('id', Auth::user()->id)->first();
            $jurusan = Major::all();
            $indu = Industrie::where('id_user', Auth::user()->id)->first();
            return view('editprofil', compact('indu', 'user', 'provinsi', 'kota', 'jurusan'));
        }
        if (Auth::user()->is_siswa == 1) {
            $provinsi = Province::select('*')->orderby('provinsi')->get();
            $kota = Citie::select('*')->orderby('kota')->orderby('jk')->get();
            $jurusan = Major::all();
            $kelas = Classe::all();
            $user = User::where('id', Auth::user()->id)->first();
            $siswa = Student::where('id_user', Auth::user()->id)->first();
            return view('editprofil', compact('siswa', 'user', 'provinsi', 'kota', 'jurusan', 'kelas'));
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (Auth::user()->is_admin == 1) {
            $username = User::where('id', $request->id)->first();
            $foto = User::select('foto')->where('id', $request->id)->first();
            $rules = [
                'name'          => 'required|min:2|max:50',
                'email_admin'   => 'required|email',
                'n_wa_admin'    => 'required',
                'foto'          => 'image|nullable|max:7168',
                'dft_mulai'     => 'required|date',
                'dft_sampai'    => 'required|date',
                'clk_mulai'     => 'required|date',
                'clk_sampai'    => 'required|date',
                'pkl_mulai'     => 'required|date',
                'pkl_sampai'    => 'required|date',
                'lap_mulai'     => 'required|date',
                'lap_sampai'    => 'required|date',
                'uji_mulai'     => 'required|date',
                'uji_sampai'    => 'required|date',
            ];

            $messages = [
                'name.required'         => 'Nama Lengkap wajib diisi',
                'name.min'              => 'Nama lengkap minimal 2 karakter',
                'name.max'              => 'Nama lengkap maksimal 50 karakter',
                'email_admin.required'  => 'Email wajib diisi',
                'email_admin.email'     => 'Email tidak valid',
                'n_wa_admin.required'   => 'Nomor HP wajib diisi',
                'foto.image'            => 'File harus berupa gambar',
                'foto.max'              => 'File tidak lebih dari 7 Mb',
                'dft_mulai.required'    => 'Mulai Pendaftaran wajib diisi',
                'dft_sampai.required'   => 'Akhir Pendaftaran wajib diisi',
                'clk_mulai.required'    => 'Mulai Pencarian/Penempatan Lokasi wajib diisi',
                'clk_sampai.required'   => 'Akhir Pencarian/Penempatan Lokasi wajib diisi',
                'pkl_mulai.required'    => 'Mulai PKL wajib diisi',
                'pkl_sampai.required'   => 'Akhir PKL wajib diisi',
                'lap_mulai.required'    => 'Mulai Pembuatan/Bimbingan Laporan wajib diisi',
                'lap_sampai.required'   => 'Akhir Pembuatan/Bimbingan Laporan wajib diisi',
                'uji_mulai.required'    => 'Mulai Pengujian wajib diisi',
                'uji_sampai.required'   => 'Akhir Pengujian wajib diisi',
                'dft_mulai.date'        => 'Data harus berupa tanggal',
                'dft_sampai.date'       => 'Data harus berupa tanggal',
                'clk_mulai.date'        => 'Data harus berupa tanggal',
                'clk_sampai.date'       => 'Data harus berupa tanggal',
                'pkl_mulai.date'        => 'Data harus berupa tanggal',
                'pkl_sampai.date'       => 'Data harus berupa tanggal',
                'lap_mulai.date'        => 'Data harus berupa tanggal',
                'lap_sampai.date'       => 'Data harus berupa tanggal',
                'uji_mulai.date'        => 'Data harus berupa tanggal',
                'uji_sampai.date'       => 'Data harus berupa tanggal',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            if ($request->hasFile('foto')) {
                # ada file
                $filenameWithExt = $request->file('foto')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extention = $request->file('foto')->getClientOriginalExtension();
                $filenameSimpan = 'profil' . $username->username . '_' . $filename . '_' . time() . '.' . $extention;
                if ($foto != null) {
                    $path = Storage::delete($foto);
                }
                $path = $request->file('foto')->storeAs('profil', $filenameSimpan);

                $user = User::where('id', $request->id)
                    ->update([
                        'name'  => $request->name,
                        'email' => $request->email_admin,
                        'n_wa'  => $request->n_wa_admin,
                        'foto'  => $filenameSimpan,
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
                if ($user) {
                    $sch = School::where('id', 1)
                        ->update([
                            'dft_mulai'     => $request->dft_mulai,
                            'dft_sampai'    => $request->dft_sampai,
                            'clk_mulai'     => $request->clk_mulai,
                            'clk_sampai'    => $request->clk_sampai,
                            'pkl_mulai'     => $request->pkl_mulai,
                            'pkl_sampai'    => $request->pkl_sampai,
                            'lap_mulai'     => $request->lap_mulai,
                            'lap_sampai'    => $request->lap_sampai,
                            'uji_mulai'     => $request->uji_mulai,
                            'uji_sampai'    => $request->uji_sampai,
                            'updated_at' => \Carbon\Carbon::now(),
                        ]);
                    if ($sch) {
                        return redirect('/profil/' . $request->id)->with('success', 'Profil berhasil diubah');
                    }
                    return redirect()->back()->with('fai', 'Profil gagal diubah');
                }
                return redirect()->back()->with('fai', 'Profil gagal diubah');
            } else {
                // tidak ada file
                $user = User::where('id', $request->id)
                    ->update([
                        'name'  => $request->name,
                        'email' => $request->email_admin,
                        'n_wa'  => $request->n_wa_admin,
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
                if ($user) {
                    $sch = School::where('id', 1)
                        ->update([
                            'dft_mulai'     => $request->dft_mulai,
                            'dft_sampai'    => $request->dft_sampai,
                            'clk_mulai'     => $request->clk_mulai,
                            'clk_sampai'    => $request->clk_sampai,
                            'pkl_mulai'     => $request->pkl_mulai,
                            'pkl_sampai'    => $request->pkl_sampai,
                            'lap_mulai'     => $request->lap_mulai,
                            'lap_sampai'    => $request->lap_sampai,
                            'uji_mulai'     => $request->uji_mulai,
                            'uji_sampai'    => $request->uji_sampai,
                            'updated_at' => \Carbon\Carbon::now(),
                        ]);
                    if ($sch) {
                        return redirect('/profil/' . $request->id)->with('success', 'Profil berhasil diubah');
                    }
                    return redirect()->back()->with('fai', 'Profil gagal diubah');
                }
                return redirect()->back()->with('fai', 'Profil gagal diubah');
            }
        } elseif (Auth::user()->is_guru == 1) {
            $n_induk = Teacher::where('id_user', $request->id)->first();
            $foto = User::select('foto')->where('id', $request->id)->first();
            $rules = [
                'nama_guru'         => 'required|min:2|max:50',
                'jk_guru'           => 'required',
                'jurusan_guru'      => 'required',
                'alamat_guru'       => 'required',
                'kota_guru'         => 'required',
                'provinsi_guru'     => 'required',
                'email_guru'        => 'required|email',
                'n_wa_guru'         => 'required',
                'latguru'           => 'required',
                'longguru'          => 'required',
                'foto'              => 'image|nullable|max:7168',
            ];

            $messages = [
                'nama_guru.required'        => 'Nama Lengkap wajib diisi',
                'nama_guru.min'             => 'Nama lengkap minimal 2 karakter',
                'nama_guru.max'             => 'Nama lengkap maksimal 50 karakter',
                'jk_guru.required'          => 'Jenis Kelamin wajib diisi',
                'jurusan_guru.required'     => 'Jurusan wajib diisi',
                'kelas_guru.required'       => 'Kelas wajib diisi',
                'alamat_guru.required'      => 'Alamat wajib diisi',
                'kota_guru.required'        => 'Kota wajib diisi',
                'provinsi_guru.required'    => 'Provinsi wajib diisi',
                'email_guru.required'       => 'Email wajib diisi',
                'email_guru.email'          => 'Email tidak valid',
                'n_wa_guru.required'        => 'Nomor HP wajib diisi',
                'latguru.required'          => 'Latitude wajib diisi',
                'longguru.required'         => 'Longitude wajib diisi',
                'foto.image'                => 'File harus berupa gambar',
                'foto.max'                  => 'File tidak lebih dari 7 Mb',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            if ($request->hasFile('foto')) {
                # ada file
                $filenameWithExt = $request->file('foto')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extention = $request->file('foto')->getClientOriginalExtension();
                $filenameSimpan = 'profil' . $n_induk->n_induk . '_' . $filename . '_' . time() . '.' . $extention;
                if ($foto != null) {
                    $path = Storage::delete($foto);
                }
                $path = $request->file('foto')->storeAs('profil', $filenameSimpan);
                $user2 = User::where('id', $request->id)
                    ->update([
                        'name' => $request->nama_guru,
                        'email' => $request->email_guru,
                        'n_wa' => $request->n_wa_guru,
                        'foto' => $filenameSimpan,
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
                if ($user2) {
                    $guru = Teacher::where('id_user', $request->id)
                        ->update([
                            'nama'         => $request->nama_guru,
                            'jk'           => $request->jk_guru,
                            'jurusan'      => $request->jurusan_guru,
                            'alamat'       => $request->alamat_guru,
                            'kota'         => $request->kota_guru,
                            'provinsi'     => $request->provinsi_guru,
                            'email'        => $request->email_guru,
                            'n_wa'         => $request->n_wa_guru,
                            'latitude'     => $request->latguru,
                            'longitude'    => $request->longguru,
                            'updated_at' => \Carbon\Carbon::now(),
                        ]);
                    if ($guru) {
                        return redirect('/profil/' . $request->id)->with('success', 'Profil berhasil diubah');
                    }
                    return redirect()->back()->with('fai', 'Profil gagal diubah');
                }
                return redirect()->back()->with('fai', 'Profil gagal diubah');
            } else {
                // tidak ada file
                $user2 = User::where('id', $request->id)
                    ->update([
                        'name' => $request->nama_guru,
                        'email' => $request->email_guru,
                        'n_wa' => $request->n_wa_guru,
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
                if ($user2) {
                    $guru = Teacher::where('id_user', $request->id)
                        ->update([
                            'nama'         => $request->nama_guru,
                            'jk'           => $request->jk_guru,
                            'jurusan'      => $request->jurusan_guru,
                            'alamat'       => $request->alamat_guru,
                            'kota'         => $request->kota_guru,
                            'provinsi'     => $request->provinsi_guru,
                            'email'        => $request->email_guru,
                            'n_wa'         => $request->n_wa_guru,
                            'latitude'     => $request->latguru,
                            'longitude'    => $request->longguru,
                            'updated_at' => \Carbon\Carbon::now(),
                        ]);
                    if ($guru) {
                        return redirect('/profil/' . $request->id)->with('success', 'Profil berhasil diubah');
                    }
                    return redirect()->back()->with('fai', 'Profil gagal diubah');
                }
                return redirect()->back()->with('fai', 'Profil gagal diubah');
            }
        } elseif (Auth::user()->is_industri == 1) {
            $username = User::where('id', $request->id)->first();
            $foto = User::select('foto')->where('id', $request->id)->first();
            $rules = [
                'nama_indu'         => 'required|min:2|max:50',
                'nama_ketua'         => 'required|min:2|max:50',
                'ni_ketua'         => 'nullable|min:2|max:50',
                'bidang'            => 'required',
                'terjur1'              => 'nullable',
                'terjur2'              => 'nullable',
                'terjur3'              => 'nullable',
                'terjur4'              => 'nullable',
                'terjur5'              => 'nullable',
                'alamat_indu'       => 'required',
                'kota_indu'         => 'required',
                'provinsi_indu'     => 'required',
                'email_indu'        => 'required|email',
                'n_wa_indu'         => 'required',
                'latitude'          => 'required',
                'longitude'         => 'required',
                'foto'              => 'image|nullable|max:7168',
            ];

            $messages = [
                'nama_indu.required'        => 'Nama Perusahaan/Industri/Instansi wajib diisi',
                'nama_indu.min'             => 'Nama Perusahaan/Industri/Instansi minimal 2 karakter',
                'nama_indu.max'             => 'Nama Perusahaan/Industri/Instansi maksimal 50 karakter',
                'nama_ketua.required'       => 'Nama Pimpinan wajib diisi',
                'nama_ketua.min'            => 'Nama Pimpinan minimal 2 karakter',
                'nama_ketua.max'            => 'Nama Pimpinan maksimal 50 karakter',
                'nama_ketua.min'            => 'NIP Pimpinan minimal 10 karakter',
                'nama_ketua.max'            => 'NIP Pimpinan maksimal 18 karakter',
                'bidang.required'           => 'Bidang wajib diisi',
                'alamat_indu.required'      => 'Alamat wajib diisi',
                'kota_indu.required'        => 'Kota wajib diisi',
                'provinsi_indu.required'    => 'Provinsi wajib diisi',
                'email_indu.required'       => 'Email wajib diisi',
                'email_indu.email'          => 'Email tidak valid',
                'n_wa_indu.required'        => 'Nomor HP wajib diisi',
                'latitude.required'         => 'Latitude wajib diisi',
                'longitude.required'        => 'Longitude wajib diisi',
                'foto.image'                => 'File harus berupa gambar',
                'foto.max'                  => 'File tidak lebih dari 7 Mb',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            if ($request->hasFile('foto')) {
                # ada file
                $filenameWithExt = $request->file('foto')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extention = $request->file('foto')->getClientOriginalExtension();
                $filenameSimpan = 'profil' . $username->username . '_' . $filename . '_' . time() . '.' . $extention;
                if ($foto != null) {
                    $path = Storage::delete($foto);
                }
                $path = $request->file('foto')->storeAs('profil', $filenameSimpan);
                $user3 = User::where('id', $request->id)
                    ->update([
                        'name' => $request->nama_indu,
                        'email' => $request->email_indu,
                        'n_wa' => $request->n_wa_indu,
                        'foto' => $filenameSimpan,
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
                if ($user3) {

                    $mj = app('App\Http\Controllers\Auth\UsersControler')->getmj($request->terjur1, $request->terjur2, $request->terjur3, $request->terjur4, $request->terjur5, $request->mj[1], $request->mj[2], $request->mj[3], $request->mj[4], $request->mj[5]);
                    $indu = Industrie::where('id_user', $request->id)
                        ->update([
                            'nama'         => $request->nama_indu,
                            'bidang'       => $request->bidang,
                            'menerima_jurusan'       => $mj,
                            'alamat'       => $request->alamat_indu,
                            'kota'         => $request->kota_indu,
                            'provinsi'     => $request->provinsi_indu,
                            'email'        => $request->email_indu,
                            'n_wa'         => $request->n_wa_indu,
                            'latitude'     => $request->latitude,
                            'longitude'    => $request->longitude,
                            'nama_ketua'    => $request->ketua,
                            'ni_ketua'    => $request->ni_ketua,
                            'updated_at' => \Carbon\Carbon::now(),
                        ]);
                    if ($indu) {
                        return redirect('/profil/' . $request->id)->with('success', 'Profil berhasil diubah');
                    }
                    return redirect()->back()->with('fai', 'Profil gagal diubah');
                }
                return redirect()->back()->with('fai', 'Profil gagal diubah');
            } else {
                // tidak ada file
                $user3 = User::where('id', $request->id)
                    ->update([
                        'name' => $request->nama_indu,
                        'email' => $request->email_indu,
                        'n_wa' => $request->n_wa_indu,
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
                if ($user3) {

                    $mj = app('App\Http\Controllers\Auth\RegisterControler')->getmj($request->terjur1, $request->terjur2, $request->terjur3, $request->terjur4, $request->terjur5, $request->mj[1], $request->mj[2], $request->mj[3], $request->mj[4], $request->mj[5]);
                    $indu = Industrie::where('id_user', $request->id)
                        ->update([
                            'nama'         => $request->nama_indu,
                            'bidang'       => $request->bidang,
                            'menerima_jurusan'       => $mj,
                            'alamat'       => $request->alamat_indu,
                            'kota'         => $request->kota_indu,
                            'provinsi'     => $request->provinsi_indu,
                            'email'        => $request->email_indu,
                            'n_wa'         => $request->n_wa_indu,
                            'latitude'     => $request->latitude,
                            'longitude'    => $request->longitude,
                            'nama_ketua'    => $request->ketua,
                            'ni_ketua'    => $request->ni_ketua,
                            'updated_at' => \Carbon\Carbon::now(),
                        ]);
                    if ($indu) {
                        return redirect('/profil/' . $request->id)->with('success', 'Profil berhasil diubah');
                    }
                    return redirect()->back()->with('fai', 'Profil gagal diubah');
                }
                return redirect()->back()->with('fai', 'Profil gagal diubah');
            }
        } elseif (Auth::user()->is_siswa == 1) {
            $nis = Student::where('id_user', $request->id)->first();
            $foto = User::select('foto')->where('id', $request->id)->first();
            $rules = [
                'nama'              => 'required|min:2|max:50',
                'jk'                => 'required',
                'jurusan'           => 'required',
                'kelas'             => 'required',
                'alamat'            => 'required',
                'kota'              => 'required',
                'provinsi'          => 'required',
                'email'             => 'required|email',
                'n_wa'              => 'required',
                'latsiswa'          => 'required',
                'longsiswa'         => 'required',
                'foto'              => 'image|nullable|max:7168',
            ];

            $messages = [
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
                'n_wa.required'         => 'Nomor HP wajib diisi',
                'latsiswa.required'         => 'Latitude wajib diisi',
                'longsiswa.required'        => 'Longitude wajib diisi',
                'foto.image'            => 'File harus berupa gambar',
                'foto.max'              => 'File tidak lebih dari 7 Mb',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            if ($request->hasFile('foto')) {
                # ada file
                $filenameWithExt = $request->file('foto')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extention = $request->file('foto')->getClientOriginalExtension();
                $filenameSimpan = 'profil' . $nis->nis . '_' . $filename . '_' . time() . '.' . $extention;
                if ($foto != null) {
                    $path = Storage::delete($foto);
                }
                $path = $request->file('foto')->storeAs('profil', $filenameSimpan);
                $user4 = User::where('id', $request->id)
                    ->update([
                        'name' => $request->nama,
                        'email' => $request->email,
                        'n_wa' => $request->n_wa,
                        'foto' => $filenameSimpan,
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
                if ($user4) {
                    $siswa = Student::where('id_user', $request->id)
                        ->update([
                            'nama'         => $request->nama,
                            'jk'           => $request->jk,
                            'jurusan'      => $request->jurusan,
                            'kelas'        => $request->kelas,
                            'alamat'       => $request->alamat,
                            'kota'         => $request->kota,
                            'provinsi'     => $request->provinsi,
                            'email'        => $request->email,
                            'n_wa'         => $request->n_wa,
                            'latitude'     => $request->latsiswa,
                            'longitude'    => $request->longsiswa,
                            'updated_at' => \Carbon\Carbon::now(),
                        ]);
                    if ($siswa) {
                        return redirect('/profil/' . $request->id)->with('success', 'Profil berhasil diubah');
                    }
                    return redirect()->back()->with('fai', 'Profil gagal diubah');
                }
                return redirect()->back()->with('fai', 'Profil gagal diubah');
            } else {
                // tidak ada file
                $user4 = User::where('id', $request->id)
                    ->update([
                        'name' => $request->nama,
                        'email' => $request->email,
                        'n_wa' => $request->n_wa,
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
                if ($user4) {
                    $siswa = Student::where('id_user', $request->id)
                        ->update([
                            'nama'         => $request->nama,
                            'jk'           => $request->jk,
                            'jurusan'      => $request->jurusan,
                            'kelas'        => $request->kelas,
                            'alamat'       => $request->alamat,
                            'kota'         => $request->kota,
                            'provinsi'     => $request->provinsi,
                            'email'        => $request->email,
                            'n_wa'         => $request->n_wa,
                            'latitude'     => $request->latsiswa,
                            'longitude'    => $request->longsiswa,
                            'updated_at' => \Carbon\Carbon::now(),
                        ]);
                    if ($siswa) {
                        return redirect('/profil/' . $request->id)->with('success', 'Profil berhasil diubah');
                    }
                    return redirect()->back()->with('fai', 'Profil gagal diubah');
                }
                return redirect()->back()->with('fai', 'Profil gagal diubah');
            }
        }
    }

    public function getmj($tj1 = null, $tj2 = null, $tj3 = null, $tj4 = null, $tj5 = null, $mj1 = null, $mj2 = null, $mj3 = null, $mj4 = null, $mj5 = null)
    {
        if ($tj1 != null) {
            $mj = $mj1;
            if ($tj2 != null) {
                $mj = $mj1 . " , " . $mj2;
                if ($tj3 != null) {
                    $mj = $mj1 . " , " . $mj2 . " , " . $mj3;
                    if ($tj4 != null) {
                        $mj = $mj1 . " , " . $mj2 . " , " . $mj3 . " , " . $mj4;
                        if ($tj5 != null) {
                            $mj = $mj1 . " , " . $mj2 . " , " . $mj3 . " , " . $mj4 . " , " . $mj5;
                        }
                    } elseif ($tj5 != null) {
                        $mj = $mj1 . " , " . $mj2 . " , " . $mj3 . " , " . $mj5;
                    }
                } elseif ($tj4 != null) {
                    $mj = $mj1 . " , " . $mj2 . " , " . $mj4;
                    if ($tj5 != null) {
                        $mj = $mj1 . " , " . $mj2 . " , " . $mj4 . " , " . $mj5;
                    }
                } elseif ($tj5 != null) {
                    $mj = $mj1 . " , " . $mj2 . " , " . $mj5;
                }
            } elseif ($tj3 != null) {
                $mj = $mj1 . " , " . $mj3;
                if ($tj4 != null) {
                    $mj = $mj1 . " , " . $mj3 . " , " . $mj4;
                    if ($tj5 != null) {
                        $mj = $mj1 . " , " . $mj3 . " , " . $mj4 . " , " . $mj5;
                    }
                } elseif ($tj5 != null) {
                    $mj = $mj1 . " , " . $mj3 . " , " . $mj5;
                }
            } elseif ($tj4 != null) {
                $mj = $mj1 . " , " . $mj4;
                if ($tj5 != null) {
                    $mj = $mj1 . " , " . $mj4 . " , " . $mj5;
                }
            } elseif ($tj5 != null) {
                $mj = $mj1 . " , " . $mj5;
            }
        } elseif ($tj2 != null) {
            $mj = $mj2;
            if ($tj3 != null) {
                $mj = $mj2 . " , " . $mj3;
                if ($tj4 != null) {
                    $mj = $mj2 . " , " . $mj3 . " , " . $mj4;
                    if ($tj5 != null) {
                        $mj = $mj2 . " , " . $mj3 . " , " . $mj4 . " , " . $mj5;
                    }
                } elseif ($tj5 != null) {
                    $mj = $mj2 . " , " . $mj3 . " , " . $mj5;
                }
            } elseif ($tj4 != null) {
                $mj = $mj2 . " , " . $mj4;
                if ($tj5 != null) {
                    $mj = $mj2 . " , " . $mj4 . " , " . $mj5;
                }
            } elseif ($tj5 != null) {
                $mj = $mj2 . " , " . $mj5;
            }
        } elseif ($tj3 != null) {
            $mj = $mj3;
            if ($tj4 != null) {
                $mj = $mj3 . " , " . $mj4;
                if ($tj5 != null) {
                    $mj = $mj3 . " , " . $mj4 . " , " . $mj5;
                }
            } elseif ($tj5 != null) {
                $mj = $mj3 . " , " . $mj5;
            }
        } elseif ($tj4 != null) {
            $mj = $mj4;
            if ($tj5 != null) {
                $mj = $mj4 . " , " . $mj5;
            }
        } elseif ($tj5 != null) {
            $mj = $mj5;
        } else {
            $mj = null;
        }
        return $mj;
    }

    public function ganti_usswrd()
    {
        return view('auth.reset');
    }

    public function reset_username(Request $request)
    {
        $rules = [
            'usnmama'   => 'required',
            'usnmbaru'  => 'required|min:3|max:16',
        ];

        $messages = [
            'usnmama.required'  => 'Username Lama wajib diisi',
            'usnmbaru.required' => 'Username Baru wajib diisi',
            'usnmbaru.min'      => 'Username minimal 3 karakter',
            'usnmbaru.max'      => 'Username maksimal 50 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = User::where('id', Auth::user()->id)->first();
        if ($request->usnmama == $user->username) {
            $save = User::where('id', Auth::user()->id)
                ->update([
                    'username' => $request->usnmbaru,
                ]);

            if ($save) {
                return redirect('/edit_profil')->with('success', 'Username berhasil diubah');
            }
            return redirect()->back()->with('fai', 'Username gagal diubah');
        } else {
            return redirect()->back()->with('fai', 'Username Lama Anda yang dimasukkan salah');
        }
    }

    public function reset_password(Request $request)
    {
        $rules = [
            'asswrdama'   => 'required',
            'asswrdbaru'   => [
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
            'asswrdama.required'    => 'Password Lama wajib diisi',
            'asswrdbaru.required'   => 'Password Baru wajib diisi',
            'asswrdbaru.confirmed'  => 'Password Baru tidak sama dengan konfirmasi password',
            'asswrdbaru.min'        => 'Password Baru minimal 8 karakter',
            'asswrdbaru.max'        => 'Password Baru maksimal 12 karakter',
            'asswrdbaru_confirmation.required'  => 'Konfirmasi Password wajib diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = User::where('id', Auth::user()->id)->first();
        if (Hash::check($request->asswrdama, $user->password)) {
            $save = User::where('id', Auth::user()->id)
                ->update([
                    'password' => Hash::make($request->asswrdbaru),
                ]);

            if ($save) {
                return redirect('/edit_profil')->with('success', 'Password berhasil diubah');
            }
            return redirect()->back()->with('fai', 'Password gagal diubah');
        } else {
            return redirect()->back()->with('fai', 'Password Lama Anda yang dimasukkan salah');
        }
    }
}
