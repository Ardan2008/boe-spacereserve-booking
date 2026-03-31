<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas; 
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua data fasilitas dari database
        $facilities = Fasilitas::all();

        // Kirim data ke view 'home' (sesuaikan dengan nama file blade kamu)
        return view('home', compact('facilities'));
    }
}