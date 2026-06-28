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
            'email'            => 'required|email|unique:tb_users,email',
            'contact_number'   => 'required|digits_between:10,15|unique:tb_users,contact_number',
            'password'         => 'required|string|min:8|confirmed',
            'entity_type'      => 'required|in:individual,foundation,corporate,community',
            'bank_name'        => 'required|string|max:50',
            'account_number'   => 'required|numeric|unique:tb_user_bank_accounts,account_number',
            'account_holder'   => 'required|string|max:255',
            'bank_proof'       => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'username.max'        => 'Nama maksimal 50 karakter.',
            'bank_name.max'       => 'Nama bank maksimal 50 karakter.',
            'account_holder.max'  => 'Nama pemilik rekening maksimal 255 karakter.',
            'username.required'             => 'Nama lengkap wajib diisi.',
            'username.regex'                => 'Nama tidak boleh mengandung angka.',
            'email.required'                => 'Email wajib diisi.',
            'email.unique'                  => 'Email sudah terdaftar.',
            'contact_number.required'       => 'Nomor kontak wajib diisi.',
            'contact_number.digits_between' => 'Nomor kontak harus 10-15 digit.',
            'contact_number.unique'         => 'Nomor kontak sudah terdaftar.',
            'password.required'             => 'Password wajib diisi.',
            'password.min'                  => 'Password minimal 8 karakter.',
            'password.confirmed'            => 'Konfirmasi password tidak sesuai.',
            'entity_type.required'          => 'Tipe akun wajib dipilih.',
            'bank_name.required'            => 'Nama bank wajib diisi.',
            'account_number.required'       => 'Nomor rekening wajib diisi.',
            'account_number.unique'         => 'Nomor rekening sudah terdaftar.',
            'account_holder.required'       => 'Nama pemilik rekening wajib diisi.',
            'bank_proof.required'           => 'Foto buku tabungan wajib diunggah.',
            'bank_proof.mimes'              => 'Format file harus jpg, jpeg, png, atau pdf.',
            'bank_proof.max'                => 'Ukuran file maksimal 2MB.',
        ]);

        // Validasi dokumen tambahan sesuai tipe
        if ($request->entity_type === 'foundation') {
            $request->validate([
                'foundation_name'       => 'required|string|max:255',
                'sk_kemenkumham_number' => 'required|string|max:50',
                'pic_name_foundation'   => 'required|string|max:255',
                'sk_kemenkumham'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'pic_ktp'               => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ], [
                'foundation_name.required'       => 'Nama yayasan wajib diisi.',
                'sk_kemenkumham_number.required' => 'Nomor SK Kemenkumham wajib diisi.',
                'pic_name_foundation.required'   => 'Nama penanggung jawab wajib diisi.',
                'sk_kemenkumham.required'        => 'File SK Kemenkumham wajib diunggah.',
                'pic_ktp.required'               => 'KTP penanggung jawab wajib diunggah.',
                'foundation_name.max'       => 'Nama yayasan maksimal 255 karakter.',
                'sk_kemenkumham_number.max' => 'Nomor SK Kemenkumham maksimal 50 karakter.',
                'pic_name_foundation.max'   => 'Nama penanggung jawab maksimal 255 karakter.',
                'sk_kemenkumham.max'        => 'Ukuran file SK Kemenkumham maksimal 2MB.',
                'sk_kemenkumham.mimes'      => 'Format file SK harus pdf, jpg, jpeg, atau png.',
                'pic_ktp.max'               => 'Ukuran file KTP maksimal 2MB.',
                'pic_ktp.mimes'             => 'Format file KTP harus jpg, jpeg, atau png.',
            ]);
        } elseif ($request->entity_type === 'corporate') {
            $request->validate([
                'company_name'       => 'required|string|max:255',
                'nib'                => 'required|string|max:20',
                'npwp'               => 'required|string|max:20',
                'pic_name_corporate' => 'required|string|max:255',
                'pic_ktp'            => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ], [
                'company_name.required'      => 'Nama perusahaan wajib diisi.',
                'nib.required'               => 'NIB wajib diisi.',
                'npwp.required'              => 'NPWP wajib diisi.',
                'pic_name_corporate.required'=> 'Nama penanggung jawab wajib diisi.',
                'pic_ktp.required'           => 'KTP penanggung jawab wajib diunggah.',
                'company_name.max'           => 'Nama perusahaan maksimal 255 karakter.',
                'nib.max'                      => 'NIB maksimal 20 karakter.',
                'npwp.max'                     => 'NPWP maksimal 20 karakter.',
                'pic_name_corporate.max'     => 'Nama penanggung jawab maksimal 255 karakter.',
                'pic_ktp.max'                => 'Ukuran file KTP maksimal 2MB.',
                'pic_ktp.mimes'              => 'Format file KTP harus jpg, jpeg, atau png.',
            ]);
        } elseif ($request->entity_type === 'community') {
            $request->validate([
                'community_name'          => 'required|string|max:255',
                'social_media_url'        => 'required|url',
                'pic_name_community'      => 'required|string|max:255',
                'social_media_screenshot' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'pic_ktp'                 => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ], [
                'community_name.required'         => 'Nama komunitas wajib diisi.',
                'social_media_url.required'       => 'URL media sosial wajib diisi.',
                'social_media_url.url'            => 'Format URL tidak valid.',
                'pic_name_community.required'     => 'Nama penanggung jawab wajib diisi.',
                'social_media_screenshot.required'=> 'Screenshot profil media sosial wajib diunggah.',
                'pic_ktp.required'                => 'KTP penanggung jawab wajib diunggah.',
                'community_name.max'          => 'Nama komunitas maksimal 255 karakter.',
                'pic_name_community.max'      => 'Nama penanggung jawab maksimal 255 karakter.',
                'social_media_screenshot.max' => 'Ukuran file screenshot maksimal 2MB.',
                'social_media_screenshot.mimes' => 'Format file harus jpg, jpeg, atau png.',
                'pic_ktp.max'                 => 'Ukuran file KTP maksimal 2MB.',
                'pic_ktp.mimes'               => 'Format file KTP harus jpg, jpeg, atau png.',
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
                'foundation_name'       => $request->foundation_name,
                'sk_kemenkumham_number' => $request->sk_kemenkumham_number,
                'foundation_address'    => '-',
                'pic_name'              => $request->pic_name_foundation,
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
                'company_name'          => $request->company_name,
                'nib'                   => $request->nib,
                'npwp'                  => $request->npwp,
                'company_address'       => '-',
                'pic_name'              => $request->pic_name_corporate,
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
                'community_name'        => $request->community_name,
                'community_type'        => '-',
                'social_media_url'      => $request->social_media_url,
                'pic_name'              => $request->pic_name_community,
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