<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckCampaignEligibility
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $userId = $user->user_id;
        $type = $user->entity_type;

        $approvedDocs = DB::table('tb_user_documents')
            ->where('user_id', $userId)
            ->where('verification_status', 'approved')
            ->pluck('document_type')
            ->toArray();

        switch ($type) {
            case 'individual':
                $detail = DB::table('tb_user_details_individual')->where('user_id', $userId)->first();
                if (!$detail || empty($detail->national_id_number)) {
                    return redirect()->route('user.campaigns')->with('error', 'Gagal membuat campaign. Anda wajib melengkapi data NIK pada profil Anda.');
                }
                if (!in_array('ktp', $approvedDocs)) {
                    return redirect()->route('user.campaigns')->with('error', 'Gagal membuat campaign. Dokumen KTP Anda belum diunggah atau belum diverifikasi oleh Admin.');
                }
                break;

            case 'foundation':
                $detail = DB::table('tb_user_details_foundation')->where('user_id', $userId)->first();
                if (!$detail || empty($detail->sk_kemenkumham_number) || empty($detail->pic_national_id_number)) {
                    return redirect()->route('user.campaigns')->with('error', 'Gagal membuat campaign. Anda wajib melengkapi nomor SK Kemenkumham dan NIK PIC pada profil yayasan.');
                }
                if (!in_array('sk_kemenkumham', $approvedDocs) || !in_array('ktp', $approvedDocs)) {
                    return redirect()->route('user.campaigns')->with('error', 'Gagal membuat campaign. Dokumen SK Kemenkumham dan KTP PIC Anda wajib diunggah & disetujui Admin.');
                }
                break;

            case 'corporate':
                $detail = DB::table('tb_user_details_corporate')->where('user_id', $userId)->first();
                if (!$detail || empty($detail->nib) || empty($detail->npwp) || empty($detail->pic_national_id_number)) {
                    return redirect()->route('user.campaigns')->with('error', 'Gagal membuat campaign. Anda wajib melengkapi nomor NIB, NPWP, dan NIK PIC perusahaan.');
                }
                if (!in_array('nib', $approvedDocs) || !in_array('npwp', $approvedDocs) || !in_array('ktp', $approvedDocs)) {
                    return redirect()->route('user.campaigns')->with('error', 'Gagal membuat campaign. Dokumen NIB, NPWP, dan KTP PIC wajib diunggah & disetujui Admin.');
                }
                break;

            case 'community':
                $detail = DB::table('tb_user_details_community')->where('user_id', $userId)->first();
                if (!$detail || empty($detail->social_media_url) || empty($detail->pic_national_id_number)) {
                    return redirect()->route('user.campaigns')->with('error', 'Gagal membuat campaign. Anda wajib melengkapi URL Media Sosial dan NIK PIC komunitas.');
                }
                if (!in_array('social_media', $approvedDocs) || !in_array('ktp', $approvedDocs)) {
                    return redirect()->route('user.campaigns')->with('error', 'Gagal membuat campaign. Dokumen Screenshot Profil Medsos dan KTP PIC wajib disetujui Admin.');
                }
                break;
        }

        return $next($request);
    }
}