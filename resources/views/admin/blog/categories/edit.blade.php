@extends('layouts.admin')

@section('page-title', 'Edit Category')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold">Edit Category: {{ $category->name }}</h3>
                    <a href="{{ route('admin.blog.categories.index') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>
                <form action="{{ route('admin.blog.categories.update', $category->id) }}" method="POST">
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
                        </div>                        <div class="form-group">
                            <label for="language_code">Language</label>
                            <select name="language_code" id="language_code" class="form-control" required>
                                @foreach($languages as $lang)
                                    <option value="{{ $lang->code }}" {{ $category->language_code == $lang->code ? 'selected' : '' }}>
                                        {{ $lang->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Parent Category</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">None (Top Level)</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" value="{{ $category->meta_title }}"
                                class="form-control" placeholder="Optional SEO title...">
                        </div>

                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="2" class="form-control"
                                placeholder="Optional SEO description (max 255)...">{{ $category->meta_description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="content">Category Content</label>
                            <textarea name="content" id="content" rows="6"
                                class="form-control">{{ $category->content }}</textarea>
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