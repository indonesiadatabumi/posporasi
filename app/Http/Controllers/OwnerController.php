<?php

// app/Http/Controllers/OwnerController.php
namespace App\Http\Controllers;
use App\Models\Toko;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $toko = Toko::all();
        return view('owner.dashboard', compact('toko')); 
    }
}
