<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public function render()
    {
        $user = Auth::user();
        $role = $user ? $user->role : null;
        return view('components.sidebar', compact('role'));
    }
}