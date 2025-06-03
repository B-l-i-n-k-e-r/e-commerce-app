@extends('admin.layouts.app') {{-- Assuming you have an admin layout --}}

@section('content')
    <h1>Pending Password Reset Requests</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    @if ($passwordRequests->isEmpty())
        <p>No pending password reset requests.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>Requested At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($passwordRequests as $request)
                    <tr>
                        <td>{{ $request->name }}</td>
                        <td>{{ $request->email }}</td>
                        <td>{{ $request->password_reset_requested_at }}</td>
                        <td>
                            <form action="{{ route('admin.password.requests.approve', $request) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                            </form>
                            <form action="{{ route('admin.password.requests.reject', $request) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger ml-2">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
}
