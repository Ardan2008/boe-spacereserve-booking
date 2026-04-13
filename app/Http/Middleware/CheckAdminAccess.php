<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminAccess
{
    public function handle(Request $request, Closure $next, $requirement = null): Response
    {
        if (!$request->session()->has('id_log')) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.'], 401);
            }
            return redirect()->route('formLogin')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Fetch fresh admin data to ensure reactive permissions
        $admin = \App\Models\Admins::find($request->session()->get('id_log'));
        
        if (!$admin || $admin->force_logout) {
            $isManual = ($admin && $admin->logout_type === 'manual');
            $message = $isManual 
                ? 'Anda telah dikeluarkan paksa dari sistem oleh owner, silakan hubungi owner.'
                : 'Silakan login kembali, terjadi update sistem oleh owner.';
            
            $request->session()->flush();
            
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 401);
            }
            return redirect()->route('formLogin')->with('error', $message);
        }

        // Sync session with database values every request
        $request->session()->put('role', $admin->role);
        $request->session()->put('can_edit', (bool)$admin->can_edit);

        $userRole = $admin->role;
        $canEdit = (bool)$admin->can_edit;

        // Requirement checking
        if ($requirement === 'owner' && $userRole !== 'owner') {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak. Fitur ini hanya untuk Owner.'], 403);
            }
            return redirect()->route('dashboardMaster')->with('error', 'Akses ditolak. Fitur ini hanya untuk Owner.');
        }

        if ($requirement === 'can_edit' && $userRole !== 'owner' && !$canEdit) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak. Anda tidak memiliki izin untuk melakukan perubahan.'], 403);
            }
            return redirect()->route('dashboardMaster')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk melakukan perubahan.');
        }

        return $next($request);
    }
}

