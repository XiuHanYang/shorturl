<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AccountAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '新增帳號';

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
