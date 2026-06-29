<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $campaignCountSub = DB::table('tb_campaigns')
            ->selectRaw('COUNT(*)')
            ->whereColumn('tb_campaigns.user_id', 'tb_users.user_id');

        $totalDonationSub = DB::table('tb_donations')
            ->selectRaw('COALESCE(SUM(amount), 0)')
            ->whereColumn('tb_donations.user_id', 'tb_users.user_id')
            ->where('payment_status', 'success');

        $users = User::with([
                'bankAccount',
                'documents',
                'detailIndividual',
                'detailCorporate',
                'detailFoundation',
                'detailCommunity',
            ])
            ->select('tb_users.*')
            ->selectSub($campaignCountSub, 'campaign_count')
            ->selectSub($totalDonationSub, 'total_donation')
            ->when($request->q, function ($query, $q) {
                $query->where(function ($subQuery) use ($q) {
                    $subQuery->where('username', 'like', '%' . $q . '%')
                        ->orWhere('email', 'like', '%' . $q . '%');
                });
            })
            ->when($request->role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->when($request->entity_type, function ($query, $entityType) {
                $query->where('entity_type', $entityType);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('account_status', $status);
            })
            ->when($request->bank_status, function ($query, $bankStatus) {
                if ($bankStatus === 'complete') {
                    $query->where('role', 'user')
                        ->whereHas('bankAccount');
                }

                if ($bankStatus === 'incomplete') {
                    $query->where('role', 'user')
                        ->whereDoesntHave('bankAccount');
                }

                if ($bankStatus === 'not_applicable') {
                    $query->where('role', 'admin');
                }
            })
            ->when($request->document_status, function ($query, $documentStatus) {
                if ($documentStatus === 'not_applicable') {
                    $query->where('role', 'admin');
                }

                if ($documentStatus === 'pending') {
                    $query->where('role', 'user')
                        ->whereHas('documents', function ($docQuery) {
                            $docQuery->where('verification_status', 'pending');
                        });
                }

                if ($documentStatus === 'rejected') {
                    $query->where('role', 'user')
                        ->whereHas('documents', function ($docQuery) {
                            $docQuery->where('verification_status', 'rejected');
                        });
                }

                if ($documentStatus === 'verified') {
                    $query->where('role', 'user')
                        ->where(function ($subQuery) {
                            $this->applyVerifiedDocumentFilter($subQuery);
                        });
                }

                if ($documentStatus === 'incomplete') {
                    $query->where('role', 'user')
                        ->where(function ($subQuery) {
                            $this->applyIncompleteDocumentFilter($subQuery);
                        });
                }
            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        $summary = [
            'total_users' => User::count(),
            'active_users' => User::where('account_status', 'active')->count(),
            'complete_bank_accounts' => User::where('role', 'user')->whereHas('bankAccount')->count(),
            'incomplete_bank_accounts' => User::where('role', 'user')->whereDoesntHave('bankAccount')->count(),
            'verified_documents' => $this->verifiedDocumentUsersCount(),
        ];

        return view('admin.users.index', compact('users', 'summary'));
    }

    public function show($id)
    {
        $campaignCountSub = DB::table('tb_campaigns')
            ->where('user_id', $id)
            ->count();

        $totalDonation = DB::table('tb_donations')
            ->where('user_id', $id)
            ->where('payment_status', 'success')
            ->sum('amount');

        $user = User::with([
            'bankAccount',
            'documents',
            'detailIndividual',
            'detailCorporate',
            'detailFoundation',
            'detailCommunity',
        ])->findOrFail($id);

        return view('admin.users.show', [
            'user' => $user,
            'campaignCount' => $campaignCountSub,
            'totalDonation' => $totalDonation,
        ]);
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()
                ->back()
                ->with('error', 'Akun admin tidak dapat dinonaktifkan.');
        }

        $user->update([
            'account_status' => $user->account_status === 'active' ? 'suspended' : 'active',
        ]);

        $message = $user->account_status === 'active'
            ? 'Akun user berhasil diaktifkan kembali.'
            : 'Akun user berhasil dinonaktifkan.';

        return redirect()
            ->back()
            ->with('success', $message);
    }

    public function approveDocument($userId, $documentId)
    {
        $document = DB::table('tb_user_documents')
            ->where('user_id', $userId)
            ->where('user_document_id', $documentId)
            ->first();

        if (!$document) {
            return redirect()
                ->back()
                ->with('error', 'Dokumen tidak ditemukan.');
        }

        DB::table('tb_user_documents')
            ->where('user_id', $userId)
            ->where('user_document_id', $documentId)
            ->update([
                'verification_status' => 'approved',
                'rejection_reason' => null,
            ]);

        return redirect()
            ->back()
            ->with('success', 'Dokumen berhasil disetujui.');
    }

    public function rejectDocument($userId, $documentId)
    {
        $document = DB::table('tb_user_documents')
            ->where('user_id', $userId)
            ->where('user_document_id', $documentId)
            ->first();

        if (!$document) {
            return redirect()
                ->back()
                ->with('error', 'Dokumen tidak ditemukan.');
        }

        DB::table('tb_user_documents')
            ->where('user_id', $userId)
            ->where('user_document_id', $documentId)
            ->update([
                'verification_status' => 'rejected',
                'rejection_reason' => 'Dokumen belum sesuai atau perlu diperbaiki.',
            ]);

        return redirect()
            ->back()
            ->with('success', 'Dokumen berhasil ditolak.');
    }

    public function viewDocument($userId, $documentId)
    {
        $document = DB::table('tb_user_documents')
            ->where('user_id', $userId)
            ->where('user_document_id', $documentId)
            ->first();

        if (!$document) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        $filePath = ltrim($document->file, '/');

        $possiblePaths = [
            storage_path('app/public/' . $filePath),
            storage_path('app/private/' . $filePath),
            storage_path('app/' . $filePath),
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return response()->file($path);
            }
        }

        abort(404, 'File dokumen tidak ditemukan di storage.');
    }
    private function applyVerifiedDocumentFilter($query)
    {
        $query->where(function ($entityQuery) {
            $entityQuery
                ->where(function ($q) {
                    $q->where('entity_type', 'individual')
                        ->whereHas('documents', function ($doc) {
                            $doc->where('document_type', 'ktp')
                                ->where('verification_status', 'approved');
                        })
                        ->whereHas('documents', function ($doc) {
                            $doc->where('document_type', 'social_media')
                                ->where('verification_status', 'approved');
                        });
                })
                ->orWhere(function ($q) {
                    $q->where('entity_type', 'foundation')
                        ->whereHas('documents', function ($doc) {
                            $doc->where('document_type', 'ktp')
                                ->where('verification_status', 'approved');
                        })
                        ->whereHas('documents', function ($doc) {
                            $doc->where('document_type', 'sk_kemenkumham')
                                ->where('verification_status', 'approved');
                        });
                })
                ->orWhere(function ($q) {
                    $q->where('entity_type', 'corporate')
                        ->whereHas('documents', function ($doc) {
                            $doc->where('document_type', 'ktp')
                                ->where('verification_status', 'approved');
                        })
                        ->whereHas('documents', function ($doc) {
                            $doc->where('document_type', 'nib')
                                ->where('verification_status', 'approved');
                        })
                        ->whereHas('documents', function ($doc) {
                            $doc->where('document_type', 'npwp')
                                ->where('verification_status', 'approved');
                        });
                })
                ->orWhere(function ($q) {
                    $q->where('entity_type', 'community')
                        ->whereHas('documents', function ($doc) {
                            $doc->where('document_type', 'ktp')
                                ->where('verification_status', 'approved');
                        })
                        ->whereHas('documents', function ($doc) {
                            $doc->where('document_type', 'social_media')
                                ->where('verification_status', 'approved');
                        });
                });
        });
    }

    private function applyIncompleteDocumentFilter($query)
    {
        $query->where(function ($entityQuery) {
            $entityQuery
                ->whereDoesntHave('documents')
                ->orWhere(function ($q) {
                    $q->where('entity_type', 'individual')
                        ->where(function ($missing) {
                            $missing->whereDoesntHave('documents', function ($doc) {
                                $doc->where('document_type', 'ktp');
                            })
                            ->orWhereDoesntHave('documents', function ($doc) {
                                $doc->where('document_type', 'social_media');
                            });
                        });
                })
                ->orWhere(function ($q) {
                    $q->where('entity_type', 'foundation')
                        ->where(function ($missing) {
                            $missing->whereDoesntHave('documents', function ($doc) {
                                $doc->where('document_type', 'ktp');
                            })
                            ->orWhereDoesntHave('documents', function ($doc) {
                                $doc->where('document_type', 'sk_kemenkumham');
                            });
                        });
                })
                ->orWhere(function ($q) {
                    $q->where('entity_type', 'corporate')
                        ->where(function ($missing) {
                            $missing->whereDoesntHave('documents', function ($doc) {
                                $doc->where('document_type', 'ktp');
                            })
                            ->orWhereDoesntHave('documents', function ($doc) {
                                $doc->where('document_type', 'nib');
                            })
                            ->orWhereDoesntHave('documents', function ($doc) {
                                $doc->where('document_type', 'npwp');
                            });
                        });
                })
                ->orWhere(function ($q) {
                    $q->where('entity_type', 'community')
                        ->where(function ($missing) {
                            $missing->whereDoesntHave('documents', function ($doc) {
                                $doc->where('document_type', 'ktp');
                            })
                            ->orWhereDoesntHave('documents', function ($doc) {
                                $doc->where('document_type', 'social_media');
                            });
                        });
                });
        });
    }

    private function verifiedDocumentUsersCount()
    {
        return User::where('role', 'user')
            ->where(function ($query) {
                $this->applyVerifiedDocumentFilter($query);
            })
            ->count();
    }
}