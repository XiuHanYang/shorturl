<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Urls;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UrlController extends Controller
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
    public function store(Request $request, \App\BasicController $basicController)
    {
        //
        $inputUrl = $request->get('inputUrl');
        $inputMemberId = $request->get('inputMemberId');
        $inputNamespaceId = $request->get('inputNamespaceId');

        DB::enableQueryLog();

        $shortUrl = $basicController->createUrl($inputUrl, $inputMemberId, $inputNamespaceId);

        Log::debug(DB::getQueryLog());

        $results = ['success'  =>  1, 'shortUrl'  =>  $shortUrl];
        return response()->json($results, 200);
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
        $localUrl = 'http://localhost/';

        $data = DB::table('urls')
        ->leftJoin('namespaces', 'urls.namespace_id', '=', 'namespaces.id')
        ->leftJoin('members', 'namespaces.member_id', '=', 'members.id')
        ->select('urls.origin_url as originUrl', 'urls.short_url as shortUrl', 'namespaces.name as namespaceName', 'members.name as memberName')
        ->where('urls.id', $id)
        ->first();

        $data->shortUrl = $localUrl . $data->memberName . '/' . $data->namespaceName . '/' . $data->shortUrl;

        return $data;
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
        if (!Urls::where('id', $id)->count()) {
            throw new Exception('不存在的 id ！');
        }
        Urls::where('id', $id)->delete();
        return response()->json(true, 200);
    }

    public function redirect($memberName, $namespaceName, $randomParam)
    {

        DB::enableQueryLog();

        $originUrl = DB::table('urls')
        ->leftJoin('namespaces', 'urls.namespace_id', '=', 'namespaces.id')
        ->leftJoin('members', 'namespaces.member_id', '=', 'members.id')
        ->select('urls.origin_url as originUrl', 'urls.short_url as shortUrl', 'namespaces.name as namespaceName', 'members.name as memberName')
        ->where([['members.name', $memberName], ['namespaces.name', $namespaceName], ['urls.short_url', $randomParam]])
        ->first()
        ->originUrl;

        Log::debug(DB::getQueryLog());

        return redirect($originUrl);
    }
}
