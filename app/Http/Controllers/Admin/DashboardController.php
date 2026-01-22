<?php


namespace App\Http\Controllers\Admin;


use App\Models\Note;

class DashboardController extends Controller {
    public function index() {

        $note = Note::first();
        return view('admin.dashboard.index', compact('note'));
    }
}
