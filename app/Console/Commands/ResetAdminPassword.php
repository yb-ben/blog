<?php

namespace App\Console\Commands;

use App\Model\Admin;
use Illuminate\Console\Command;

class ResetAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:pwd {pwd=123456}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the admin\'s password.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //

        Admin::where('id', 1)
            ->update(['pwd' =>
                password_hash($this->argument('pwd'),PASSWORD_DEFAULT)
            ]);
        $this->info('success!');
    }
}
