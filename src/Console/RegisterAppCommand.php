<?php

namespace Wauxhall\VkAppsAuth\Console;

use Illuminate\Console\Command;

class RegisterAppCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vkapp:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registers a new vk application';

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
    }
}
