<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Exibe o painel inicial do administrador.
     */
    public function index(): View
    {
        return view('admin.dashboard');
    }
}

