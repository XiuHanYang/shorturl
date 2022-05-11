<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UrlCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'url:create {url} {name} {--open : 是否開啟頁面}';

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
        $inputName = urlencode($this->argument('name'));

        $param = ['inputUrl' => $inputUrl, 'inputName' => $inputName];

        if (!$basicController->checkUrlRules($param['inputUrl'])) {
            $this->output->error('輸入的 URL 不符合格式！');
            return -1;
        }

        $datas = $basicController->createUrl($param);

        if ($this->option('open')) {
            shell_exec("open '$param[inputUrl]'");
        }

        $this->line('http://localhost/' . $datas->short_url);

        return -1;
    }
}
