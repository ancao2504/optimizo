@extends('layouts.admin')

@section('title', 'Edit Tool - ' . $tool->name)

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fas fa-wrench mr-2 text-primary"></i>Edit Tool: <span class="text-muted">{{ $tool->name }}</span>
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.tools.index') }}">Tools</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <form action="{{ route('admin.tools.update', $tool) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Left Column: Main Content -->
                <div class="col-lg-8">
                    
                    <!-- Basic Information Card -->
                    <div class="card card-primary card-outline shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-info-circle mr-1"></i> Basic Information
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Tool Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $tool->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="url">URL Path <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{{ url('/') }}/</span>
                                            </div>
                                            <input type="text" class="form-control @error('url') is-invalid @enderror" 
                                                   id="url" name="url" value="{{ old('url', ltrim($tool->url, '/')) }}" required>
                                        </div>
                                        @error('url')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Short Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $tool->description) }}</textarea>
                                <small class="text-muted">Displayed in tool cards and listings.</small>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Configuration Card -->
                    <div class="card card-secondary card-outline shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-search mr-1"></i> SEO Configuration
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="meta_title">Meta Title</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                       id="meta_title" name="meta_title" value="{{ old('meta_title', $tool->meta_title) }}">
                                @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Recommended length: 50-60 characters.</small>
                            </div>

                            <div class="form-group">
                                <label for="meta_description">Meta Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                          id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $tool->meta_description) }}</textarea>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Recommended length: 150-160 characters.</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                                       value="{{ old('meta_keywords', $tool->meta_keywords) }}" placeholder="keyword1, keyword2, ...">
                            </div>
                        </div>
                    </div>

                    <!-- Icon & Visuals Card -->
                    <div class="card card-info card-outline shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-paint-brush mr-1"></i> Icon & Visuals
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="icon_svg">SVG Code</label>
                                        <textarea class="form-control font-monospace" id="icon_svg" name="icon_svg" rows="6" 
                                                  style="font-size: 0.85rem;">{{ old('icon_svg', $tool->icon_svg) }}</textarea>
                                        <small class="text-muted">Paste raw SVG code here.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="icon_name">Icon Name (Library)</label>
                                        <input type="text" class="form-control" id="icon_name" name="icon_name" 
                                               value="{{ old('icon_name', $tool->icon_name) }}">
                                        <small class="text-muted">Optional: ID or name if using an icon library.</small>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <label>Preview</label>
                                    <div class="border rounded p-4 bg-light d-flex justify-content-center align-items-center" style="height: 150px;">
                                        @if($tool->icon_svg)
                                            <div style="width: 64px; height: 64px;" class="text-primary">
                                                {!! $tool->icon_svg !!}
                                            </div>
                                        @else
                                            <span class="text-muted">No SVG</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Settings & Actions -->
                <div class="col-lg-4">
                    
                    <!-- Publishing Card -->
                    <div class="card card-success card-outline shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Publishing</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" 
                                           {{ old('is_active', $tool->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Active Status</label>
                                </div>
                                <small class="text-muted">Toggle visibility on the public site.</small>
                            </div>
                            
                            <hr>

                            <div class="form-group">
                                <label for="category_id">Category (Parent)</label>
                                <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;">
                                    <option value="">Select Category...</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" class="font-weight-bold" 
                                                {{ old('category_id', $tool->category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>




                            <div class="form-group">
                                <label for="priority">Priority (Sitemap)</label>
                                <input type="number" class="form-control" id="priority" name="priority" 
                                       value="{{ old('priority', $tool->priority) }}" step="0.1" min="0" max="1">
                            </div>

                            <div class="form-group">
                                <label for="change_frequency">Change Frequency</label>
                                <select class="form-control" id="change_frequency" name="change_frequency">
                                    @foreach(['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'] as $freq)
                                        <option value="{{ $freq }}" {{ old('change_frequency', $tool->change_frequency) == $freq ? 'selected' : '' }}>
                                            {{ ucfirst($freq) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="order">Sort Order</label>
                                <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $tool->order) }}">
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <button type="submit" class="btn btn-success btn-block font-weight-bold shadow-sm">
                                <i class="fas fa-save mr-1"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.tools.index') }}" class="btn btn-default btn-block mt-2">
                                <i class="fas fa-times mr-1"></i> Cancel
                            </a>
                        </div>
                    </div>

                    <!-- System Info Card -->
                    <div class="card card-info card-outline shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">System Info</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-sm table-striped mb-0">
                                <tbody>
                                    <tr>
                                        <td><strong>Slug</strong></td>
                                        <td class="text-right text-muted">{{ $tool->slug }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Route</strong></td>
                                        <td class="text-right"><code class="text-xs">{{ $tool->route_name }}</code></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Controller</strong></td>
                                        <td class="text-right"><code class="text-xs">{{ class_basename($tool->controller) }}</code></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Created</strong></td>
                                        <td class="text-right text-xs">{{ $tool->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Last Updated</strong></td>
                                        <td class="text-right text-xs">{{ $tool->updated_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    /* Custom switch styling match admin theme */
    .custom-switch-on-success .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #28a745;
        border-color: #28a745;
    }
</style>
@endpush
@endsection
