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
        return view('user.edit-profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username'       => ['required', 'string', 'max:50', 'regex:/^[\pL\s]+$/u'],
            'email'          => ['required', 'email', Rule::unique('tb_users', 'email')->ignore($user->user_id, 'user_id')],
            'contact_number' => ['required', 'digits_between:10,15', Rule::unique('tb_users', 'contact_number')->ignore($user->user_id, 'user_id')],
            'bio'            => ['nullable', 'string', 'max:500'],
            'profile_photo'  => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'current_password' => ['nullable', 'string'],
            'password'         => ['nullable', 'string', 'min:8', 'confirmed'],
            'bank_name'        => ['nullable', 'string', 'max:50'],
            'account_number'   => ['nullable', 'string', 'max:20'],
            'account_holder'   => ['nullable', 'string', 'max:255'],
        ]);

        // Cek password lama kalau mau ganti password
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'errors'  => ['current_password' => 'Password lama tidak sesuai.']
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

        // Update rekening bank
        if ($request->filled('bank_name') && $request->filled('account_number') && $request->filled('account_holder')) {
            UserBankAccount::updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'bank_name'      => $request->bank_name,
                    'account_number' => $request->account_number,
                    'account_name'   => $request->account_holder,
                ]
            );
        }

        return response()->json(['success' => true]);
    }
}