<?php

namespace App;

use App\Models\Urls;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BasicController
{
    public function checkUrlRules($inputUrl)
    {
        $pattern = '/^(https:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        if (!preg_match($pattern, $inputUrl)) {
            throw new Exception('輸入的 URL 不符合格式！');
        }

        return true;
    }

    public function createUrl($param)
    {
        $shortUrl = '';

        if (Urls::where('origin_url', $param['inputUrl'])->count() > 0) {
            $shortUrl = Urls::where('origin_url', $param['inputUrl'])->first();
            return $shortUrl;
        }

        return Urls::create([
            'origin_url'    =>  $param['inputUrl'],
            'short_url'     =>  $param['inputName']
        ]);
    }

    public function checkNameOnly($inputName)
    {
        if (Urls::where('short_url', urlencode($inputName))->count() > 0) {
            throw new Exception('已重複命名！');
        }

        return true;
    }
}
