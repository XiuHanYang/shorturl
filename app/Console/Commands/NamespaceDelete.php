<?php

namespace App\Console\Commands;

use App\Http\Controllers\NamespaceController;
use Illuminate\Console\Command;

class NamespaceDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'namespace:delete {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '刪除命名空間';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(\App\BasicController $basicController)
    {

        $namespaceController = new NamespaceController();

        $id = $this->argument('id');

        $namespaceController->destroy($id, $basicController);

        $this->line('刪除成功');

        return 0;
    }
}
