<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarbonFootprint;

class CarbonFootprintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('carbonfootprints.index');
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
		$fields = [
            'activity'=>'required',
            'activity_type'=>'required',
            'country'=>'required'
        ];
		
		//Adding validation rules based on activity_type input
		if('fuel' == $request->get('activity_type'))
		{
			$fields['fuel_type'] = 'required';
			$request->merge(['mode' => '']);
		}
		else //miles
		{
			$fields['mode'] = 'required';
			$request->merge(['fuel_type' => '']);
		}		
		
        $request->validate($fields);
		
		$response = CarbonFootprint::getCarbonFootprint($request->get('activity'), $request->get('activity_type'), $request->get('country'), $request->get('fuel_type'), $request->get('mode'));
		
		if(isset($response['carbon_footprint']))
		{
			return redirect('/carbonfootprint')->with('success', 'Carbon Footprint: '.$response['carbon_footprint']);
		}
		else
		{
			return redirect('/carbonfootprint')->with('error', $response['error']);
		}		
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
    public function destroy($id)
    {
        //
    }
}
