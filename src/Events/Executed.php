<?php

namespace Studio\Totem\Events;

use Carbon\Carbon;
use Studio\Totem\Task;
use Studio\Totem\Notifications\TaskCompleted;

class Executed extends BroadcastingEvent
{
    /**
     * Executed constructor.
     *
     * @param Task $task
     * @param string $started
     * @param Carbon $failedAt
     */
    public function __construct(Task $task, $started, Carbon $failedAt = null)
    {
        parent::__construct($task);

        $time_elapsed_secs = microtime(true) - $started;

        if (file_exists(storage_path($task->getMutexName()))) {
            $output = file_get_contents(storage_path($task->getMutexName()));

            $task->results()->create([
                'duration'  => $time_elapsed_secs * 1000,
                'result'    => $output,
                'failed_at' => $failedAt,
            ]);

            unlink(storage_path($task->getMutexName()));

            $task->notify(new TaskCompleted($output));
            $task->autoCleanup();
        }
    }
}
