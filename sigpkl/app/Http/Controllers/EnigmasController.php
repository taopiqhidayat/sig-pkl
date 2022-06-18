<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Enigma;
use App\Models\Choice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;

class EnigmasController extends Controller
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

    public function store_edit_tanyaan(Request $request)
    {
        $rules = [
            'tanyaan' => 'required|min:8|max:256',
        ];

        $messages = [
            'tanyaan.required'    => 'Pertanyaan wajib diisi',
            'tanyaan.min'        => 'Pertanyaan minimal 8 karakter',
            'tanyaan.max'        => 'Pertanyaan maximal 256 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $sim = new Enigma;
        $sim->tanyaan = $request->tanyaan;
        $sim->id_kuis = $request->idk;
        $save = $sim->save();

        if ($save) {
            Session::flash('success', 'Membuat kuis berhasil, lanjutkan membuat soal');
            return redirect('/edit_kuis/' . $request->idk);
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
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
        if ($request->is2 == 1) {
            $rules = [
                'tanyaan2' => 'required|min:8|max:256',
                'pilihan2a' => 'required|min:2|max:256',
                'pilihan2b' => 'required|min:2|max:256',
            ];

            $messages = [
                'tanyaan2.required'    => 'Pertanyaan wajib diisi',
                'tanyaan2.min'        => 'Pertanyaan minimal 8 karakter',
                'tanyaan2.max'        => 'Pertanyaan maximal 256 karakter',
                'pilihan2a.required'    => 'Pertanyaan wajib diisi',
                'pilihan2a.min'        => 'Pertanyaan minimal 2 karakter',
                'pilihan2a.max'        => 'Pertanyaan maximal 256 karakter',
                'pilihan2b.required'    => 'Pertanyaan wajib diisi',
                'pilihan2b.min'        => 'Pertanyaan minimal 2 karakter',
                'pilihan2b.max'        => 'Pertanyaan maximal 256 karakter',
            ];
        } elseif ($request->is3 == 1) {
            $rules = [
                'tanyaan3' => 'required|min:8|max:256',
                'pilihan3a' => 'required|min:2|max:256',
                'pilihan3b' => 'required|min:2|max:256',
                'pilihan3c' => 'required|min:2|max:256',
            ];

            $messages = [
                'tanyaan3.required'    => 'Pertanyaan wajib diisi',
                'tanyaan3.min'        => 'Pertanyaan minimal 8 karakter',
                'tanyaan3.max'        => 'Pertanyaan maximal 256 karakter',
                'pilihan3a.required'    => 'Pertanyaan wajib diisi',
                'pilihan3a.min'        => 'Pertanyaan minimal 2 karakter',
                'pilihan3a.max'        => 'Pertanyaan maximal 256 karakter',
                'pilihan3b.required'    => 'Pertanyaan wajib diisi',
                'pilihan3b.min'        => 'Pertanyaan minimal 2 karakter',
                'pilihan3b.max'        => 'Pertanyaan maximal 256 karakter',
                'pilihan3c.required'    => 'Pertanyaan wajib diisi',
                'pilihan3c.min'        => 'Pertanyaan minimal 2 karakter',
                'pilihan3c.max'        => 'Pertanyaan maximal 256 karakter',
            ];
        } elseif ($request->is4 == 1) {
            $rules = [
                'tanyaan4' => 'required|min:8|max:256',
                'pilihan4a' => 'required|min:2|max:256',
                'pilihan4b' => 'required|min:2|max:256',
                'pilihan4c' => 'required|min:2|max:256',
                'pilihan4d' => 'required|min:2|max:256',
            ];

            $messages = [
                'tanyaan4.required'    => 'Pertanyaan wajib diisi',
                'tanyaan4.min'        => 'Pertanyaan minimal 8 karakter',
                'tanyaan4.max'        => 'Pertanyaan maximal 256 karakter',
                'pilihan4a.required'    => 'Pertanyaan wajib diisi',
                'pilihan4a.min'        => 'Pertanyaan minimal 2 karakter',
                'pilihan4a.max'        => 'Pertanyaan maximal 256 karakter',
                'pilihan4b.required'    => 'Pertanyaan wajib diisi',
                'pilihan4b.min'        => 'Pertanyaan minimal 2 karakter',
                'pilihan4b.max'        => 'Pertanyaan maximal 256 karakter',
                'pilihan4c.required'    => 'Pertanyaan wajib diisi',
                'pilihan4c.min'        => 'Pertanyaan minimal 2 karakter',
                'pilihan4c.max'        => 'Pertanyaan maximal 256 karakter',
                'pilihan4d.required'    => 'Pertanyaan wajib diisi',
                'pilihan4d.min'        => 'Pertanyaan minimal 2 karakter',
                'pilihan4d.max'        => 'Pertanyaan maximal 256 karakter',
            ];
        } elseif ($request->is5 == 1) {
            $rules = [
                'tanyaan5' => 'required|min:8|max:256',
                'pilihan5a' => 'required|min:2|max:256',
                'pilihan5b' => 'required|min:2|max:256',
                'pilihan5c' => 'required|min:2|max:256',
                'pilihan5d' => 'required|min:2|max:256',
                'pilihan5e' => 'required|min:2|max:256',
            ];

            $messages = [
                'tanyaan5.required'    => 'Pertanyaan wajib diisi',
                'tanyaan5.min'        => 'Pertanyaan minimal 8 karakter',
                'tanyaan5.max'        => 'Pertanyaan maximal 256 karakter',
                'pilihan5a.required'    => 'Pertanyaan wajib diisi',
                'pilihan5a.min'        => 'Pertanyaan minimal 2 karakter',
                'pilihan5a.max'        => 'Pertanyaan maximal 256 karakter',
                'pilihan5b.required'    => 'Pertanyaan wajib diisi',
                'pilihan5b.min'        => 'Pertanyaan minimal 2 karakter',
                'pilihan5b.max'        => 'Pertanyaan maximal 256 karakter',
                'pilihan5c.required'    => 'Pertanyaan wajib diisi',
                'pilihan5c.min'        => 'Pertanyaan minimal 2 karakter',
                'pilihan5c.max'        => 'Pertanyaan maximal 256 karakter',
                'pilihan5d.required'    => 'Pertanyaan wajib diisi',
                'pilihan5d.min'        => 'Pertanyaan minimal 2 karakter',
                'pilihan5d.max'        => 'Pertanyaan maximal 256 karakter',
                'pilihan5e.required'    => 'Pertanyaan wajib diisi',
                'pilihan5e.min'        => 'Pertanyaan minimal 2 karakter',
                'pilihan5e.max'        => 'Pertanyaan maximal 256 karakter',
            ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        if ($request->is2 == 1) {
            $sim = new Enigma;
            $sim->tanyaan = $request->tanyaan2;
            $sim->id_kuis = $request->idkini;
            $save = $sim->save();

            if ($save) {
                $id = Enigma::select('*')->orderBy('created_at', 'desc')->first();
                $sim2a = new Choice;
                $sim2a->pilihan = $request->pilihan2a;
                $sim2a->benar = $request->pilihan2abenar;
                $sim2a->id_tanyaan = $id->id;
                $save2a = $sim2a->save();

                $sim2b = new Choice;
                $sim2b->pilihan = $request->pilihan2b;
                $sim2b->benar = $request->pilihan2bbenar;
                $sim2b->id_tanyaan = $id->id;
                $save2b = $sim2b->save();

                if ($save2a && $save2b) {
                    Session::flash('success', 'Membuat kuis berhasil, lanjutkan membuat soal');
                    return redirect('/buat_kuis/' . $request->idkini);
                }
                Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
                return redirect()->back();
            }
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        } elseif ($request->is3 == 1) {
            $sim = new Enigma;
            $sim->tanyaan = $request->tanyaan3;
            $sim->id_kuis = $request->idkini;
            $save = $sim->save();

            if ($save) {
                $id = Enigma::select('*')->orderBy('created_at', 'desc')->first();
                $sim3a = new Choice;
                $sim3a->pilihan = $request->pilihan3a;
                $sim3a->benar = $request->pilihan3abenar;
                $sim3a->id_tanyaan = $id->id;
                $save3a = $sim3a->save();

                $sim3b = new Choice;
                $sim3b->pilihan = $request->pilihan3b;
                $sim3b->benar = $request->pilihan3bbenar;
                $sim3b->id_tanyaan = $id->id;
                $save3b = $sim3b->save();

                $sim3c = new Choice;
                $sim3c->pilihan = $request->pilihan3c;
                $sim3c->benar = $request->pilihan3cbenar;
                $sim3c->id_tanyaan = $id->id;
                $save3c = $sim3c->save();

                if ($save3a && $save3b && $save3c) {
                    Session::flash('success', 'Membuat kuis berhasil, lanjutkan membuat soal');
                    return redirect('/buat_kuis/' . $request->idkini);
                }
                Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
                return redirect()->back();
            }
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        } elseif ($request->is4 == 1) {
            $sim = new Enigma;
            $sim->tanyaan = $request->tanyaan4;
            $sim->id_kuis = $request->idkini;
            $save = $sim->save();

            if ($save) {
                $id = Enigma::select('*')->orderBy('created_at', 'desc')->first();
                $sim4a = new Choice;
                $sim4a->pilihan = $request->pilihan4a;
                $sim4a->benar = $request->pilihan4abenar;
                $sim4a->id_tanyaan = $id->id;
                $save4a = $sim4a->save();

                $sim4b = new Choice;
                $sim4b->pilihan = $request->pilihan4b;
                $sim4b->benar = $request->pilihan4bbenar;
                $sim4b->id_tanyaan = $id->id;
                $save4b = $sim4b->save();

                $sim4c = new Choice;
                $sim4c->pilihan = $request->pilihan4c;
                $sim4c->benar = $request->pilihan4cbenar;
                $sim4c->id_tanyaan = $id->id;
                $save4c = $sim4c->save();

                $sim4d = new Choice;
                $sim4d->pilihan = $request->pilihan4d;
                $sim4d->benar = $request->pilihan4dbenar;
                $sim4d->id_tanyaan = $id->id;
                $save4d = $sim4d->save();

                if ($save4a && $save4b && $save4c && $save4d) {
                    Session::flash('success', 'Membuat kuis berhasil, lanjutkan membuat soal');
                    return redirect('/buat_kuis/' . $request->idkini);
                }
                Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
                return redirect()->back();
            }
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        } elseif ($request->is5 == 1) {
            $sim = new Enigma;
            $sim->tanyaan = $request->tanyaan5;
            $sim->id_kuis = $request->idkini;
            $save = $sim->save();

            if ($save) {
                $id = Enigma::select('*')->orderBy('created_at', 'desc')->first();
                $sim5a = new Choice;
                $sim5a->pilihan = $request->pilihan5a;
                $sim5a->benar = $request->pilihan5abenar;
                $sim5a->id_tanyaan = $id->id;
                $save5a = $sim5a->save();

                $sim5b = new Choice;
                $sim5b->pilihan = $request->pilihan5b;
                $sim5b->benar = $request->pilihan5bbenar;
                $sim5b->id_tanyaan = $id->id;
                $save5b = $sim5b->save();

                $sim5c = new Choice;
                $sim5c->pilihan = $request->pilihan5c;
                $sim5c->benar = $request->pilihan5cbenar;
                $sim5c->id_tanyaan = $id->id;
                $save5c = $sim5c->save();

                $sim5d = new Choice;
                $sim5d->pilihan = $request->pilihan5d;
                $sim5d->benar = $request->pilihan5dbenar;
                $sim5d->id_tanyaan = $id->id;
                $save5d = $sim5d->save();

                $sim5e = new Choice;
                $sim5e->pilihan = $request->pilihan5e;
                $sim5e->benar = $request->pilihan5ebenar;
                $sim5e->id_tanyaan = $id->id;
                $save5e = $sim5e->save();

                if ($save5a && $save5b && $save5c && $save5d && $save5e) {
                    Session::flash('success', 'Membuat kuis berhasil, lanjutkan membuat soal');
                    return redirect('/buat_kuis/' . $request->idkini);
                }
                Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
                return redirect()->back();
            }
            Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enigma  $enigma
     * @return \Illuminate\Http\Response
     */
    public function show(Enigma $enigma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enigma  $enigma
     * @return \Illuminate\Http\Response
     */
    public function edit(Enigma $enigma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enigma  $enigma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enigma $enigma)
    {
        $rules = [
            'pertanyaan' => 'required|min:8|max:256',
        ];

        $messages = [
            'pertanyaan.required'    => 'Pertanyaan wajib diisi',
            'pertanyaan.min'        => 'Pertanyaan minimal 8 karakter',
            'pertanyaan.max'        => 'Pertanyaan maximal 256 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $save = Enigma::where('id', $request->id)
            ->update([
                'tanyaan' => $request->pertanyaan,
            ]);

        if ($save) {
            Session::flash('success', 'Membuat kuis berhasil, lanjutkan membuat soal');
            return redirect('/edit_kuis/' . $request->idk);
        }
        Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
        return redirect()->back();
    }

    public function update_buat_tanyaan(Request $request, Enigma $enigma)
    {
        $rules = [
            'pertanyaan' => 'required|min:8|max:256',
        ];

        $messages = [
            'pertanyaan.required'    => 'Pertanyaan wajib diisi',
            'pertanyaan.min'        => 'Pertanyaan minimal 8 karakter',
            'pertanyaan.max'        => 'Pertanyaan maximal 256 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $save = Enigma::where('id', $request->id)
            ->update([
                'tanyaan' => $request->pertanyaan,
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
     * @param  \App\Models\Enigma  $enigma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enigma $enigma, Request $request)
    {
        $chice = Choice::where('id_tanyaan', $enigma->id)->get();
        foreach ($chice as $ch) {
            Choice::destroy($ch->id);
        }
        Enigma::destroy($enigma->id);
        Session::flash('success', 'Berhasil! Penghapusan pertanyaan berhasil');
        return redirect('/edit_kuis/' . $request->idk);
    }

    public function destroy_buat(Enigma $enigma, Request $request)
    {
        $chice = Choice::where('id_tanyaan', $enigma->id)->get();
        foreach ($chice as $ch) {
            Choice::destroy($ch->id);
        }
        Enigma::destroy($enigma->id);
        Session::flash('success', 'Berhasil! Penghapusan pertanyaan berhasil');
        return redirect('/buat_kuis/' . $request->idk);
    }
}
