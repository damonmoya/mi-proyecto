<?php

namespace App\Console;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            Log::channel('records')->debug("Eliminando usuarios borrados...");
            $deleted_users = User::onlyTrashed()->get();
            foreach ($deleted_users as $user){
                $msg = 'Usuario borrado "'.$user->name.'" está siendo eliminado...';
                Log::channel('records')->debug($msg);
                $user->forceDelete();
            }
            Log::channel('records')->debug("Eliminando empresas borradas...");
            $deleted_companies = Company::onlyTrashed()->get();
            foreach ($deleted_companies as $company){
                $msg = 'Empresa borrada "'.$company->name.'" está siendo eliminada...';
                Log::channel('records')->debug($msg);
                $company->forceDelete();
            }
            Log::channel('records')->debug("Eliminando departamentos borrados...");
            $deleted_departments = Department::onlyTrashed()->get();
            foreach ($deleted_departments as $department){
                $msg = 'Departamento borrado "'.$department->name.'" está siendo eliminado...';
                Log::channel('records')->debug($msg);
                $department->forceDelete();
            }

            $users = User::all()->count();
            $companies = Company::all()->count();
            $departments = Department::all()->count();
            Log::channel('records')->debug("Usuarios registrados: {$users}");
            Log::channel('records')->debug("Empresas registradas: {$companies}");
            Log::channel('records')->debug("Departamentos registrados: {$departments}");
        })->daily()->fridays();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
