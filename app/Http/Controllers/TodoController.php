<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TodoController extends Controller
{

    public function index(): View
    {
        return view('todos.index', [
        'todos' => Todo::with('user')->latest()->get(),
    ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'task' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        
        $request->user()->todos()->create([
            'task' => $validated['task'],
            'description' => $validated['description'],
        ]);
    
   
        return redirect()->route('todos.index')->with('success', 'Todo created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }


    public function edit(Todo $todo): View
    {
        $this->authorize('update', $todo);

        return view('todos.edit', [
            'todo' => $todo,
        ]);
    }

    public function update(Request $request, Todo $todo): RedirectResponse
    {
        $this->authorize('update', $todo);
    
        $validated = [];
    
        if ($request->has('status')) {
            $validated = $request->validate([
                'status' => 'required|in:Not started,In progress,Completed',
            ]);
    
            $todo->status = $validated['status'];
        }
    
        $todo->task = $request->input('task', $todo->task);
        $todo->description = $request->input('description', $todo->description);
        $todo->save();
    
        return redirect()->route('todos.index')->with('success', 'Todo updated successfully.');
    }
    
    
    
 

    public function destroy(Todo $todo): RedirectResponse
    {
        $this->authorize('delete', $todo);
 
        $todo->delete();
 
        return redirect()->route('todos.index')->with('success', 'Todo deleted successfully.');
    }
}
