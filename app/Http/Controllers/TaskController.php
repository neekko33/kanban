<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Board;
use App\Models\Task;

class TaskController extends Controller
{
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'priority',
        'status',
        'board_id',
    ];

    public function index(Board $board)
    {
        return response()->json($board->tasks);
    }

    public function show(Board $board, Task $task)
    {
        return response()->json($board->tasks->find($task->id));
    }

    public function store(TaskRequest $request, Board $board)
    {
        $validated = $request->validated();
        $task = $board->tasks->create($validated);

        return response()->json($task, 201);
    }

    public function update(TaskRequest $request, Board $board, Task $task)
    {
        $validated = $request->validated();
        $task->update([
            ...$validated,
            'board_id' => $board->id,
        ]);

        return response()->json($task);
    }
}
