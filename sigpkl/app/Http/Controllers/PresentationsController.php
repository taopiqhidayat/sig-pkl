<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Presentation;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;

class PresentationsController extends Controller
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
            'filap' => 'required|file|max: 50120',
        ];

        $messages = [
            'filap.required'    => 'File wajib diisi',
            'filap.file'        => 'Harus berupa file',
            'filap.max'        => 'File maximal 50 Mb',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $nis = Student::where('id_user', Auth::user()->id)->first();

        if ($request->hasFile('filap')) {
            # ada file
            $filenameWithExt = $request->file('filap')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('filap')->getClientOriginalExtension();
            $filenameSimpan = 'presentasi' . $nis->nis . '_' . $filename . '_' . time() . '.' . $extention;
            $path = $request->file('filap')->storeAs('presentasi', $filenameSimpan);

            $simpan = new Presentation;
            $simpan->nis = $nis->nis;
            $simpan->presentasi = $filenameSimpan;
            $save = $simpan->save();

            if ($save) {
                Session::flash('success', 'Berhasil! Mengupload presentasi berhasil');
                return redirect('/presentasi');
            }
            Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        } else {
            // tidak ada file
            $filenameSimpan = 'noimage.jpg';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Presentation  $presentation
     * @return \Illuminate\Http\Response
     */
    public function show(Presentation $presentation)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function presentasi()
    {
        if (Auth::user()->is_siswa == 1) {
            $nis = Student::where('id_user', Auth::user()->id)->first();
            $judul = Report::where('nis', $nis->nis)->first();
            $presentasi = Presentation::where('nis', $nis->nis)->first();
            $data = Presentation::where('nis', $nis->nis)->count();
            return view('siswa.presentasi', compact('presentasi', 'data', 'judul'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Presentation  $presentation
     * @return \Illuminate\Http\Response
     */
    public function edit(Presentation $presentation)
    {
        if (Auth::user()->is_siswa == 1) {
            return view('siswa.editpresentasi', compact('presentation'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Presentation  $presentation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presentation $presentation)
    {
        $rules = [
            'filap' => 'required|file|max: 50120',
        ];

        $messages = [
            'filap.required'    => 'File wajib diisi',
            'filap.file'        => 'Harus berupa file',
            'filap.max'        => 'File maximal 50 Mb',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $nis = Student::where('id_user', Auth::user()->id)->first();

        if ($request->hasFile('filap')) {
            # ada file
            $filenameWithExt = $request->file('filap')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('filap')->getClientOriginalExtension();
            $filenameSimpan = 'presentasi' . $nis->nis . '_' . $filename . '_' . time() . '.' . $extention;
            $path = $request->file('filap')->storeAs('presentasi', $filenameSimpan);

            $simpan = Presentation::where('id', $presentation->id)
                ->update([
                    'presentasi' => $filenameSimpan,
                ]);

            if ($simpan) {
                Session::flash('success', 'Berhasil! Mengupload presentasi berhasil');
                return redirect('/presentasi');
            }
            Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        } else {
            // tidak ada file
            Session::flash('fai', 'Gagal! Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
    }

    public function lihat_ppt(Presentation $presentation)
    {
        return '<embed type="application/pdf" src="/storage/presentasi/' . $presentation->presentasi . '" width="100%" height="100%"></embed>';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presentation  $presentation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presentation $presentation)
    {
        //
    }
}
