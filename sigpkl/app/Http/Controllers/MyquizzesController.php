<?php

namespace App\Http\Controllers;

use App\Models\Myquiz;
use App\Models\Answer;
use App\Models\Choice;
use App\Models\Enigma;
use App\Models\Student;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyquizzesController extends Controller
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
        // 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Myquiz  $myquiz
     * @return \Illuminate\Http\Response
     */
    public function show(Myquiz $myquiz)
    {
        //
    }

    public function hasil_kuis($id)
    {
        $kuis = Quiz::where('id', $id)->first();
        $siswa = Student::where('nis', $kuis->id)->orwhere('jurusan', $kuis->jurusan)->get();
        $haskersis = DB::table('myquizzes')
            ->join('students', 'myquizzes.nis', '=', 'students.nis')
            ->join('quizzes', 'myquizzes.id_kuis', '=', 'quizzes.id')
            ->select('students.nama', 'students.jurusan', 'students.kelas', 'quizzes.kuis', 'myquizzes.*')
            ->where('id_kuis', $id)
            ->get();
        $data = Myquiz::where('id_kuis', $id)->count();
        return view('multi.hasilkuis', compact('kuis', 'data', 'siswa', 'haskersis'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Myquiz  $myquiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Myquiz $myquiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Myquiz  $myquiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Myquiz $myquiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Myquiz  $myquiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Myquiz $myquiz)
    {
        //
    }
}
