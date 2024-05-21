<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Repositories\TaskRepository;
use App\Http\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TaskController extends Controller
{
    public function getUserTasks(Request $request, UserRepository $userRepository): ?JsonResponse
    {
        try {
            $getUserTasks = $userRepository->getUserTasks($request->user());
            return response()->json($getUserTasks, ResponseAlias::HTTP_OK);
        } catch (\Throwable $th) {
            \Log::alert($th);
            return response()->json([
                'success' => false,
                'error' => $th,
            ], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(TaskStoreRequest $request, TaskRepository $taskRepository): ?JsonResponse
    {
        try {
            $taskRepository->store($request->user(), $request->name);
            return response()->json([], ResponseAlias::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            \Log::alert($th);
            return response()->json([
                'success' => false,
                'error' => $th,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return JsonResponse
     */
    public function destroy(string $taskId, TaskRepository $taskRepository): JsonResponse
    {
        try {
            $taskRepository->destroy($taskId);
            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully',
            ], 204);
        } catch (\Throwable $th) {
            \Log::alert($th);
            return response()->json([
                'success' => false,
                'error' => $th,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return JsonResponse
     */
    public function update(Request $request, TaskRepository $taskRepository): ?JsonResponse
    {
        try {
            $taskRepository->update($request);
            return response()->json([
                'success' => true,
                'message' => 'Task update successfully',
            ], ResponseAlias::HTTP_OK);
        } catch (\Exception $th) {
            return response()->json([
                'success' => false,
                'error' => $th,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return JsonResponse
     */
    public function finishTask(TaskStoreRequest $request, TaskRepository $taskRepository): ?JsonResponse
    {
        try {
            $taskRepository->finishTask($request);
            return response()->json([
                'success' => true,
                'message' => 'Task update successfully',
            ], ResponseAlias::HTTP_OK);
        } catch (\Throwable $th) {
            \Log::alert($th);
            return response()->json([
                'success' => false,
                'error' => $th,
            ], 500);
        }
    }
}
