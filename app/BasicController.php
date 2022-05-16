<?php

namespace App;

use App\Http\Controllers\UrlController;
use App\Models\Urls;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Members;
use App\Models\Namespaces;
use Illuminate\Support\Str;

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

    public function createUrl($url, $memberId, $namespaceId)
    {
        $urlController = new UrlController();

        $shortUrl = '';

        $this->existsMember('id', $memberId);
        $this->existsNamespace('id', $namespaceId);

        if (Urls::where([['origin_url', $url], ['namespace_id', $namespaceId]])->count() > 0) {
            $shortUrl = Urls::where([['origin_url', $url], ['namespace_id', $namespaceId]])->first()->short_url;
            return $shortUrl;
        }

        $id = Urls::create([
            'origin_url'    =>  $url,
            'short_url'     =>  Str::random(6),
            'namespace_id'  =>  $namespaceId
        ])->id;

        return $urlController->show($id)->shortUrl;
    }

    public function checkNameOnly($columnName, $inputName)
    {
        if (Urls::where($columnName, urlencode($inputName))->count() > 0) {
            throw new Exception('已重複命名！');
        }

        return true;
    }

    public function checkNamespaceOnly($columnName, $memberId, $name)
    {
        if (Namespaces::where([[$columnName[0], $memberId], [$columnName[1], $name]])->count() > 0) {
            throw new Exception('已重複命名！');
        }

        return true;
    }

    public function existsMember($columnName, $memberId)
    {

        if (!Members::where($columnName, $memberId)->count()) {
            throw new Exception('不存在的會員編號！');
        }

        return true;
    }

    public function existsNamespace($columnName, $namespaceId)
    {

        if (!Namespaces::where($columnName, $namespaceId)->count()) {
            throw new Exception('不存在的命名編號！');
        }

        return true;
    }
}
