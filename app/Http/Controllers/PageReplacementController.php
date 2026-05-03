<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageReplacementController extends Controller
{
    public function index()
    {
        return view('modules.page_replacement.page_replacement_main');
    }
}