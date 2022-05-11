<?php

namespace App;

use App\Models\Urls;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BasicController {

    public function checkUrlRules($inputUrl)
    {
        $pattern = '/^(https:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        if (!preg_match($pattern, $inputUrl)) {
            throw new Exception('輸入的 URL 不符合格式！');
        }

        return true;
    }

    public function createUrl($inputUrl)
    {
        $shortUrl = '';
        $randomParam = '';

        if (Urls::where('origin_url', $inputUrl)->count() > 0) {
            $shortUrl = Urls::where('origin_url', $inputUrl)->first();
            return $shortUrl;
        }

        $randomParam = $this->randomParam($inputUrl);

        return Urls::create([
            'origin_url'    =>  $inputUrl,
            'short_url'     =>  $randomParam
        ]);

    }

    public function randomParam($inputUrl)
    {
        $randomParam = Str::random(6, $inputUrl);

        return $randomParam;
    }

    public function insertUrl($param)
    {
        return Urls::create([
            'origin_url'    =>  $param->inputUrl,
            'short_url'     =>  $param->randomParam
        ]);
    }

}
?>