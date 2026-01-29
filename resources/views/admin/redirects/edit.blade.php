@extends('layouts.admin')

@section('page-title', 'Edit Redirect')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Redirect</h3>
        </div>
        <form action="{{ route('admin.redirects.update', $redirect) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="from_url">From URL</label>
                    <input type="text" name="from_url" id="from_url"
                        class="form-control @error('from_url') is-invalid @enderror"
                        value="{{ old('from_url', $redirect->from_url) }}">
                    @error('from_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="to_url">To URL</label>
                    <input type="url" name="to_url" id="to_url" class="form-control @error('to_url') is-invalid @enderror"
                        value="{{ old('to_url', $redirect->to_url) }}">
                    @error('to_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type">Redirect Type</label>
                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                        <option value="301" {{ old('type', $redirect->type) == '301' ? 'selected' : '' }}>301 (Permanent)
                        </option>
                        <option value="302" {{ old('type', $redirect->type) == '302' ? 'selected' : '' }}>302 (Temporary)
                        </option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="status" name="status" {{ old('status', $redirect->status) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status">Active</label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Redirect</button>
                <a href="{{ route('admin.redirects.index') }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
@endsection