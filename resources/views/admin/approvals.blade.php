<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Pending Approvals</h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded">
        @if(session('status'))
            <div class="mb-4 text-green-600">{{ session('status') }}</div>
        @endif

        <table class="min-w-full">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingUsers as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <form action="{{ route('admin.approve', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-green-600 hover:underline">Approve</button>
                            </form>
                            <form action="{{ route('admin.reject', $user->id) }}" method="POST" class="inline ml-2">
                                @csrf
                                <button class="text-red-600 hover:underline">Reject</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">No pending users</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
