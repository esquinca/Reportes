<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

class ResetEncxmes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:enc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para dar de baja el enlace temporal de la encuesta';

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
        $sql = DB::table('user_reportes')->where('Privilegio', '=', 'Encuestado')
        ->update(['password' => '', 'temp_pass' => '', 'shell' => '']);
        $this->info('Successfully restored survey url!');
    }
}
