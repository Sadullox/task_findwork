<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */

    public function handle()
    {
        $this->info(">>>> Project install !!! ----");
        Artisan::call("migrate");
        $this->info('Migrate successfully OK');
        Artisan::call("db:seed");
        $this->info('Seeder successfully OK');
        Artisan::call("key:generate");
        $this->info('Key generate successfully OK');
        Artisan::call("passport:install");
        $this->info('Passport run comman OK');

        $this->loginImage();
        $this->image();
    }


    public function loginImage(){
        $this->output->write('          +---------------+--------------------+' . "\n", false);
        $this->output->write('          | LOGIN         | admin              |' . "\n", false);
        $this->output->write('          +---------------+--------------------+' . "\n", false);
        $this->output->write('          | PASSWORD      | admin              |' . "\n", false);
        $this->output->write('          +---------------+--------------------+' . "\n\n", false);
    }
    public function image(){
        for ($i=1; $i <= 5; $i++) { 
            usleep(250000);
            if($i==1) $this->output->write('          //////////////////////////////////////' . "\n", false);
            if($i==2) $this->output->write('          /*                                  */' . "\n", false);
            if($i==3) $this->output->write('          /*        COMMAND SUCCESSFULY       */' . "\n", false);
            if($i==4) $this->output->write('          /*                                  */' . "\n", false);
            if($i==5) $this->output->write('          //////////////////////////////////////' . "\n", false);
        }
    }
}
