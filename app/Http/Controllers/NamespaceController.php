<?php

namespace App\Http\Controllers;

use App\Models\Namespaces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NamespaceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, \App\BasicController $basicController)
    {
        //
        Validator::make($request->all(), [
            'memberId'  =>  'required',
            'name'      =>  'required'
        ])->validate();

        $memberId = $request->get('memberId');
        $name = $request->get('name');

        $basicController->existsMember('id', $memberId);

        $columnName = ['member_id', 'name'];

        $basicController->checkNamespaceOnly($columnName, $memberId, $name);

        return Namespaces::create([
            'member_id' => $memberId,
            'name'      => $name
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Namespaces  $namespaces
     * @return \Illuminate\Http\Response
     */
    public function show($id, \App\BasicController $basicController)
    {
        //
        $basicController->existsNamespace('id', $id);

        return Namespaces::where('id', $id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Namespaces  $namespaces
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, \App\BasicController $basicController)
    {
        //
        $basicController->existsNamespace('id', $id);

        Namespaces::where('id', $id)->delete();
        return response()->json(true, 200);
    }
}
