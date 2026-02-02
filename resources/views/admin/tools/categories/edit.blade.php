@extends('layouts.admin')

@section('page-title', 'Edit Category')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold">Edit Category: {{ $category->name }}</h3>
                    <a href="{{ route('admin.tools.categories.index') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>
                <form action="{{ route('admin.tools.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="{{ $category->name }}" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" id="slug" value="{{ $category->slug }}" class="form-control">
                        </div>



                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="form-control">{{ $category->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Styling <span class="text-muted">(Dynamic View)</span></label>
                            <div class="row">
                                <div class="col-6">
                                    <label for="bg_gradient_from" class="small">Gradient From</label>
                                    <input type="color" name="bg_gradient_from" id="bg_gradient_from" class="form-control"
                                        style="height: 38px;" value="{{ $category->bg_gradient_from }}">
                                </div>
                                <div class="col-6">
                                    <label for="bg_gradient_to" class="small">Gradient To</label>
                                    <input type="color" name="bg_gradient_to" id="bg_gradient_to" class="form-control"
                                        style="height: 38px;" value="{{ $category->bg_gradient_to }}">
                                </div>
                            </div>
                            <div class="mt-2">
                                <label for="text_color" class="small">Text Color Class</label>
                                <input type="text" name="text_color" id="text_color" class="form-control"
                                    placeholder="e.g. text-white" value="{{ $category->text_color }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white text-right">
                        <button type="submit" class="btn btn-primary font-weight-bold px-4">
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-slug script logic matching index
        document.getElementById('name').addEventListener('input', function () {
            let slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            document.getElementById('slug').value = slug;
        });
    </script>
@endsection