<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        if(is_null(Auth::user())){
            return view('pages.login');
        }
        return view('layouts.dashboard', ['user' => Auth::user()->identity]);
    }
}
