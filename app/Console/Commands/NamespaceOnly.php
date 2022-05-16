<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NamespaceOnly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'namespace:only {member_id} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '檢查會員名稱重複的命名空間';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(\App\BasicController $basicController)
    {
        $memberId = $this->argument('member_id');
        $name = $this->argument('name');

        if(!$basicController->existsMember('id', $memberId)) {
            $this->output->error('不存在的會員編號！');
            return -1;
        }

        $columnName = ['member_id', 'name'];

        if(!$basicController->checkNamespaceOnly($columnName, $memberId, $name)) {
            $this->output->error('已重複命名！');
            return -1;
        }

        $this->line('命名成功');

        return 0;

    }
}
