<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    Daftar notifikasi pengguna.
     */
    public function index(Request $request)
    {
        $notifikasi = Notifikasi::where('penerima_id', auth()->id())
            ->with('laporan')
            ->orderByDesc('created_at')
            ->paginate(20);

        $belumDibaca = Notifikasi::where('penerima_id', auth()->id())
            ->belumDibaca()
            ->count();

        return view('notifikasi.index', compact('notifikasi', 'belumDibaca'));
    }

    /**
     * Tandai notifikasi sebagai dibaca.
     */
    public function markAsRead(Notifikasi $notifikasi)
    {
        if ($notifikasi->penerima_id !== auth()->id()) {
            abort(403);
        }

        $notifikasi->markAsRead();

        if ($notifikasi->tautan) {
            return redirect($notifikasi->tautan);
        }

        return back();
    }
     public function markAllAsRead()
    {
        Notifikasi::where('penerima_id', auth()->id())
            ->belumDibaca()
            ->each(fn($n) => $n->markAsRead());

        return back()->with('sukses', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * API: hitung notifikasi belum dibaca.
     */
    public function unreadCount()
    {
        return response()->json([
            'count' => auth()->user()->notifikasi_belum_dibaca_count,
        ]);
    }
    
}
