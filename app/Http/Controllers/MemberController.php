<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Members;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Validator::make($request->all(), [
            'name'      =>  'required',
            'password'  =>  'required'
        ])->validate();

        $name = $request->get('name');
        $password = $request->get('password');

        Members::create([
            'name'      =>  $name,
            'password'  =>  Hash::make($password)
        ]);

        return response()->json(true, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, \App\BasicController $basicController)
    {
        //
        $basicController->existsMember('id', $id);

        return Members::where('id', $id)->select('id', 'name')->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, \App\BasicController $basicController)
    {
        //
        $basicController->existsMember('id', $id);

        Members::where('id', $id)->delete();
        return response()->json(true, 200);
    }
}
