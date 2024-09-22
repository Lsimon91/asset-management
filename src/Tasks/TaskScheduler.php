<?php

namespace App\Tasks;

class TaskScheduler
{
    private $tasks = [];

    public function addTask(Task $task, $expression)
    {
        $this->tasks[] = [
            'task' => $task,
            'expression' => $expression
        ];
    }

    public function run()
    {
        $now = new \DateTime();
        foreach ($this->tasks as $taskData) {
            if ($this->shouldRunNow($taskData['expression'], $now)) {
                $taskData['task']->handle();
            }
        }
    }

    private function shouldRunNow($expression, \DateTime $now)
    {
        // Aquí implementarías la lógica para verificar si la tarea debe ejecutarse
        // basándote en la expresión cron y la hora actual
    }
}
