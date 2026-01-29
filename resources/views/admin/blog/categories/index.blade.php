@extends('layouts.admin')

@section('page-title', ucfirst($type) . ' Categories')

@section('content')
    <div class="row" x-data="categoryManager()">
        <!-- Quick Create Form -->
        <div class="col-md-4">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">Add New {{ ucfirst($type) }} Category</h3>
                </div>
                <form action="{{ route('admin.blog.categories.store') }}" method="POST">
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

                        <div class="form-group">
                            <label for="language_code">Language</label>
                            <select name="language_code" id="language_code" class="form-control" x-model="language"
                                @change="onLanguageChange()" required>
                                @foreach($languages as $lang)
                                    <option value="{{ $lang->code }}">{{ $lang->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Parent Category <span class="text-muted">(Optional)</span></label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">None (Top Level)</option>
                                <template x-for="p in filteredParents" :key="p.id">
                                    <option :value="p.id" x-text="p.name"></option>
                                </template>
                            </select>
                            <small class="text-muted" x-show="filteredParents.length === 0">No parent categories for this
                                language.</small>
                        </div>

                        <div class="form-group">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control"
                                placeholder="Optional SEO title...">
                        </div>

                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="2" class="form-control"
                                placeholder="Optional SEO description (max 255)..."></textarea>
                        </div>

                        <div class="form-group">
                            <label for="content">Category Content</label>
                            <textarea name="content" id="content" rows="4" class="form-control"
                                placeholder="Main category content..."></textarea>
                        </div>
                    </div>
                    <div class="card-footer bg-white text-right">
                        <button type="submit" class="btn btn-primary font-weight-bold">
                            <i class="fas fa-plus mr-1"></i> Add Category
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Category List -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title font-weight-bold">All {{ ucfirst($type) }} Categories</h3>
                    <div class="card-tools d-flex">
                        <form action="{{ route('admin.blog.categories.index') }}" method="GET" class="d-flex mr-2">
                            <select name="language" class="form-control form-control-sm mr-1" onchange="this.form.submit()">
                                <option value="">All Languages</option>
                                @foreach($languages as $lang)
                                    <option value="{{ $lang->code }}" {{ request('language') == $lang->code ? 'selected' : '' }}>
                                        {{ $lang->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="search" class="form-control" placeholder="Search"
                                    value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Lang</th>
                                <th>Parent</th>
                                <th>Slug</th>
                                <th>Count</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>
                                        <span class="font-weight-bold text-primary">{{ $category->name }}</span>
                                        <div class="small text-muted">{{ Str::limit($category->meta_description, 30) }}</div>
                                    </td>
                                    <td><span
                                            class="badge badge-light border text-uppercase">{{ $category->language_code }}</span>
                                    </td>
                                    <td>
                                        @if($category->parent)
                                            <span class="badge badge-info">{{ $category->parent->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        @if($type === 'tool')
                                            <span class="badge badge-light border">{{ $category->tools_count ?? 0 }}</span>
                                        @else
                                            <span class="badge badge-light border">{{ $category->posts_count }}</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.blog.categories.edit', $category->id) }}"
                                            class="btn btn-sm btn-info mr-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.blog.categories.destroy', $category->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Are you sure?');">
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
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fas fa-folder-open fa-2x mb-2"></i>
                                        <p>No categories found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $categories->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <script>
        function categoryManager() {
            return {
                language: 'en',
                allParents: @json($parents),
                filteredParents: [],
                init() {
                    this.onLanguageChange();
                },
                onLanguageChange() {
                    this.filteredParents = this.allParents.filter(p => p.language_code === this.language);
                }
            }
        }

        // Auto-slug
        document.getElementById('name').addEventListener('input', function () {
            let slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            document.getElementById('slug').value = slug;
        });
    </script>
@endsection