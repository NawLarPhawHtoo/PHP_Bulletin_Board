@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="d-flex gap-3 justify-content-end mb-4">
            <form action="{{ route('posts.search') }}" method="GET">
                <div class="btn-group ">
                    <input type="text" class="form-control" name="search" placeholder="Search for..."
                        value="{{ request('search') }}">
                    <span class="input-group-btn" style="margin-right: 3px;">
                        <button class="btn btn-secondary" type="submit">Go!</button>
                    </span>
                    @if (request()->has('search'))
                        <span class="input-group-btn">
                            <a href="{{ route('posts.search') }}" class="btn btn-danger">Cancel</a>
                        </span>
                    @endif
                </div>
            </form>
            <div class="btn-group mr-5">
                <a href="{{ route('posts.create') }}" class="btn btn-secondary">Create</a>
            </div>
            <div class="btn-group mr-5">
                <a href="{{ route('posts.upload') }}" class="btn btn-secondary">Upload</a>
            </div>
            <div class="btn-group">
                <a href="{{ route('posts.export') }}" class="btn btn-secondary">Download</a>
            </div>
        </div>
        <table class="table table-bordered table-striped text-center">
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
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->description }}</td>
                            <td>{{ $post->user->name }}</td>
                            <td>{{ $post->created_at }}</td>
                            <td>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">
                                        Edit
                                    </a>
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="5">No Data Found</td>
                </tr>
                @endif

            </tbody>
        </table>
        <div class="float-end">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
