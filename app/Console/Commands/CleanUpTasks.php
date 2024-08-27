<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use Carbon\Carbon;

class CleanUpTasks extends Command
{
    protected $signature = 'tasks:cleanup {--date_lte= : The date to delete tasks up to (YYYY-mm-dd). Defaults to 30 days ago}';
    protected $description = 'Delete backlog tasks older than a specified date';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $dateLte = $this->option('date_lte');
        if (!$dateLte) {
            $dateLte = Carbon::now()->subDays(30)->format('Y-m-d');
        }

        $dateLte = Carbon::createFromFormat('Y-m-d', $dateLte)->startOfDay();

        try {
            $deletedTasks = Task::where('status', 'backlog')
                ->where('created_at', '<', $dateLte)
                ->delete();

            Log::channel('cleanup')->info("Deleted {$deletedTasks} tasks older than {$dateLte}.");
        } catch (\Exception $e) {
            Log::channel('cleanup')->error("Error during task cleanup: " . $e->getMessage());
        }
    }
}
