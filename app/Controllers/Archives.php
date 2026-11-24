<?php

namespace App\Controllers;

class Archives extends BaseController
{
    public function index(): string
    {
        return view('archives/index', [
            'title' => 'Arsip Dokumen',
        ]);
    }
}
