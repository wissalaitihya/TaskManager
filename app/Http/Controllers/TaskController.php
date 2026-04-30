<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Category;

class TaskController extends Controller
{
    public function index(Request $request){
        $query =auth()->user()->tasks()->with('category');
        //filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        //filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        $tasks =$query->latest()->paginate(8);
        $categories = Category::all();
        //count tasks by status for the bonus 
        $counts = [
        'to_do'       => auth()->user()->tasks()->where('status', 'to_do')->count(),
        'in_progress' => auth()->user()->tasks()->where('status', 'in_progress')->count(),
        'done'        => auth()->user()->tasks()->where('status', 'done')->count(),
        ];
        return view('tasks.index', compact('tasks', 'categories', 'counts'));
        
    }

    // Dedicated tasks list page
    public function tasks(Request $request)
    {
    $query = auth()->user()->tasks()->with('category');

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    $tasks      = $query->latest()->paginate(8);
    $categories = Category::all();

    return view('tasks.list', compact('tasks', 'categories'));
    }
    public function create(){
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request){
    $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'nullable|string',
    'status' => 'required|in:to_do,in_progress,done',
    'due_date' => 'nullable|date',
    ]);
    auth()->user()->tasks()->create($request->all());
    return redirect()->route('tasks.index')->with('success','Task created successfully');
    }

    public function edit (Task $task){
        if($task->user_id !== auth()->id()){
            abort(403);
        }
        $categories = Category::all();
        return view('tasks.edit', compact('task', 'categories'));

    }
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required|in:to_do,in_progress,done',
            'due_date'    => 'nullable|date',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }
     public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
    public function updateStatus(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:to_do,in_progress,done',
        ]);

        $task->update(['status' => $request->status]);

        return back();
    }


}
