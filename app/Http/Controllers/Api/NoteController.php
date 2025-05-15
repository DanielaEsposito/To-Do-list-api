<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Prompts\Note;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Notes::all();
        return response()->json([
            'success' => true,
            'data' => $notes
        ]);
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
        $newNote = new Notes();
        $newNote->title = $data['title'];
        $newNote->description = $data['description'];
        $newNote->user_id = Auth::id();
        $newNote->date = $data['date'];
        $newNote->save();
        return response()->json($newNote);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notes $note)
    {
        return response()->json($note);
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
    public function update(Request $request, Notes $note)
    {
        $data = $request->all();
        $note->title = $data['title'];
        $note->description = $data['description'];
        $note->date = $data['date'];
        $note->save();
        return response()->json($note);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notes $note)
    {
        $note->delete();
        return response()->json([
            "message" => "Note deleted successfully",
            "success" => true
        ]);
    }
}
