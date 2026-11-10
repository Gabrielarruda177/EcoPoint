<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Exibe a página inicial pública do sistema.
     */
    public function index(): View
    {
        return view('publico.home');
    }
}

