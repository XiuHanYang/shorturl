<?php

namespace App\Http\Middleware;

use App\Http\Controllers\UrlController;
use Closure;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\BasicController;

class CheckUrlRegex
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $url = new \App\BasicController();

        $inputUrl = $request->get('inputUrl');
        $url->checkUrlRules($inputUrl);

        return $next($request);
    }
}
