<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NameOnly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'name:only {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '檢查重複命名';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(\App\BasicController $basicController)
    {
        $inputName = $this->argument('name');

        if (!$basicController->checkNameOnly($inputName)) {
            $this->output->error('已重複命名');
            return -1;
        }

        $this->line('命名成功');

        return 0;
    }
}
