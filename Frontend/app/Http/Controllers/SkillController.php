<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $response = Curl::to('http://localhost:8080/api/skills')
        ->withHeader('Authorization: Bearer '.session('access_token'))
        ->asJson()
        ->get();
        // dd($response);

        // foreach ($response->data as $res) {
        //     # code...
        //     dump($res->skillName);
        // }
        
        return view('skills.index')->with('skills', $response->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('skills.create');
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
        // dd($request->all());
        // api post
        $response = Curl::to('http://localhost:8080/api/skills')
        ->withHeader('Authorization: Bearer '.session('access_token'))
        ->withData( array( 'skillName' => $request->name ) )
        ->asJson()
        ->post();

        return redirect(route('skills.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_skill(Request $request)
    {
        //
        // dd('test');

        $response = Curl::to('http://localhost:8080/api/skills/'.$request->id)
        ->withHeader('Authorization: Bearer '.session('access_token'))
        ->asJson()
        ->delete();


        return redirect(route('skills.index'));
    }
}
