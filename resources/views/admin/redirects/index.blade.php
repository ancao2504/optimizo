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
            <div class="card card-outline card-primary mb-4">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filter Redirects</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.redirects.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>From URL</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-link"></i></span>
                                        </div>
                                        <input type="text" name="from_url" class="form-control" placeholder="/old-path" value="{{ request('from_url') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>To URL</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-route"></i></span>
                                        </div>
                                        <input type="text" name="to_url" class="form-control" placeholder="https://new-path..." value="{{ request('to_url') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="type" class="form-control">
                                        <option value="">All Types</option>
                                        <option value="301" {{ request('type') == '301' ? 'selected' : '' }}>301 Permanent</option>
                                        <option value="302" {{ request('type') == '302' ? 'selected' : '' }}>302 Temporary</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">All Statuses</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="form-group w-100">
                                    <button type="submit" class="btn btn-primary w-100 mb-2">
                                        <i class="fas fa-search mr-1"></i> Filter
                                    </button>
                                    @if(request()->anyFilled(['from_url', 'to_url', 'type', 'status']))
                                        <a href="{{ route('admin.redirects.index') }}" class="btn btn-default w-100">
                                            Reset
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <table class="table table-bordered table-striped">
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
                    @forelse($redirects as $redirect)
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
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No redirects found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $redirects->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection