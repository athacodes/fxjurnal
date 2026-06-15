<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UploadController
{
    public function downloadFile($id)
    {
        $userId = auth()->id();

        $upload = DB::table('uploads')
            ->join('notes', 'uploads.note_id', '=', 'notes.id')
            ->select('uploads.*')
            ->where('uploads.id', $id)
            ->where('notes.user_id', $userId)
            ->first();

        if (!$upload) {
            return redirect()->back()->with('error', 'File tidak ditemukan atau Anda tidak memiliki akses!');
        }

        $path = storage_path('app/public/' . $upload->file_path);

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'Fisik file sudah tidak ada di server!');
        }

        return response()->download($path, $upload->file_name);
    }
}
