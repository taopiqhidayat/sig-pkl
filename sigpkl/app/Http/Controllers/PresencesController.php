<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use Symfony\Component\Translation\Dumper\YamlFileDumper;

class PresencesController extends Controller
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
    public function store(Request $request)
    {
        $rules = [
            'buke'  => 'required|image|max:7168',
        ];

        $messages = [
            'buke.required' => 'Bukti Kehadiran wajib diisi',
            'buke.image'      => 'File harus berupa gambar, foto atau screenshot kegiatan',
            'buke.max'      => 'File tidak lebih dari 7 Mb',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $siswa = Student::where('id_user', Auth::user()->id)->first();

        if ($request->hasFile('buke')) {
            # ada file
            $filenameWithExt = $request->file('buke')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('buke')->getClientOriginalExtension();
            $filenameSimpan = 'absen' . $siswa->nis . '_' . $filename . '_' . time() . '.' . $extention;
            $path = $request->file('buke')->storeAs('absen', $filenameSimpan);

            $sim = new Presence;
            $sim->nis = $siswa->nis;
            $sim->hadir = 1;
            $sim->id_kalender = $request->id;
            $sim->file = $filenameSimpan;
            $save = $sim->save();

            if ($save) {
                Session::flash('success', 'Penentuan jadwal berhasil');
                return redirect('/absensi');
            }
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Presence  $presence
     * @return \Illuminate\Http\Response
     */
    public function show(Presence $presence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Presence  $presence
     * @return \Illuminate\Http\Response
     */
    public function edit(Presence $presence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Presence  $presence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presence $presence)
    {
        $hadir = Presence::where('id', $request->id)->first();
        if ($hadir) {
            $save = Presence::where('id', $request->id)
                ->update([
                    'hadir' => $request->hadir,
                ]);

            if ($save) {
                Session::flash('success', 'Mengubah kehadiran berhasil');
                return redirect('/kehadiran/' . $request->idk);
            }
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        } else {
            $sim = new Presence;
            $sim->nis = $request->nis;
            $sim->hadir = $request->hadir;
            $sim->id_kalender = $request->idk;
            $save = $sim->save();

            if ($save) {
                Session::flash('success', 'Mengubah kehadiran berhasil');
                return redirect('/kehadiran/' . $request->idk);
            }
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presence  $presence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presence $presence)
    {
        //
    }
}
