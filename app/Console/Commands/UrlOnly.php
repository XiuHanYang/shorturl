<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Urls;
use Illuminate\Support\Str;

class UrlOnly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'url:only';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '輸入的 URL 是否已存在，無則進行 random 並顯示，有則顯示已儲存的短網址';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $local_url = 'http://localhost/';
        $input_url = 'https://www.google.com.tw/';
        $short_url = '';

        if (Urls::where('origin_url', $input_url)->count() > 0) {
            $short_url = $local_url . Urls::where('origin_url', $input_url)->first()->short_url;
            return $this->line($short_url);
        }

        $random_param = Str::random(6, $input_url);
        $short_url = $local_url . $random_param;

        return $this->line($short_url);
    }
}
