@extends('layouts.admin')

@section('page-title', 'Create Category')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold">Create New Category</h3>
                    <a href="{{ route('admin.tools.categories.index') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>
                <form action="{{ route('admin.tools.categories.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Technology"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="e.g. technology">
                            <small class="text-muted">The "slug" is the URL-friendly version of the name.</small>
                        </div>

                        {{-- Removed Type Field as this is implicitly Tool Categories --}}



                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control"
                                placeholder="Optional description..."></textarea>
                        </div>

                        <div class="form-group">
                            <label>Styling <span class="text-muted">(Dynamic View)</span></label>
                            <div class="row">
                                <div class="col-6">
                                    <label for="bg_gradient_from" class="small">Gradient From</label>
                                    <input type="color" name="bg_gradient_from" id="bg_gradient_from" class="form-control"
                                        style="height: 38px;" value="#ffffff">
                                </div>
                                <div class="col-6">
                                    <label for="bg_gradient_to" class="small">Gradient To</label>
                                    <input type="color" name="bg_gradient_to" id="bg_gradient_to" class="form-control"
                                        style="height: 38px;" value="#ffffff">
                                </div>
                            </div>
                            <div class="mt-2">
                                <label for="text_color" class="small">Text Color Class</label>
                                <input type="text" name="text_color" id="text_color" class="form-control"
                                    placeholder="e.g. text-white" value="text-white">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white text-right">
                        <button type="submit" class="btn btn-primary font-weight-bold px-4">
                            <i class="fas fa-plus mr-1"></i> Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-slug
        document.getElementById('name').addEventListener('input', function () {
            let slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            document.getElementById('slug').value = slug;
        });
    </script>
@endsection