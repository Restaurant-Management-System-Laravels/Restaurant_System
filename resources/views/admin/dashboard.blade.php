<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">👑 Admin Dashboard</h2>
    </x-slot>

    <div class="admin-dashboard">

        {{-- ✅ Success Message --}}
        @if (session('status'))
            <div class="alert-success">
                <span>✔ {{ session('status') }}</span>
            </div>
        @endif

        {{-- 📊 Dashboard Summary --}}
        <div class="summary-grid">
            <div class="summary-card">
                <h3>Total Pending Users</h3>
                <p class="value pending">{{ $pendingUsers->count() }}</p>
            </div>

            <div class="summary-card">
                <h3>Approved Cashiers</h3>
                <p class="value cashier">
                    {{ \App\Models\User::where('role', 'cashier')->where('is_approved', true)->count() }}
                </p>
            </div>

            <div class="summary-card">
                <h3>Approved Kitchens</h3>
                <p class="value kitchen">
                    {{ \App\Models\User::where('role', 'kitchen')->where('is_approved', true)->count() }}
                </p>
            </div>
        </div>

        {{-- 🧍 Pending Approvals --}}
        <div class="table-wrapper">
            <div class="table-header">
                <h3>Pending Approvals</h3>
                <span class="pending-badge">{{ $pendingUsers->count() }} Pending</span>
            </div>

            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendingUsers as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="role {{ $user->role }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.approve', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="btn approve">Approve</button>
                                </form>
                                <form action="{{ route('admin.reject', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="btn reject">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty">No pending users 🎉</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Inline Styles --}}
    <style>
        /* ======== Admin Dashboard Styles ======== */
        .admin-dashboard {
            background: #f9fafb;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .dashboard-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #dcfce7;
            border: 1px solid #86efac;
            color: #166534;
            padding: 10px 15px;
            border-radius: 8px;
            margin: 0 auto 25px;
            max-width: 900px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }

        /* Summary Cards */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 900px;
            margin: 0 auto 40px;
        }

        .summary-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.06);
            padding: 25px;
            text-align: center;
            transition: 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .summary-card h3 {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .summary-card .value {
            font-size: 2rem;
            font-weight: 700;
        }

        .value.pending { color: #2563eb; }
        .value.cashier { color: #16a34a; }
        .value.kitchen { color: #15803d; }

        /* Table */
        .table-wrapper {
            background: #fff;
            border-radius: 12px;
            max-width: 900px;
            margin: 0 auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 20px;
        }

        .table-header h3 {
            font-weight: 600;
            font-size: 1.1rem;
            color: #1e293b;
        }

        .pending-badge {
            background: #dbeafe;
            color: #1d4ed8;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
        }

        /* Table Core */
        .dashboard-table {
            width: 100%;
            border-collapse: collapse;
        }

        .dashboard-table th,
        .dashboard-table td {
            padding: 14px 18px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
            text-align: center; 
        }

        .dashboard-table th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .dashboard-table tr:hover {
            background: #f1f5f9;
        }

        /* Role Badges */
        .role {
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .role.cashier {
            background: #fef9c3;
            color: #854d0e;
        }

        .role.kitchen {
            background: #f3e8ff;
            color: #6b21a8;
        }

.dashboard-table th:nth-child(4),
.dashboard-table td:nth-child(4) {
    text-align: center; /* Center the buttons */
}

.inline {
    display: inline-block;
}


        /* Buttons */
        .btn {
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: 500;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease;
            margin: 0 6px;
        }

        .btn.approve {
            background: #16a34a;
        }

        .btn.approve:hover {
            background: #15803d;
        }

        .btn.reject {
            background: #dc2626;
        }

        .btn.reject:hover {
            background: #b91c1c;
        }

        /* Empty State */
        .empty {
            text-align: center;
            color: #94a3b8;
            padding: 20px;
            font-style: italic;
        }
    </style>
</x-app-layout>
