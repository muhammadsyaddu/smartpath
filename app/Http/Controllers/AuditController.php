<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    /**
     * Daftar audit log.
     */
    public function index(Request $request)
    {
        $query = Audit::with('pengguna');

        if ($request->filled('aksi')) {
            $query->aksi($request->aksi);
        }
        if ($request->filled('tabel')) {
            $query->tabel($request->tabel);
        }
        if ($request->filled('dari')) {
            $query->where('created_at', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->where('created_at', '<=', $request->sampai);
        }

        $auditLog = $query->orderByDesc('created_at')->paginate(25);

        $aksiList = Audit::select('aksi')->distinct()->pluck('aksi');
        $tabelList = Audit::select('tabel_terkait')->distinct()->whereNotNull('tabel_terkait')->pluck('tabel_terkait');

        return view('admin.audit.index', compact('auditLog', 'aksiList', 'tabelList'));
    }

    /**
     * Detail audit log.
     */
    public function show(Audit $audit)
    {
        $audit->load('pengguna');
        return view('admin.audit.show', compact('audit'));
    }
}