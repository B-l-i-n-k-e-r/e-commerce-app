@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="flex justify-between items-center mb-4 pt-4">
            <h2 class="h3 mb-0 text-blue-400">Manage Users</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow mb-4 bg-gray-800">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-purple-700">User List</h6>
            </div>
                <a href="{{ route('admin.users.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Create New User
                </a>
            </div>
            <div class="card-body">
                <div class="bg-white rounded-md shadow-md overflow-x-auto">
                    <table id="usersTable" class="min-w-full table-auto divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email Verified</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($user->email_verified_at)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Yes ({{ $user->email_verified_at->format('Y-m-d H:i') }})
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                No
                                            </span>
                                            <form action="{{ route('admin.users.verify', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="ml-2 px-2.5 py-0.5 rounded-md text-xs font-medium bg-green-500 hover:bg-green-700 text-white">Verify</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($user->is_admin)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Admin
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                User
                                            </span>
                                            <form action="{{ route('admin.users.makeAdmin', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="ml-2 px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-500 hover:bg-blue-700 text-white">Make Admin</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="px-4 py-2 rounded-md text-xs font-medium bg-blue-500 hover:bg-blue-700 text-white">Edit</a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 rounded-md text-xs font-medium bg-red-500 hover:bg-red-700 text-white" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-400">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{ $users->links() }}
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                order: [[0, "asc"]],
                columnDefs: [
                    { targets: [3, 4, 5], orderable: false },
                    { targets: [5], searchable: false }
                ],
                language: {
                    paginate: {
                        previous: "<i class='fas fa-chevron-left'></i>",
                        next: "<i class='fas fa-chevron-right'></i>"
                    },
                    search: "<i class='fas fa-search'></i>",
                    lengthMenu: "Show _MENU_ entries",
                    emptyTable: "No users found",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    zeroRecords: "No matching records found"
                },
                classes: {
                    sPageButton: "btn btn-link",
                    sPageButtonActive: "active",
                    sPageButtonDisabled: "disabled"
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).find('td').addClass('border');
                },
                dom: 'lfrtip',
                "displayLength": 10,
            });
            $('#usersTable thead tr').addClass('border bg-gray-700 text-white');
            $('#usersTable tbody tr').addClass('bg-dark text-white');
        });
    </script>
@endpush