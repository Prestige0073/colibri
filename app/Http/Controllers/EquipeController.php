<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use Illuminate\Http\Request;

class EquipeController extends Controller
{
    public function index()
    {
        $membres = Equipe::where('actif', true)->orderBy('created_at', 'desc')->get();
        $totalMembres = $membres->count();
        return view('about', compact('membres', 'totalMembres'));
    }
}
