<?php

namespace App\Http\Repositories;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class TaskRepository
{
    protected string $task = Task::class;

    public function store($user, $name, $description = null)
    {
        DB::beginTransaction();
        $task = $this->task::create([
            'id' => Uuid::uuid4(),
            'name' => $name,
            'description' => $description,
            'status' => 'PENDING',
            'user_id' => $user['id'],
        ]);
        DB::commit();
        return $task;
    }

    public function update(Request $request)
    {
        $taskToUpdate = $this->task::where('id', $request->input('taskId'))->first();
        if ($taskToUpdate->is_finish) {
            throw new \RuntimeException('Task is already completed');
        }
        DB::beginTransaction();
        if ($request->input('name')) {
            $taskToUpdate->name = $request->input('name');
        }
        if ($request->input('status')) {
            $taskToUpdate->status = 'IN_PROGRESS';
        }
        $taskToUpdate->save();
        DB::commit();
        return $taskToUpdate;
    }

    public function finishTask(Request $request)
    {
        DB::beginTransaction();
        $taskToUpdate = $this->task::where('id', $request->input('taskId'))->first();
        $taskToUpdate->status = 'COMPLETED';
        $taskToUpdate->is_finish = true;
        $taskToUpdate->save();
        DB::commit();
        return $taskToUpdate;
    }

    public function destroy(string $taskId)
    {
        return $this->task::find($taskId)->delete();
    }
}
