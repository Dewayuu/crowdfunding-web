<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserBankAccount;
use App\Models\UserDetailFoundation;
use App\Models\UserDetailCorporate;
use App\Models\UserDetailCommunity;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi dasar (semua tipe)
        $request->validate([
            'username'         => 'required|string|max:50|regex:/^[\pL\s]+$/u',
            'email'                => 'required|email|unique:tb_users,email',
            'contact_number'   => 'required|digits_between:10,15|unique:tb_users,contact_number',
            'password'             => 'required|string|min:8|confirmed',
            'entity_type'          => 'required|in:individual,foundation,corporate,community',
            'bank_name'            => 'required|string|max:50',
            'account_number'       => 'required|numeric|unique:tb_user_bank_accounts,account_number',
            'account_holder'       => 'required|string|max:255',
            'bank_proof'           => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Validasi dokumen tambahan sesuai tipe
        if ($request->entity_type === 'foundation') {
            $request->validate([
                'sk_kemenkumham' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'pic_ktp'        => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ]);
        } elseif ($request->entity_type === 'corporate') {
            $request->validate([
                'nib'     => 'required|string|max:20',
                'npwp'    => 'required|string|max:20',
                'pic_ktp' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ]);
        } elseif ($request->entity_type === 'community') {
            $request->validate([
                'social_media_url'        => 'required|url',
                'social_media_screenshot' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'pic_ktp'                 => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ]);
        }

        // Simpan user utama
        $user = User::create([
            'username'       => $request->username,
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
            'password'       => Hash::make($request->password),
            'entity_type'    => $request->entity_type,
            'role'           => 'user',
            'account_status' => 'active',
        ]);

        // Simpan rekening bank
        $bankProofPath = $request->file('bank_proof')->store('documents/bank_proof', 'public');

        UserBankAccount::create([
            'user_id'        => $user->user_id,
            'bank_name'      => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name'   => $request->account_holder,
        ]);

        // Simpan dokumen bank proof ke tb_user_documents
        UserDocument::create([
            'user_id'             => $user->user_id,
            'document_type'       => 'bank_book',
            'file'                => $bankProofPath,
            'uploaded_at'         => now(),
            'verification_status' => 'pending',
        ]);

        // Simpan detail & dokumen sesuai tipe akun
        if ($request->entity_type === 'foundation') {
            $skPath  = $request->file('sk_kemenkumham')->store('documents/foundation', 'public');
            $ktpPath = $request->file('pic_ktp')->store('documents/ktp', 'public');

            UserDetailFoundation::create([
                'user_id'               => $user->user_id,
                'foundation_name'       => $request->username,
                'sk_kemenkumham_number' => $request->sk_kemenkumham_number ?? '-',
                'foundation_address'    => '-',
                'pic_name'              => $request->username,
                'pic_national_id_number'=> '-',
            ]);

            UserDocument::create([
                'user_id'             => $user->user_id,
                'document_type'       => 'sk_kemenkumham',
                'file'                => $skPath,
                'uploaded_at'         => now(),
                'verification_status' => 'pending',
            ]);

            UserDocument::create([
                'user_id'             => $user->user_id,
                'document_type'       => 'ktp',
                'file'                => $ktpPath,
                'uploaded_at'         => now(),
                'verification_status' => 'pending',
            ]);

        } elseif ($request->entity_type === 'corporate') {
            $ktpPath = $request->file('pic_ktp')->store('documents/ktp', 'public');

            UserDetailCorporate::create([
                'user_id'               => $user->user_id,
                'company_name'          => $request->username,
                'nib'                   => $request->nib,
                'npwp'                  => $request->npwp,
                'company_address'       => '-',
                'pic_name'              => $request->username,
                'pic_national_id_number'=> '-',
            ]);

            UserDocument::create([
                'user_id'             => $user->user_id,
                'document_type'       => 'ktp',
                'file'                => $ktpPath,
                'uploaded_at'         => now(),
                'verification_status' => 'pending',
            ]);

        } elseif ($request->entity_type === 'community') {
            $ssPath  = $request->file('social_media_screenshot')->store('documents/community', 'public');
            $ktpPath = $request->file('pic_ktp')->store('documents/ktp', 'public');

            UserDetailCommunity::create([
                'user_id'               => $user->user_id,
                'community_name'        => $request->username,
                'community_type'        => '-',
                'social_media_url'      => $request->social_media_url,
                'pic_name'              => $request->username,
                'pic_national_id_number'=> '-',
            ]);

            UserDocument::create([
                'user_id'             => $user->user_id,
                'document_type'       => 'social_media',
                'file'                => $ssPath,
                'uploaded_at'         => now(),
                'verification_status' => 'pending',
            ]);

            UserDocument::create([
                'user_id'             => $user->user_id,
                'document_type'       => 'ktp',
                'file'                => $ktpPath,
                'uploaded_at'         => now(),
                'verification_status' => 'pending',
            ]);
        }

        return response()->json(['success' => true]);
    }
}