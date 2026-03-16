<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Store a newly created task in database.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|string|in:Pending,In Progress,Completed,Cancelled',
                'priority' => 'required|string|in:Low,Medium,High',
                'due_date' => 'nullable|date',
            ]);

            $task = Task::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Task created successfully!',
                'task' => $task,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating task: ' . $e->getMessage(),
            ], 500);
        }
    }
}
