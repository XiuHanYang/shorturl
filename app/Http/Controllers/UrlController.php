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
        $localUrl = 'http://localhost/';
        $inputUrl = $request->get('inputUrl');
        $inputName = urlencode($request->get('inputName'));

        $param = ['inputUrl' => $inputUrl, 'inputName' => $inputName];

        DB::enableQueryLog();

        $shortUrl = $localUrl . $basicController->createUrl($param)->short_url;

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
    public function show()
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
        if (!Urls::where('id', $id)->count()) {
            throw new Exception('不存在的 id ！');
        }
        Urls::where('id', $id)->delete();
        return response()->json(true, 200);
    }

    public function redirect()
    {

        DB::enableQueryLog();

        $randomParam = (trim($_SERVER['REQUEST_URI'], '/'));
        $originUrl = Urls::where('short_url', $randomParam)->firstOrFail()->origin_url;

        Log::debug(DB::getQueryLog());

        return redirect($originUrl);
    }
}
