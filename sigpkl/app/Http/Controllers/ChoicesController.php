<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Enigma;
use App\Models\Choice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;

class ChoicesController extends Controller
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
            'pilihan' => 'required|min:2|max:256',
        ];

        $messages = [
            'pilihan.required'    => 'Pertanyaan wajib diisi',
            'pilihan.min'        => 'Pertanyaan minimal 2 karakter',
            'pilihan.max'        => 'Pertanyaan maximal 256 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $sim = new Choice;
        $sim->pilihan = $request->pilihan;
        $sim->benar = $request->pilihanbenar;
        $sim->id_tanyaan = $request->idt;
        $save = $sim->save();

        if ($save) {
            Session::flash('success', 'Membuat kuis berhasil, lanjutkan membuat soal');
            return redirect('/edit_kuis/' . $request->idk);
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function show(Choice $choice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function edit(Choice $choice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Choice $choice)
    {
        $rules = [
            'pilihan' => 'required|min:2|max:256',
        ];

        $messages = [
            'pilihan.required'    => 'Pilihan wajib diisi',
            'pilihan.min'        => 'Pilihan minimal 2 karakter',
            'pilihan.max'        => 'Pilihan maximal 256 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $save = Choice::where('id', $request->id)
            ->update([
                'pilihan' => $request->pilihan,
                'benar' => $request->pilihanbenar,
            ]);

        if ($save) {
            Session::flash('success', 'Membuat kuis berhasil, lanjutkan membuat soal');
            return redirect('/edit_kuis/' . $request->idk);
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    public function str_edit_buat_pilihan(Request $request, Choice $choice)
    {
        $rules = [
            'pilihan' => 'required|min:2|max:256',
        ];

        $messages = [
            'pilihan.required'    => 'Pilihan wajib diisi',
            'pilihan.min'        => 'Pilihan minimal 2 karakter',
            'pilihan.max'        => 'Pilihan maximal 256 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $sim = new Choice;
        $sim->pilihan = $request->pilihan;
        $sim->benar = $request->pilihanbenar;
        $sim->id_tanyaan = $request->idt;
        $save = $sim->save();
        if ($save) {
            Session::flash('success', 'Membuat kuis berhasil, lanjutkan membuat soal');
            return redirect('/buat_kuis/' . $request->idk);
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    public function update_buat_pilihan(Request $request, Choice $choice)
    {
        $rules = [
            'pilihan' => 'required|min:2|max:256',
        ];

        $messages = [
            'pilihan.required'    => 'Pilihan wajib diisi',
            'pilihan.min'        => 'Pilihan minimal 2 karakter',
            'pilihan.max'        => 'Pilihan maximal 256 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $save = Choice::where('id', $request->id)
            ->update([
                'pilihan' => $request->pilihan,
                'benar' => $request->pilihanbenar,
            ]);

        if ($save) {
            Session::flash('success', 'Membuat kuis berhasil, lanjutkan membuat soal');
            return redirect('/buat_kuis/' . $request->idk);
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Choice $choice, Request $request)
    {
        Choice::destroy($choice->id);
        Session::flash('success', 'Berhasil! Penghapusan pilihan berhasil');
        return redirect('/edit_kuis/' . $request->idk);
    }

    public function destroy_buat(Choice $choice, Request $request)
    {
        Choice::destroy($choice->id);
        Session::flash('success', 'Berhasil! Penghapusan pilihan berhasil');
        return redirect('/buat_kuis/' . $request->idk);
    }
}
