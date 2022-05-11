<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UrlDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'url:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '刪除過期的短網址';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
