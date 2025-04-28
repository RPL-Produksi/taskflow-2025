<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardTaskerController extends Controller
{
    public function index() {
        $user = Auth::user();
        $taskCount = Task::where('user_id', $user->id)->count();

        return view('pages.tasker.dashboard', compact('user', 'taskCount'));
    }
}
