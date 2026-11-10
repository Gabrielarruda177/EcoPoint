<?php

namespace App\Http\Controllers\Ong;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Exibe o painel inicial da ONG logada.
     */
    public function index(): View
    {
        return view('ong.dashboard');
    }
}

