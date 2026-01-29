@extends('layouts.admin')

@section('page-title', 'Create Post')

@section('content')
    <div x-data="postEditor()" class="pb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-1 text-dark font-weight-bold">Create New Post</h5>
                <small class="text-muted">Write something amazing today.</small>
            </div>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back to Posts
            </a>
        </div>

        <form id="postForm">
            @csrf
            <div class="row">
                <!-- LEFT COLUMN (Main Content) -->
                <div class="col-lg-8">

                    <!-- Title & Slug -->
                    <div class="card card-outline card-primary shadow-sm mb-4">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="font-weight-bold text-uppercase text-xs text-muted">Post Title</label>
                                <input type="text" name="title" id="title" required class="form-control form-control-lg"
                                    placeholder="Enter an engaging title...">
                            </div>
                            <div class="form-group mb-0">
                                <label class="font-weight-bold text-uppercase text-xs text-muted">Permalink</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light text-muted">{{ url('/blog') }}/</span>
                                    </div>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        placeholder="auto-generated-slug">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Editor -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body p-0">
                            <textarea name="content" id="content" style="height: 600px; opacity: 0;"></textarea>
                        </div>
                    </div>


                    <!-- SEO Section -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h3 class="card-title font-weight-bold text-dark" style="font-size: 1rem;">
                                <i class="fas fa-search mr-1 text-primary"></i> SEO Configuration
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Meta Title</label>
                                <input type="text" name="meta_title" class="form-control"
                                    placeholder="Defaults to post title">
                            </div>
                            <div class="form-group">
                                <label>Meta Description</label>
                                <textarea name="meta_description" rows="2" class="form-control"
                                    placeholder="Optimal length: 150-160 characters"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN (Sidebar) -->
                <div class="col-lg-4">

                    <!-- Language Selection -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white font-weight-bold text-uppercase text-xs text-muted">
                            Language
                        </div>
                        <div class="card-body">
                            <select name="language_code" x-model="language" @change="onLanguageChange()"
                                class="form-control custom-select">
                                @foreach($languages as $lang)
                                    <option value="{{ $lang->code }}">{{ $lang->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted mt-2 d-block">Categories will filter based on this
                                language.</small>
                        </div>
                    </div>

                    <!-- Publish Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white font-weight-bold text-uppercase text-xs text-muted">
                            Publishing
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control custom-select">
                                    <option value="published">Published</option>
                                    <option value="draft">Draft</option>
                                    <option value="scheduled">Scheduled</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Publish Date</label>
                                <input type="datetime-local" name="published_at" class="form-control">
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary btn-block font-weight-bold py-2 shadow-sm">
                                    Publish Post
                                </button>
                                <button type="button" @click="saveDraft()" class="btn btn-default btn-block mt-2">
                                    Save Draft
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white font-weight-bold text-uppercase text-xs text-muted">
                            Featured Image
                        </div>
                        <div class="card-body text-center">
                            <input type="hidden" name="featured_image" x-model="featuredImage">

                            <!-- Placeholder -->
                            <div x-show="!featuredImage"
                                @click="$dispatch('open-media-modal', { onSelect: handleFeaturedImage })"
                                class="rounded border-dashed border-2 border-secondary d-flex flex-column align-items-center justify-content-center p-4 cursor-pointer hover-bg-light"
                                style="height: 200px; border-style: dashed; cursor: pointer; transition: all 0.2s;">
                                <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                <span class="text-muted font-weight-medium">Set Featured Image</span>
                            </div>

                            <!-- Preview -->
                            <div x-show="featuredImage" class="position-relative md-preview"
                                style="height: 200px; display: none;">
                                <img :src="featuredImage" class="img-fluid rounded w-100 h-100" style="object-fit: cover;">
                                <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center bg-dark-overlay hover-actions"
                                    style="top:0; left:0; background: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.2s;">
                                    <button type="button"
                                        @click="$dispatch('open-media-modal', { onSelect: handleFeaturedImage })"
                                        class="btn btn-sm btn-light mr-2">Replace</button>
                                    <button type="button" @click="featuredImage = ''"
                                        class="btn btn-sm btn-danger">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="card shadow-sm mb-4">
                        <div
                            class="card-header bg-white font-weight-bold text-uppercase text-xs text-muted d-flex justify-content-between">
                            Categories
                            <button type="button" @click="addNewCategory()" class="btn btn-xs btn-link p-0">Add New</button>
                        </div>
                        <div class="card-body">
                            <div class="overflow-auto mb-3" style="max-height: 200px;">
                                <template x-for="cat in filteredCategories" :key="cat.id">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="categories[]" :value="cat.id" :id="'cat_' + cat.id"
                                            class="custom-control-input">
                                        <label class="custom-control-label" :for="'cat_' + cat.id"
                                            x-text="cat.name"></label>
                                    </div>
                                </template>
                                <div x-show="filteredCategories.length === 0" class="text-xs text-muted py-2">
                                    No categories for this language.
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </form>
    </div>

    <!-- Media Library Modal -->
    @include('admin.partials.media-library-modal')

    <style>
        .hover-bg-light:hover {
            background-color: #f8f9fa;
            border-color: #007bff !important;
            color: #007bff;
        }

        .md-preview:hover .hover-actions {
            opacity: 1 !important;
        }
    </style>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
        function postEditor() {
            return {
                featuredImage: '',
                language: 'en',
                allCategories: @json($categories),
                filteredCategories: [],
                init() {
                    this.onLanguageChange();
                },
                onLanguageChange() {
                    this.filteredCategories = this.allCategories.filter(c => c.language_code === this.language);
                },
                handleFeaturedImage(media) {
                    this.featuredImage = media.url;
                },
                saveDraft() {
                    // Quick Draft Logic
                    alert('Draft logic placeholder');
                },
                addNewCategory() {
                    let name = prompt("New Category Name:");
                    if (!name) return;
                    let self = this;
                    $.post('{{ route("admin.blog.categories.store") }}', {
                        name: name,
                        language_code: self.language,
                        _token: '{{ csrf_token() }}'
                    }).done(function (res) {
                        if (res.success) {
                            self.allCategories.push(res.category);
                            self.onLanguageChange();
                            window.toast('Category added!');
                        }
                    });
                }
            }
        }

        // Initialize TinyMCE
        tinymce.init({
            selector: '#content',
            height: 600,
            menubar: true,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview', 'anchor',
                'searchreplace', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'media',
                'table', 'help', 'wordcount', 'directionality'
            ],
            toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | link image media | removeformat | code',

            // Custom Callback
            file_picker_callback: function (callback, value, meta) {
                if (meta.filetype === 'image') {
                    window.dispatchEvent(new CustomEvent('open-media-modal', {
                        detail: {
                            onSelect: function (media) {
                                callback(media.url, { alt: media.alt_text || media.original_name });
                            }
                        }
                    }));
                }
            },
            convert_urls: false,
        });

        // TomSelect handled in Alpine init

        $('#title').on('input', function () {
            let slug = $(this).val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            $('#slug').val(slug);
        });

        $('#postForm').on('submit', function (e) {
            e.preventDefault();
            let content = tinymce.get('content').getContent();
            let formData = new FormData(this);
            formData.set('content', content);

            $.ajax({
                url: '{{ route("admin.posts.store") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.success) {
                        window.toast('Post created successfully!');
                        setTimeout(() => window.location.href = res.redirect, 1000);
                    }
                },
                error: function (err) {
                    alert('Error: ' + JSON.stringify(err.responseJSON?.errors));
                }
            });
        });
    </script>
@endpush