<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Urls;

class UrlRules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'url:rules {url} {--database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '檢查原網址格式';

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

        $this->line('URL 驗證成功');

        $database = $this->option('database');

        if ($database) {
            if (Urls::where('origin_url', $inputUrl)->count() > 0) {
                $this->line('已有這筆紀錄');
                return 0;
            }
            $this->line('沒有找到紀錄');
            return 0;
        }

        return 0;
    }
}
