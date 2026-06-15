<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SignalController extends Controller
{
    /**
     * Menampilkan halaman list sinyal untuk Member maupun Admin
     */
    public function index()
    {
        // Ambil semua data sinyal terbaru dari database
        $signals = DB::table('signals')
            ->orderBy('created_at', 'desc')
            ->get();

        // Cek jika yang login admin, arahkan ke halaman kelola admin, jika member ke halaman list member
        if (auth()->user()->role === 'admin') {
            return view('pages.signals.admin_index', compact('signals')); // Sesuaikan dengan nama view admin lo bray
        }

        // Untuk member biasa, kirim ke halaman list sinyal member
        return view('pages.signals.index', compact('signals'));
    }

    /**
     * Fungsi untuk menyimpan sinyal baru (oleh Admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'pair'         => 'required|string|max:50',
            'type'         => 'required|in:BUY,SELL',
            'entry_price'  => 'required|string',
            'take_profit'  => 'required|string',
            'stop_loss'    => 'required|string',
        ]);

        DB::table('signals')->insert([
            'pair'        => strtoupper($request->pair),
            'type'        => strtoupper($request->type),
            'entry_price' => $request->entry_price,
            'take_profit' => $request->take_profit,
            'stop_loss'   => $request->stop_loss,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->back()->with('success', 'Sinyal trade baru berhasil dirilis!');
    }
}
