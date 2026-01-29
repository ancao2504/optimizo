@extends('layouts.admin')

@section('page-title', 'Add Redirect')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add New Redirect</h3>
        </div>
        <form action="{{ route('admin.redirects.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="from_url">From URL</label>
                    <input type="text" name="from_url" id="from_url"
                        class="form-control @error('from_url') is-invalid @enderror" placeholder="e.g., /old-page"
                        value="{{ old('from_url') }}">
                    @error('from_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="to_url">To URL</label>
                    <input type="url" name="to_url" id="to_url" class="form-control @error('to_url') is-invalid @enderror"
                        placeholder="https://example.com/new-page" value="{{ old('to_url') }}">
                    @error('to_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type">Redirect Type</label>
                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                        <option value="301" {{ old('type') == '301' ? 'selected' : '' }}>301 (Permanent)</option>
                        <option value="302" {{ old('type') == '302' ? 'selected' : '' }}>302 (Temporary)</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="status" name="status" {{ old('status', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status">Active</label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save Redirect</button>
                <a href="{{ route('admin.redirects.index') }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
@endsection