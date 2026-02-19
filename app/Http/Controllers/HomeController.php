<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sections = \App\Models\LandingPageSection::with('module')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();
            
        return view('landing.index', compact('sections'));
    }
}
