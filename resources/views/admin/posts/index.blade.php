@extends('layouts.admin')

@section('page-title', 'Posts')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Posts</h3>
            <div class="card-tools">
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> New Post
                </a>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="card-body py-2 border-bottom">
            <form action="{{ route('admin.posts.index') }}" method="GET" class="d-flex align-items-center"
                style="gap:10px;">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..."
                    value="{{ request('search') }}" style="flex:1; min-width:200px;">
                <select name="language" class="form-control form-control-sm" style="max-width:150px;">
                    <option value="">All Languages</option>
                    @foreach($languages as $lang)
                        <option value="{{ $lang->code }}" {{ request('language') == $lang->code ? 'selected' : '' }}>
                            {{ $lang->name }}
                        </option>
                    @endforeach
                </select>
                <select name="category_id" class="form-control form-control-sm" style="max-width:180px;">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }} ({{ $category->language_code }})
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-default btn-sm">
                    <i class="fas fa-filter"></i> Filter
                </button>
                @if(request()->anyFilled(['search', 'category_id', 'status', 'language']))
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-link btn-sm text-muted"
                        style="white-space:nowrap;">Clear All</a>
                @endif
            </form>
        </div>

        <!-- WordPress-style Status Tabs -->
        <div class="card-body py-2 border-bottom">
            @php
                $currentStatus = request('status', 'published');
                $otherParams = request()->except(['status', 'page']);
            @endphp
            <ul class="subsubsub"
                style="list-style:none; padding:0; margin:0; display:flex; gap:5px; flex-wrap:wrap; font-size:13px;">
                <li>
                    <a href="{{ route('admin.posts.index', array_merge($otherParams, ['status' => 'all'])) }}"
                        class="{{ $currentStatus == 'all' ? 'font-weight-bold text-dark' : 'text-muted' }}"
                        style="text-decoration:none;">
                        All <span class="text-muted">({{ $statusCounts['all'] }})</span>
                    </a> |
                </li>
                <li>
                    <a href="{{ route('admin.posts.index', array_merge($otherParams, ['status' => 'published'])) }}"
                        class="{{ $currentStatus == 'published' ? 'font-weight-bold text-dark' : 'text-muted' }}"
                        style="text-decoration:none;">
                        Published <span class="text-muted">({{ $statusCounts['published'] }})</span>
                    </a> |
                </li>
                <li>
                    <a href="{{ route('admin.posts.index', array_merge($otherParams, ['status' => 'draft'])) }}"
                        class="{{ $currentStatus == 'draft' ? 'font-weight-bold text-dark' : 'text-muted' }}"
                        style="text-decoration:none;">
                        Draft <span class="text-muted">({{ $statusCounts['draft'] }})</span>
                    </a> |
                </li>
                <li>
                    <a href="{{ route('admin.posts.index', array_merge($otherParams, ['status' => 'scheduled'])) }}"
                        class="{{ $currentStatus == 'scheduled' ? 'font-weight-bold text-dark' : 'text-muted' }}"
                        style="text-decoration:none;">
                        Scheduled <span class="text-muted">({{ $statusCounts['scheduled'] }})</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body p-0">
            <table id="postsTable" class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th style="width: 40%">Title</th>
                        <th>Author</th>
                        <th>Lang</th>
                        <th>Categories</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>
                                <strong>{{ $post->title }}</strong><br>
                                <small class="text-muted">{{ Str::limit(strip_tags($post->content), 80) }}</small>
                            </td>
                            <td>{{ $post->author->name }}</td>
                            <td><span class="badge badge-light border text-uppercase">{{ $post->language_code }}</span></td>
                            <td>
                                @foreach($post->categories as $category)
                                    <span class="badge badge-info">{{ $category->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($post->status === 'published')
                                    <span class="badge badge-success">Published</span>
                                @elseif($post->status === 'scheduled')
                                    <span class="badge badge-warning">Scheduled</span>
                                @else
                                    <span class="badge badge-secondary">Draft</span>
                                @endif
                            </td>
                            <td>{{ $post->created_at->format('M d, Y') }}</td>
                            <td class="text-right">
                                <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-sm btn-outline-success"
                                    target="_blank" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-info"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="deletePost({{ $post->id }})" class="btn btn-sm btn-outline-danger"
                                    title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No posts found matching your filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $posts->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#postsTable').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false, // Disable DataTables search
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });

        function deletePost(id) {
            confirmDelete('', function () {
                $.ajax({
                    url: `/admin/posts/${id}`,
                    type: 'DELETE',
                    success: function (response) {
                        toast(response.message, 'success');
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function (xhr) {
                        toast('Error deleting post', 'error');
                    }
                });
            });
        }
    </script>
@endpush