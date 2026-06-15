<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function indexNotes()
    {
        $userId = Auth::id();

        // 1. Ambil data Jurnal Trading milik user
        $notes = DB::table('notes')
            ->leftJoin('uploads', 'notes.id', '=', 'uploads.note_id')
            ->select('notes.*', 'uploads.id as upload_id', 'uploads.file_name', 'uploads.file_path')
            ->where('notes.user_id', $userId)
            ->orderBy('notes.created_at', 'desc')
            ->get();

        // 2. Ambil data Sinyal IB Terbaru (Limit 3 sinyal paling baru untuk widget samping)
        $signals = DB::table('signals')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // 3. Kirim kedua data ke view index
        return view('pages.notes.index', compact('notes', 'signals'));
    }

    public function createNote()
    {
        return view('pages.notes.create');
    }

    public function storeNote(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'type'            => 'required|in:BUY,SELL',
            'entry_price'     => 'required|string',
            'exit_price'      => 'required|string',
            'stop_loss'       => 'required|string',
            'take_profit'     => 'required|string',
            'lot'             => 'required|numeric|min:0.01',
            'trading_session' => 'required|string|max:100',
            'content'         => 'required',
            'file_attachment' => 'nullable|file|mimes:png,jpg,jpeg|max:5120',
        ]);

        $userId = Auth::id();
        $pair = strtoupper($request->title);
        $type = strtoupper($request->type);

        // Bersihkan space dan memformat ke float php murni
        $entry = (float) str_replace(',', '.', trim($request->entry_price));
        $exit = (float) str_replace(',', '.', trim($request->exit_price));
        $lot = (float) $request->lot;

        // Aturan Multiplier Industri Trading Asli
        if (str_contains($pair, 'XAU') || str_contains($pair, 'GOLD')) {
            $multiplier = 10; // 1 USD pergerakan Emas = 10 Pips
        } elseif (str_contains($pair, 'JPY')) {
            $multiplier = 100;
        } else {
            $multiplier = 10000; // Forex standard 4-5 desimal
        }

        // Kalkulasi Jarak Pergerakan Pips
        if ($type === 'BUY') {
            $pips = ($exit - $entry) * $multiplier;
        } else {
            $pips = ($entry - $exit) * $multiplier;
        }

        // Kalkulasi Net Profit/Loss Bersih Berdasarkan Lot Pasaran
        if (str_contains($pair, 'XAU') || str_contains($pair, 'GOLD')) {
            $profitLoss = ($type === 'BUY' ? ($exit - $entry) : ($entry - $exit)) * $lot * 100;
        } else {
            $profitLoss = $pips * $lot * 10;
        }

        $noteId = DB::table('notes')->insertGetId([
            'user_id'     => $userId,
            'title'       => $request->title,
            'type'        => $request->type,
            'entry_price' => $request->entry_price,
            'exit_price'  => $request->exit_price,
            'stop_loss'   => $request->stop_loss,
            'take_profit' => $request->take_profit,
            'lot'         => $lot,
            'pips'        => round($pips, 1),
            'profit_loss' => round($profitLoss, 2),
            'session'     => $request->trading_session,
            'content'     => $request->input('content'),
            'created_at'  => now(),
        ]);

        if ($request->hasFile('file_attachment')) {
            $file = $request->file('file_attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('attachments', $fileName, 'public');

            DB::table('uploads')->insert([
                'note_id'    => $noteId,
                'file_name'  => $fileName,
                'file_path'  => $filePath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('notes.index')->with('success', 'Jurnal trading baru berhasil disimpan!');
    }

    public function showNote($id)
    {
        $userId = Auth::id();
        $note = DB::table('notes')
            ->leftJoin('uploads', 'notes.id', '=', 'uploads.note_id')
            ->select('notes.*', 'uploads.file_path')
            ->where('notes.id', $id)
            ->where('notes.user_id', $userId)
            ->first();

        if (!$note) {
            return redirect()->route('notes.index')->with('error', 'Jurnal tidak ditemukan!');
        }

        return view('pages.notes.show', compact('note'));
    }

    public function editNote($id)
    {
        $userId = Auth::id();
        $note = DB::table('notes')
            ->leftJoin('uploads', 'notes.id', '=', 'uploads.note_id')
            ->select('notes.*', 'uploads.file_name', 'uploads.file_path')
            ->where('notes.id', $id)
            ->where('notes.user_id', $userId)
            ->first();

        if (!$note) {
            return redirect()->route('notes.index')->with('error', 'Jurnal tidak ditemukan!');
        }

        return view('pages.notes.edit', compact('note'));
    }

   public function updateNote(Request $request, $id)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'type'            => 'required|in:BUY,SELL',
            'entry_price'     => 'required|string',
            'exit_price'      => 'nullable|string',
            'stop_loss'       => 'required|string',
            'take_profit'     => 'required|string',
            'lot'             => 'required|numeric|min:0.01',
            'trading_session' => 'nullable|string|max:100',
            'content'         => 'required',
            'file_attachment' => 'nullable|file|mimes:png,jpg,jpeg|max:5120',
        ]);

        $userId = Auth::id();

        $currentNote = DB::table('notes')->where('id', $id)->where('user_id', $userId)->first();
        if (!$currentNote) {
            return redirect()->route('notes.index')->with('error', 'Jurnal tidak ditemukan!');
        }

        $tradingSession = $request->input('trading_session') ?? 'London Session';
        $pair = strtoupper($request->title);
        $type = strtoupper($request->type);

        $entry = (float) str_replace(['.', ','], ['', '.'], trim($request->entry_price));

        if ($request->filled('exit_price')) {
            $exit = (float) str_replace(['.', ','], ['', '.'], trim($request->exit_price));
        } else {
            $exit = $currentNote->exit_price ? (float)$currentNote->exit_price : $entry;
        }

        $lot = (float) $request->lot;

        if (str_contains($pair, 'XAU') || str_contains($pair, 'GOLD')) {
            $multiplier = 10;
        } elseif (str_contains($pair, 'JPY')) {
            $multiplier = 100;
        } else {
            $multiplier = 10000;
        }

        if ($type === 'BUY') {
            $pips = ($exit - $entry) * $multiplier;
        } else {
            $pips = ($entry - $exit) * $multiplier;
        }

        if (str_contains($pair, 'XAU') || str_contains($pair, 'GOLD')) {
            $profitLoss = ($type === 'BUY' ? ($exit - $entry) : ($entry - $exit)) * $lot * 100;
        } else {
            $profitLoss = $pips * $lot * 10;
        }

        DB::table('notes')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->update([
                'title'       => $request->title,
                'type'        => $request->type,
                'entry_price' => $request->entry_price,
                'exit_price'  => $request->filled('exit_price') ? $request->exit_price : $currentNote->exit_price,
                'stop_loss'   => $request->stop_loss,
                'take_profit' => $request->take_profit,
                'lot'         => $lot,
                'pips'        => round($pips, 1),
                'profit_loss' => round($profitLoss, 2),
                'session'     => $tradingSession,
                'content'     => $request->input('content'),
                'updated_at'  => now(),
            ]);

        if ($request->hasFile('file_attachment')) {
            $file = $request->file('file_attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('attachments', $fileName, 'public');

            $oldUpload = DB::table('uploads')->where('note_id', $id)->first();
            if ($oldUpload) {
                $oldPath = storage_path('app/public/' . $oldUpload->file_path);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
                DB::table('uploads')->where('note_id', $id)->update([
                    'file_name'  => $fileName,
                    'file_path'  => $filePath,
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('uploads')->insert([
                    'note_id'    => $id,
                    'file_name'  => $fileName,
                    'file_path'  => $filePath,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('notes.index')->with('success', 'Jurnal trading Anda berhasil diperbarui!');
    }
}
