<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Priorities;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = $request->input('category');
        $priority = $request->input('priority');
        $completed = $request->input('completed');
        $date = $request->input('date');
        //recupero l'utente autenticato
        $user = Auth::user();
        //alla variabile $query assegno la query per recuperare i task dell'utente
        $query = Task::where('user_id', $user->id);
        //se la variabile $category non è vuota, aggiungo alla query il filtro per categoria
        if ($category) {
            $query->where('category_id', $category);
        }
        //se la variabile $priority non è vuota, aggiungo alla query il filtro per priorità
        if ($priority) {
            $query->where('priority_id', $priority);
        }
        if ($completed) {
            $query->where('completed', $completed);
        }
        if ($date) {
            $query->where('date', $date);
        }

        $tasks = $query->with('category', 'priority')->get();

        return response()->json($tasks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $newTask = new Task();
        $newTask->title = $data['title'];
        $newTask->description = $data['description'];
        $newTask->user_id = Auth::id();
        $newTask->category_id = $data['category_id'];
        $newTask->priority_id = $data['priority_id'];
        $newTask->save();
        return response()->json($newTask);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load('category', 'priority');
        if (!$task) {
            return response()->json([
                "message" => "Task not found",
                "success" => false
            ]);
        }
        return response()->json([
            "success" => true,
            "data" => $task
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {


        $data = $request->all();

        $task->title = $data['title'];
        $task->description = $data['description'];
        $task->category_id = $data['category_id'];
        $task->priority_id = $data['priority_id'];
        $task->completed = $data['completed'];
        $task->update();
        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task eliminata']);
    }
}
