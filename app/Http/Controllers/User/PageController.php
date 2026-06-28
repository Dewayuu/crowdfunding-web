<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function beranda()
{
    return redirect()->route('user.dashboard');
}

    public function donasi()
    {
        return view('user.donasi');
    }

    public function tentang()
    {
        return view('user.tentang');
    }

    public function kontak()
    {
        return view('user.kontak');
    }
}