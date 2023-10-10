@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/post.css') }}" rel="stylesheet">

    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        <div class="d-flex gap-3 justify-content-end">
            <form action="{{ request()->is('posts/my-posts*') ? route('posts.my-posts') : route('posts.search') }}"
                method="GET" class="btn-group">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search for..."
                        value="{{ request('search') }}" />
                    <button class="btn cmn-btn" type="submit">Search</button>

                    {{-- <a href="{{ route('posts.export', ['search' => request('search')]) }}" class="btn cmn-btn">Download</a> --}}
                </div>
                @if (request()->has('search'))
                    <span class="input-group-btn">
                        <a href="{{ route('posts.search') }}" class="btn btn-danger ms-3">Cancel</a>
                    </span>
                @endif
            </form>

            <div class="btn-group mr-5">
                <a href="{{ route('posts.confirm-create') }}" class="btn cmn-btn">Create</a>
            </div>

            <div class="btn-group mr-5">
                <a href="{{ route('posts.upload') }}" class="btn cmn-btn">Upload</a>
            </div>

            <div class="btn-group mr-5">
                <a href="{{ route('posts.export', ['search' => request('search')]) }}" class="btn cmn-btn">Download</a>
            </div>
        </div>

        @if (count($posts))
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-4" style="margin-top: 50px;">
                        <div class="blog_post">
                            <div class="img_pod">
                                <img class="user-img" src="{{ asset('profiles/' . $post->user->profile) }}"
                                    alt="Profile Image">
                            </div>
                            <div class="container_copy">
                                <h3 class="name">By <b>{{ $post->user->name }}</b>,
                                    {{ $post->created_at->diffForHumans() }},
                                    {{ $post->status == 1 ? 'Active' : 'Inactive' }}</h3>

                                <h1 class="title">{{ Illuminate\Support\Str::limit($post->title, 25) }}</h1>
                                <p class="description">{{ Illuminate\Support\Str::limit($post->description, 40) }}</p>
                                <a class="btn_primary" data-bs-toggle="modal"
                                    data-bs-target="#detailModal_{{ $post->id }}">View Detail &raquo;</a>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Modal -->
                    <div class="modal fade" id="detailModal_{{ $post->id }}" data-backdrop="static" tabindex="-1"
                        role="dialog" aria-labelledby="detailPostModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailPostModalLabel">Detail Post </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mt-4">
                                        <div class="row mb-3">
                                            <label for="id" class="col-form-label col-md-4">ID:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" value="{{ $post->id }}"
                                                    id="id" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="title" class="col-form-label col-md-4">Title:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" value="{{ $post->title }}"
                                                    id="title" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="description" class="col-form-label col-md-4">Description:</label>
                                            <div class="col-md-6">
                                                <textarea type="text" class="form-control" id="description" disabled>{{ $post->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="status" class="col-form-label col-md-4">Status:</label>
                                            <div class="col-md-6">
                                                @if ($post->status === 1)
                                                    <input type="text" class="form-control" id="status" value="Active"
                                                        disabled>
                                                @else
                                                    <input type="text" class="form-control" id="status"
                                                        value="Inactive" disabled>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="created_at" class="col-form-label col-md-4">Created
                                                Date:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control"
                                                    value="{{ $post->created_at->format('d/m/Y') }}" id="created_at"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="created_user_id" class="col-form-label col-md-4">Created
                                                User:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control"
                                                    value="{{ $post->user->name }}" id="created_user_id" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="updated_at" class="col-form-label col-md-4">Updated
                                                Date:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control"
                                                    value="{{ $post->updated_at->format('d/m/Y') }}" id="updated_at"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="updated_user_id" class="col-form-label col-md-4">Updated
                                                User:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control"
                                                    value="{{ $post->user->name }}" id="updated_user_id" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">

                                    @if (auth()->user()->id === $post->created_user_id || auth()->user()->type == 0)
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn cmn-btn">Edit</a>
                                        <a data-bs-toggle="modal" class="btn btn-danger"
                                            data-bs-target="#deleteModal_{{ $post->id }}"
                                            data-action="{{ route('posts.destroy', $post->id) }}">Delete</a>
                                    @endif
                                    {{-- <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button> --}}
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal_{{ $post->id }}" data-backdrop="static" tabindex="-1"
                        role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteUserModalLabel">Delete Post Confirm</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                                    <div class="modal-body">
                                        @csrf
                                        @method('DELETE')
                                        <h5 class="text-start delete-confirm-text">Are you sure to delete this Post?</h5>
                                        <div class="mt-4">
                                            <div class="row mb-3">
                                                <label for="id" class="col-form-label col-md-4">ID:</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control"
                                                        value="{{ $post->id }}" id="id" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="title" class="col-form-label col-md-4">Title:</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control"
                                                        value="{{ $post->title }}" id="title" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="description"
                                                    class="col-form-label col-md-4">Description:</label>
                                                <div class="col-md-6">
                                                    <textarea type="text" class="form-control" id="description" disabled>{{ $post->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="status" class="col-form-label col-md-4">Status:</label>
                                                <div class="col-md-6">
                                                    @if ($post->status == 1)
                                                        <input type="text" class="form-control" id="status"
                                                            value="Active" disabled>
                                                    @else
                                                        <input type="text" class="form-control" id="status"
                                                            value="Inactive" disabled>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="d-block no-data">
                <h5>No Data Found</h5>
            </div>
        @endif


        {{-- <div class="blog_post">
            <div class="img_pod">
                <img src="https://pbs.twimg.com/profile_images/890901007387025408/oztASP4n.jpg" alt="random image">
            </div>
            <div class="container_copy">
                <h3>12 January 2019</h3>
                <h1>CSS Positioning</h1>
                <p>The position property specifies the type of positioning method used for an element (static, relative,
                    absolute, fixed, or sticky).</p>
                <a class="btn_primary" href='#' target="_blank">Read More</a>
            </div>

        </div> --}}

        {{-- <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr class="p-3 mb-2 text-white">
                    <th class="py-3" scope="col">Post Title</th>
                    <th class="py-3" scope="col">Post Description</th>
                    <th class="py-3" scope="col">Posted User</th>
                    <th class="py-3" scope="col">Posted Date</th>
                    <th class="py-3" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($posts))
                    @foreach ($posts as $post)
                        <tr>
                            <td><a data-bs-toggle="modal" data-bs-target="#detailModal_{{ $post->id }}"
                                    href="{{ route('posts.destroy', $post->id) }}">{{ $post->title }}</a></td>
                            <td>{{ $post->description }}</td>
                            <td>{{ $post->user->name }}</td>
                            <td>{{ $post->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">
                                    Edit
                                </a>

                                <a data-bs-toggle="modal" class="btn btn-danger"
                                    data-bs-target="#deleteModal_{{ $post->id }}"
                                    data-action="{{ route('posts.destroy', $post->id) }}">Delete</a>
                            </td>
                        </tr>
                        <!-- Detail Modal -->
                        <div class="modal fade" id="detailModal_{{ $post->id }}" data-backdrop="static" tabindex="-1"
                            role="dialog" aria-labelledby="detailPostModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailPostModalLabel">Detail Post </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mt-4">
                                            <div class="row mb-3">
                                                <label for="id" class="col-form-label col-md-4">ID:</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" value="{{ $post->id }}"
                                                        id="id" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="title" class="col-form-label col-md-4">Title:</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" value="{{ $post->title }}"
                                                        id="title" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="description"
                                                    class="col-form-label col-md-4">Description:</label>
                                                <div class="col-md-6">
                                                    <textarea type="text" class="form-control" id="description" disabled>{{ $post->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="status" class="col-form-label col-md-4">Status:</label>
                                                <div class="col-md-6">
                                                    @if ($post->status === 1)
                                                        <input type="text" class="form-control" id="status"
                                                            value="Active" disabled>
                                                    @else
                                                        <input type="text" class="form-control" id="status"
                                                            value="Inactive" disabled>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="created_at" class="col-form-label col-md-4">Created
                                                    Date:</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control"
                                                        value="{{ $post->created_at->format('d/m/Y') }}" id="created_at"
                                                        disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="created_user_id" class="col-form-label col-md-4">Created
                                                    User:</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control"
                                                        value="{{ $post->user->name }}" id="created_user_id" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="updated_at" class="col-form-label col-md-4">Updated
                                                    Date:</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control"
                                                        value="{{ $post->updated_at->format('d/m/Y') }}" id="updated_at"
                                                        disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="updated_user_id" class="col-form-label col-md-4">Updated
                                                    User:</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control"
                                                        value="{{ $post->user->name }}" id="updated_user_id" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal_{{ $post->id }}" data-backdrop="static"
                            tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteUserModalLabel">Delete Post Confirm</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                                        <div class="modal-body">
                                            @csrf
                                            @method('DELETE')
                                            <h5 class="text-start">Are you sure to delete this Post?</h5>
                                            <div class="mt-4">
                                                <div class="row mb-3">
                                                    <label for="id" class="col-form-label col-md-4">ID:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control"
                                                            value="{{ $post->id }}" id="id" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="title" class="col-form-label col-md-4">Title:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control"
                                                            value="{{ $post->title }}" id="title" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="description"
                                                        class="col-form-label col-md-4">Description:</label>
                                                    <div class="col-md-6">
                                                        <textarea type="text" class="form-control" id="description" disabled>{{ $post->description }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="status" class="col-form-label col-md-4">Status:</label>
                                                    <div class="col-md-6">
                                                        @if ($post->status == 1)
                                                            <input type="text" class="form-control" id="status"
                                                                value="Active" disabled>
                                                        @else
                                                            <input type="text" class="form-control" id="status"
                                                                value="Inactive" disabled>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">No Data Found</td>
                    </tr>
                @endif

            </tbody>
        </table> --}}
        <div class="float-end mt-3 mb-4">
            {{ $posts->links() }}
        </div>
        <!-- Delete Warning Modal -->
        {{-- <div class="modal modal-danger fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Delete"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Contact</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('posts.destroy', 'id') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input id="id" name="id">
                            <h5 class="text-center">Are you sure you want to delete this contact?</h5>
                            <input id="firstName" name="firstName"><input id="lastName" name="lastName">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-danger">Yes, Delete Contact</button>
                    </div>
                    </form>
                </div>
            </div>
        </div> --}}
        <!-- End Delete Modal -->
    </div>
@endsection
