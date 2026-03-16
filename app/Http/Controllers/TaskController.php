<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Get all tasks with filtering and sorting
     */
    public function index(Request $request)
    {
        try {
            $query = Task::query();

            // Filter by status
            if ($request->has('status') && $request->status !== 'All Tasks') {
                $query->where('status', $request->status);
            }

            // Sort
            $sortBy = $request->get('sort', 'newest');
            switch ($sortBy) {
                case 'due_date':
                    $query->orderByRaw('due_date IS NULL, due_date ASC');
                    break;
                case 'priority':
                    $priorityOrder = ['High' => 1, 'Medium' => 2, 'Low' => 3];
                    $query->orderByRaw("FIELD(priority, '" . implode("','", array_keys($priorityOrder)) . "')");
                    break;
                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            $tasks = $query->get();

            return response()->json([
                'success' => true,
                'tasks' => $tasks,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching tasks: ' . $e->getMessage(),
            ], 500);
        }
    }

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

    /**
     * Delete a task
     */
    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();

            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting task: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update task details
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|string|in:Pending,In Progress,Completed,Cancelled',
                'priority' => 'required|string|in:Low,Medium,High',
                'due_date' => 'nullable|date',
            ]);

            $task = Task::findOrFail($id);
            $task->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully!',
                'task' => $task,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating task: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get single task for editing
     */
    public function show($id)
    {
        try {
            $task = Task::findOrFail($id);

            return response()->json([
                'success' => true,
                'task' => $task,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching task: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update task status
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|string|in:Pending,In Progress,Completed,Cancelled',
            ]);

            $task = Task::findOrFail($id);
            $task->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Task status updated successfully!',
                'task' => $task,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating task: ' . $e->getMessage(),
            ], 500);
        }
    }
}

