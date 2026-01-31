@extends('layouts.admin')

@section('title', 'Users Management')
@section('page-title', 'Users Management')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-users-cog"></i> Users Management</h3>
                    @if(auth()->user()->role === 'super_admin')
                        <div class="card-tools">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add New User
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <table id="usersTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                            <span class="badge badge-info">You</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->roleModel)
                                            @if($user->roleModel->slug === 'super_admin')
                                                <span class="badge badge-danger">{{ $user->roleModel->name }}</span>
                                            @elseif($user->roleModel->slug === 'admin')
                                                <span class="badge badge-warning">{{ $user->roleModel->name }}</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $user->roleModel->name }}</span>
                                            @endif
                                        @else
                                            <span class="badge badge-secondary">No Role</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if(auth()->user()->hasRole('super_admin'))
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                    class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Initialize DataTable
            $('#usersTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "order": [[3, "desc"]]
            });

            // Handle delete confirmation
            $('.delete-btn').on('click', function (e) {
                e.preventDefault();
                const form = $(this).closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This user will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Show success/error messages
            @if(session('success'))
                toast('{{ session('success') }}', 'success');
            @endif

            @if(session('error'))
                toast('{{ session('error') }}', 'error');
            @endif
            });
    </script>
@endpush