<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\UrlController;

class UrlDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'url:delete {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '刪除短網址';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $urlController = new UrlController();

        $id = $this->argument('id');

        $urlController->destroy($id);

        $this->line('刪除成功');

        return 0;
    }
}
