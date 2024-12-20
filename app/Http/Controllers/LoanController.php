<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class LoanController
{
    public function index()
    {
        Session::put('menu', 'Peminjaman');

        return view('dashboard.loans', [
            'title' => 'Peminjaman - Manajemen Perpustakaan',
        ]);
    }
}
