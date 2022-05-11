<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AccountVerify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '驗證帳號是否存在';

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
