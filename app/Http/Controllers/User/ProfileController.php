<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserBankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {

        Auth::user()->refresh();

        return view('user.edit-profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([

            'username'         => ['required', 'string', 'max:50', 'regex:/^[\pL\s]+$/u'],
            'email'            => ['required', 'email', Rule::unique('tb_users', 'email')->ignore($user->user_id, 'user_id')],
            'contact_number'   => ['required', 'digits_between:10,15', Rule::unique('tb_users', 'contact_number')->ignore($user->user_id, 'user_id')],
            'bio'              => ['nullable', 'string', 'max:500'],
            'nik'              => ['nullable', 'string', 'digits:16'],
            'ktp_photo'        => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'profile_photo'    => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

            'current_password' => ['nullable', 'string'],
            'password'         => ['nullable', 'string', 'min:8', 'confirmed'],
            'bank_name'        => ['nullable', 'string', 'max:50'],
            'account_number'   => ['nullable', 'string', 'max:20'],
            'account_holder'   => ['nullable', 'string', 'max:255'],
            'bank_proof'       => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);


        // Foundation
        if ($user->entity_type === 'foundation') {
            \App\Models\UserDetailFoundation::updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'foundation_name'        => $request->foundation_name ?? $user->detailFoundation?->foundation_name,
                    'sk_kemenkumham_number'  => $request->sk_kemenkumham_number ?? $user->detailFoundation?->sk_kemenkumham_number,
                    'foundation_address'     => $request->foundation_address ?? $user->detailFoundation?->foundation_address ?? '-',
                    'pic_name'               => $request->pic_name_foundation ?? $user->detailFoundation?->pic_name,
                    'pic_national_id_number' => $user->detailFoundation?->pic_national_id_number ?? '-',
                ]
            );

            if ($request->hasFile('sk_kemenkumham')) {
                $skPath = $request->file('sk_kemenkumham')->store('documents/foundation', 'public');
                $user->documents()->updateOrCreate(
                    ['document_type' => 'sk_kemenkumham'],
                    ['file' => $skPath, 'uploaded_at' => now(), 'verification_status' => 'pending']
                );
            }

            if ($request->hasFile('pic_ktp')) {
                $ktpPath = $request->file('pic_ktp')->store('documents/ktp', 'public');
                $user->documents()->updateOrCreate(
                    ['document_type' => 'ktp'],
                    ['file' => $ktpPath, 'uploaded_at' => now(), 'verification_status' => 'pending']
                );
            }
        }

        // Corporate
        if ($user->entity_type === 'corporate') {
            \App\Models\UserDetailCorporate::updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'company_name'           => $request->company_name ?? $user->detailCorporate?->company_name,
                    'nib'                    => $request->nib ?? $user->detailCorporate?->nib,
                    'npwp'                   => $request->npwp ?? $user->detailCorporate?->npwp,
                    'company_address'        => $request->company_address ?? $user->detailCorporate?->company_address ?? '-',
                    'pic_name'               => $request->pic_name_corporate ?? $user->detailCorporate?->pic_name,
                    'pic_national_id_number' => $user->detailCorporate?->pic_national_id_number ?? '-',
                ]
            );

            if ($request->hasFile('pic_ktp')) {
                $ktpPath = $request->file('pic_ktp')->store('documents/ktp', 'public');
                $user->documents()->updateOrCreate(
                    ['document_type' => 'ktp'],
                    ['file' => $ktpPath, 'uploaded_at' => now(), 'verification_status' => 'pending']
                );
            }
        }

        // Community
        if ($user->entity_type === 'community') {
            \App\Models\UserDetailCommunity::updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'community_name'         => $request->community_name ?? $user->detailCommunity?->community_name,
                    'community_type'         => $request->community_type ?? $user->detailCommunity?->community_type ?? '-',
                    'social_media_url'       => $request->social_media_url ?? $user->detailCommunity?->social_media_url,
                    'pic_name'               => $request->pic_name_community ?? $user->detailCommunity?->pic_name,
                    'pic_national_id_number' => $user->detailCommunity?->pic_national_id_number ?? '-',
                ]
            );

            if ($request->hasFile('social_media_screenshot')) {
                $ssPath = $request->file('social_media_screenshot')->store('documents/community', 'public');
                $user->documents()->updateOrCreate(
                    ['document_type' => 'social_media'],
                    ['file' => $ssPath, 'uploaded_at' => now(), 'verification_status' => 'pending']
                );
            }

            if ($request->hasFile('pic_ktp')) {
                $ktpPath = $request->file('pic_ktp')->store('documents/ktp', 'public');
                $user->documents()->updateOrCreate(
                    ['document_type' => 'ktp'],
                    ['file' => $ktpPath, 'uploaded_at' => now(), 'verification_status' => 'pending']
                );
            }
        }


        // Cek password lama kalau mau ganti password
        if ($request->filled('password')) {
            if (empty($request->current_password) || !Hash::check($request->current_password, $user->getAuthPassword())) {
                return response()->json([
                    'success' => false,
                    'errors'  => ['current_password' => 'Password lama tidak sesuai.'],
                ], 422);
            }
        }

        // Update data utama user
        $updateData = [
            'username'       => $request->username,
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
            'bio'            => $request->bio,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $updateData['profile_photo'] = $path;
        }

        $user->update($updateData);


        // Simpan NIK/KTP untuk individual
        if ($user->entity_type === 'individual' && $request->filled('nik')) {
            \Log::info('saving NIK', ['user_id' => $user->user_id, 'nik' => $request->nik]);
            \App\Models\UserDetailIndividual::updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'national_id_number' => $request->nik,
                    'full_name'          => $user->username,
                    'birth_date'         => now()->toDateString(),
                    'gender'             => 'male',
                ]
            );

            if ($request->hasFile('ktp_photo')) {
                $ktpPath = $request->file('ktp_photo')->store('documents/ktp', 'public');
                $user->documents()->updateOrCreate(
                    ['document_type' => 'ktp'],
                    [
                        'file'                => $ktpPath,
                        'uploaded_at'         => now(),
                        'verification_status' => 'pending',
                    ]
                );
            }
        }


        // Update rekening bank
        if ($request->filled('bank_name') && $request->filled('account_number') && $request->filled('account_holder')) {
            $bankData = [
                'bank_name'      => $request->bank_name,
                'account_number' => $request->account_number,
                'account_name'   => $request->account_holder,
            ];

            UserBankAccount::updateOrCreate(
                ['user_id' => $user->user_id],
                $bankData
            );

            // Simpan dokumen buku tabungan baru kalau ada
            if ($request->hasFile('bank_proof')) {
                $bankProofPath = $request->file('bank_proof')->store('documents/bank_proof', 'public');


                // Hapus file lama kalau ada
                $oldDoc = $user->documents()->where('document_type', 'bank_book')->first();
                if ($oldDoc && \Storage::disk('public')->exists($oldDoc->file)) {
                \Storage::disk('public')->delete($oldDoc->file);
}

   $user->documents()->updateOrCreate(
                    ['document_type' => 'bank_book'],
                    [
                        'file'                => $bankProofPath,
                        'uploaded_at'         => now(),
                        'verification_status' => 'pending',
                    ]
                );
            }
        }

        return response()->json(['success' => true]);
    }
}