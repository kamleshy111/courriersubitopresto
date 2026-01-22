<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function store(Request $request){
        $note = Note::first();
        Note::updateOrCreate(
            [
                'id'            => $note->id,
            ],
            [
            'news'   => $request->news,
            'useful_links_1'   => $request->useful_links_1,
            'useful_links_2'   => $request->useful_links_2,
            'quick_links_1'   => $request->quick_links_1,
            ]
        );
        return redirect()->to('/');
    }
}
