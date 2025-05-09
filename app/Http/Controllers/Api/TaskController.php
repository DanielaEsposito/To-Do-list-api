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
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delite();
    }
}
