<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Choice;
use App\Models\Enigma;
use App\Models\Myquiz;
use App\Models\Student;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;

class AnswersController extends Controller
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
        // return $request;
        $siswa = Student::where('id_user', Auth::user()->id)->first();
        $chch = Choice::where('id_tanyaan', $request->idt)->get();

        $jch = $request->jch;
        $jchb = $request->jchb;
        if ($jchb == 1) {
            $idrb = $request->idrb;
            $rbb = $request->rbb;

            $i = 0;
            if ($rbb == null) {
                Session::flash('fai', 'Silahkan isi terlebih dahulu');
                return redirect()->back();
            }

            $chini = Answer::where('nis', $siswa->nis)->where('id_pilihan', $idrb)->first();
            if ($chini != null) {
                $ubah1 = Answer::where('nis', $siswa->nis)->where('id_tanyaan', $request->idt)->where('dipilih', 1)->update([
                    'dipilih' => 0,
                ]);

                $ubah2 = Answer::where('nis', $siswa->nis)->where('id_pilihan', $idrb)->update([
                    'dipilih' => $rbb,
                ]);

                if ($ubah1 && $ubah2) {
                    app('App\Http\Controllers\AnswersController')->meni($siswa->nis, $request->idk);

                    if ($request->hini == $request->hakhir) {
                        $hnext = $request->hini;
                    } else {
                        $hnext = $request->hini + 1;
                    }
                    return redirect('/mengisi_kuis/' . $request->idk . '?page=' . $hnext);
                }
                Session::flash('fai', ['' => 'Silahkan ulangi beberapa saat lagi']);
                return redirect()->back();
            } else {
                $ubah1 = Answer::where('nis', $siswa->nis)->where('id_tanyaan', $request->idt)->where('dipilih', 1)->update([
                    'dipilih' => 0,
                ]);

                $sim = new Answer;
                $sim->nis = $siswa->nis;
                $sim->id_kuis = $request->idk;
                $sim->id_tanyaan = $request->idt;
                $sim->id_pilihan = $idrb;
                $sim->dipilih = $rbb;
                $save = $sim->save();

                if ($save) {
                    app('App\Http\Controllers\AnswersController')->meni($siswa->nis, $request->idk);

                    if ($request->hini == $request->hakhir) {
                        $hnext = $request->hini;
                    } else {
                        $hnext = $request->hini + 1;
                    }
                    return redirect('/mengisi_kuis/' . $request->idk . '?page=' . $hnext);
                }
                Session::flash('fai', ['' => 'Silahkan ulangi beberapa saat lagi']);
                return redirect()->back();
            }
        } elseif ($jchb > 1) {
            $rules = [
                'cbb1'  => 'nullable',
                'cbb2'  => 'nullable',
                'cbb3'  => 'nullable',
                'cbb4'  => 'nullable',
                'cbb5'  => 'nullable',
            ];

            $messages = [];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            $idcb = $request->idcb;
            $cbt = $request->cbt;

            $i1 = 0;
            $i2 = 0;
            $i3 = 0;
            $i4 = 0;
            $i5 = 0;
            if ($request->cbb1 == 1) {
                $i1 = 1;
            }
            if ($request->cbb2 == 1) {
                $i2 = 1;
            }
            if ($request->cbb3 == 1) {
                $i3 = 1;
            }
            if ($request->cbb4 == 1) {
                $i4 = 1;
            }
            if ($request->cbb5 == 1) {
                $i5 = 1;
            }
            $jcb = $i1 + $i2 + $i3 + $i4 + $i5;
            if ($jcb == 0) {
                Session::flash('fai', 'Silahkan isi terlebih dahulu');
                return redirect()->back();
            }
            if ($jcb == $jch || $jcb > $jchb) {
                Session::flash('fai', 'Anda tidak boleh memilih lebih dari yang ditentukan!');
                return redirect()->back();
            }

            $ubah1 = Answer::where('nis', $siswa->nis)->where('id_tanyaan', $request->idt)->where('dipilih', 1)->update([
                'dipilih' => 0,
            ]);
            if ($ubah1) {

                $n = 0;
                foreach ($chch as $ch) {
                    if ($idcb[$n] == $ch->id) {
                        $chini = Answer::where('nis', $siswa->nis)->where('id_pilihan', $idcb[$n])->first();
                        if ($chini != null) {
                            if (($n + 1) == 1) {
                                $ubah = Answer::where('nis', $siswa->nis)->where('id_pilihan', $idcb[$n])->update([
                                    'dipilih' => $cbt[$idcb[$n]] + $request->cbb1,
                                ]);
                            } elseif (($n + 1) == 2) {
                                $ubah = Answer::where('nis', $siswa->nis)->where('id_pilihan', $idcb[$n])->update([
                                    'dipilih' => $cbt[$idcb[$n]] + $request->cbb2,
                                ]);
                            } elseif (($n + 1) == 3) {
                                $ubah = Answer::where('nis', $siswa->nis)->where('id_pilihan', $idcb[$n])->update([
                                    'dipilih' => $cbt[$idcb[$n]] + $request->cbb3,
                                ]);
                            } elseif (($n + 1) == 4) {
                                $ubah = Answer::where('nis', $siswa->nis)->where('id_pilihan', $idcb[$n])->update([
                                    'dipilih' => $cbt[$idcb[$n]] + $request->cbb4,
                                ]);
                            } elseif (($n + 1) == 5) {
                                $ubah = Answer::where('nis', $siswa->nis)->where('id_pilihan', $idcb[$n])->update([
                                    'dipilih' => $cbt[$idcb[$n]] + $request->cbb5,
                                ]);
                            }

                            if (!$ubah) {
                                Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
                                return redirect()->back();
                            }
                        } else {
                            $sim = new Answer;
                            $sim->nis = $siswa->nis;
                            $sim->id_kuis = $request->idk;
                            $sim->id_tanyaan = $request->idt;
                            $sim->id_pilihan = $idcb[$n];
                            if (($n + 1) == 1) {
                                $sim->dipilih = $cbt[$idcb[$n]] + $request->cbb1;
                            } elseif (($n + 1) == 2) {
                                $sim->dipilih = $cbt[$idcb[$n]] + $request->cbb2;
                            } elseif (($n + 1) == 3) {
                                $sim->dipilih = $cbt[$idcb[$n]] + $request->cbb3;
                            } elseif (($n + 1) == 4) {
                                $sim->dipilih = $cbt[$idcb[$n]] + $request->cbb4;
                            } elseif (($n + 1) == 5) {
                                $sim->dipilih = $cbt[$idcb[$n]] + $request->cbb5;
                            }
                            $save = $sim->save();

                            if (!$save) {
                                Session::flash('fai', ['' => 'Silahkan ulangi beberapa saat lagi']);
                                return redirect()->back();
                            }
                        }
                    }
                    $n++;
                }
            }

            app('App\Http\Controllers\AnswersController')->meni($siswa->nis, $request->idk);

            if ($request->hini == $request->hakhir) {
                $hnext = $request->hini;
            } else {
                $hnext = $request->hini + 1;
            }
            return redirect('/mengisi_kuis/' . $request->idk . '?page=' . $hnext);
        }
    }

    public function meni($nis, $idk)
    {
        $jawab = Answer::where('nis', $nis)->where('id_kuis', $idk)->where('dipilih', 1)->get();
        $tanyaan = Enigma::where('id_kuis', $idk)->get();
        $banyaktanya = Enigma::where('id_kuis', $idk)->count();
        $nst = 100 / $banyaktanya;
        $t = 0;
        foreach ($jawab as $jwb) {
            foreach ($tanyaan as $tanya) {
                if ($tanya->id == $jwb->id_tanyaan) {
                    $chid = Choice::where('id_tanyaan', $jwb->id_tanyaan)->get();
                    $bchb = Choice::where('id_tanyaan', $jwb->id_tanyaan)->where('benar', 1)->count();
                    $b = 0;
                    foreach ($chid as $ci) {
                        if ($ci->id == $jwb->id_pilihan) {
                            $cektrue = Choice::where('id', $jwb->id_pilihan)->first();
                            if ($cektrue->benar == 1) {
                                $b = $b + 1;
                            } else {
                                $b = $b + 0;
                            }
                        }
                    }
                    if ($b == 0) {
                        $n = 0 * $nst;
                    } else {
                        $n = ($b / $bchb) * $nst;
                    }
                }
            }
            $t = $t + $n;
        }
        $cek = Myquiz::where('nis', $nis)->where('id_kuis', $idk)->first();
        if ($cek != null) {
            $ubah = Myquiz::where('nis', $nis)->where('id_kuis', $idk)
                ->update([
                    'nilai' => round($t, 2),
                ]);

            if (!$ubah) {
                Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
                return redirect()->back();
            }
        } else {
            $sim = new Myquiz;
            $sim->nis = $nis;
            $sim->id_kuis = $idk;
            $sim->nilai = round($t, 2);
            $save = $sim->save();

            if (!$save) {
                Session::flash('fai', 'Silahkan ulangi beberapa saat lagi');
                return redirect()->back();
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
