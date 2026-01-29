@extends('layouts.admin')

@section('page-title', 'URL Redirects')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">URL Redirects</h3>
            <div class="card-tools">
                <a href="{{ route('admin.redirects.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add Redirect
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="redirectsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>From URL</th>
                        <th>To URL</th>
                        <th>Type</th>
                        <th>Hits</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($redirects as $redirect)
                        <tr>
                            <td>{{ $redirect->from_url }}</td>
                            <td>{{ Str::limit($redirect->to_url, 50) }}</td>
                            <td>
                                <span class="badge badge-{{ $redirect->type === '301' ? 'primary' : 'warning' }}">
                                    {{ $redirect->type }}
                                </span>
                            </td>
                            <td>{{ $redirect->hits }}</td>
                            <td>
                                <span class="badge badge-{{ $redirect->status ? 'success' : 'secondary' }}">
                                    {{ $redirect->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.redirects.edit', $redirect) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.redirects.destroy', $redirect) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this redirect?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $redirects->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#redirectsTable').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endpush