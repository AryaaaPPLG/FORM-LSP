<?php

namespace App\Http\Controllers;

use App\Models\LspForm;
use Illuminate\Http\Request;

class LspFormController extends Controller
{
    public function index()
    {
        return view('lsp-form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'asal_sekolah' => 'required|string|max:255',
            'signature' => 'required|string',
        ]);

        LspForm::create([
            'nama' => $request->nama,
            'asal_sekolah' => $request->asal_sekolah,
            'signature' => $request->signature,
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil dikirim!');
    }
}
