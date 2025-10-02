<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Allow sorting by 'name' or 'created_at' with direction
        $sortField = in_array($request->input('sort'), ['title', 'created_at']) ? $request->input('sort') : 'created_at';
        $sortDirection = $request->input('direction') === 'asc' ? 'asc' : 'desc';
        $category =Category::all();

        $today = \Carbon\Carbon::today();
        $soonThreshold = \Carbon\Carbon::today()->addDays(3);
        $task = Task::query()
            ->orderBy($sortField, $sortDirection)
            ->paginate(5)
            ->withQueryString();

        // Step 2: Add due_status to each task in the paginated collection
        $task->getCollection()->transform(function ($task) use ($today, $soonThreshold) {
            $dueDate = \Carbon\Carbon::parse($task->due_date);

            if ($dueDate->isPast() && !$dueDate->isToday()) {
                $task->due_status = 'Over due';
            } elseif ($dueDate->isToday()) {
                $task->due_status = 'Due Today';
            } elseif ($dueDate->between($today, $soonThreshold)) {
                $task->due_status = 'Due Soon';
            } else {
                $task->due_status = 'Upcoming';
            }

            return $task;
        });


        return Inertia::render('Tasks/Index', [
            'tasks' => $task,
            'categories' => $category,
            'filters' => $request->only(['sort', 'direction']),
        ]);

    }

    public function create()
    {
        return Inertia::render('Tasks/Index', [
            'modal' => 'Tasks/Create'
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
            'due_date' => 'required|date',
        ]);


            $task = Task::create([
                'title' => $request->title,
                'description' => !empty($request->description) ? $request->description : '',
                'due_date' => \Carbon\Carbon::parse($request->due_date)->format('Y-m-d'),
                'is_done' => !empty($request->is_done) ? 0 : 1,
                'status' => !empty($request->status) ? 0 : 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),

            ]);

        return redirect(route('tasks', absolute: false));
    }



    public function update(Request $request,$id)
    {

        $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
            'due_date' => 'required|date',
            'status' => 'required|boolean',
        ]);


        $task = Task::findOrFail($id);

        $task->update([
            'title' =>  $request->input('title'),
            'description' => $request->input('description'),
            'due_date' => \Carbon\Carbon::parse($request->due_date)->format('Y-m-d'),
            'status' => !empty($request->input('status')) ? 0 : 1,
            'is_done' => !empty($request->is_done) ? 0 : 1,
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Task  updated successfully',
            'task' => $task
        ]);
    }


    public function completedUpdate(Request $request,$id)
    {

        $task = Task::findOrFail($id);
        
        $task->update([
            'is_done' => !empty($request->is_done) ? 0 : 1
        ]);


        return response()->json([
            'message' => 'Task Category updated successfully',
            'task' => $task
        ]);
    }
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return redirect()->route('tasks')->with('error', 'Task not found.');
        }

        $task->delete();
        return redirect()->route('tasks')->with('success', 'Task deleted successfully.');
    }

}
