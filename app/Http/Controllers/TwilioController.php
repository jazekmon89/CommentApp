<?php

namespace App\Http\Controllers;

use App\Twilio;
use Illuminate\Http\Request;

class TwilioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('twilio');
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
     * @param  \App\Twilio  $twilio
     * @return \Illuminate\Http\Response
     */
    public function show(Twilio $twilio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Twilio  $twilio
     * @return \Illuminate\Http\Response
     */
    public function edit(Twilio $twilio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Twilio  $twilio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Twilio $twilio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Twilio  $twilio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Twilio $twilio)
    {
        //
    }
}
