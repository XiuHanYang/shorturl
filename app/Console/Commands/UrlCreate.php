<?php

namespace App\Console\Commands;

use App\Http\Controllers\BasicController;
use App\Models\Urls;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class UrlCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'url:create {url} {--open : 是否開啟頁面}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '產生短網址';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(\App\BasicController $basicController)
    {
        $inputUrl = $this->argument('url');

        if (!$basicController->checkUrlRules($inputUrl)) {
            $this->output->error('輸入的 URL 不符合格式！');
            return -1;
        }

        $datas = $basicController->createUrl($inputUrl);

        if ($this->option('open')) {
            shell_exec("open '$inputUrl'");
        }

        $this->line('http://localhost/'.$datas->short_url);

        return -1;
    }
}
