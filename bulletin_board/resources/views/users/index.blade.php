@extends('layouts.app')
@section('content')
    <div class="container">
        {{-- <div class="card">
            <div class="card-header py-3">{{ __('User List') }}</div>
            <div class="card-body"> --}}

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

        <form method="GET" action="{{ route('userlist') }}">
            @csrf
            <div class="d-flex gap-3 justify-content-end my-4">
                <div class="col d-flex gap-3">
                    <label for="name" class="col-form-label primary-txt"> Name:</label>
                    <input type="text" id="name" name="name" value="{{ request('name') }}"
                        class="form-control
                                        primary-outline">
                </div>
                <div class="col d-flex gap-3">
                    <label for="email" class="col-form-label primary-txt">Email:</label>
                    <input type="text" id="email" name="email" value="{{ request('email') }}"
                        class="form-control
                                            primary-outline">
                </div>
                <div class="col d-flex gap-3">
                    <label for="fromDate" class="col-form-label primary-txt">From:</label>
                    <input type="date" id="fromDate" name="fromDate" value="{{ request('fromDate') }}"
                        class="form-control
                                        primary-outline">
                </div>
                <div class="col d-flex gap-3">
                    <label for="toDate" class="col-form-label primary-txt">To:</label>
                    <input type="date" id="toDate" name="toDate" value="{{ request('toDate') }}"
                        class="form-control
                                        primary-outline">
                </div>
                <div>
                    <button class="btn cmn-btn" type="submit">Search</button>
                    @if (request()->has('name') || request()->has('email') || request()->has('fromDate') || request()->has('toDate'))
                        <a href="{{ route('userlist') }}" class="btn btn-danger">Cancel</a>
                    @endif
                </div>
            </div>
        </form>

        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr class="p-3 mb-2 text-white">
                    <th class="py-3" scope="col">No</th>
                    <th class="py-3" scope="col">Name</th>
                    <th class="py-3" scope="col">Email</th>
                    <th class="py-3" scope="col">Created User</th>
                    <th class="py-3" scope="col">Type</th>
                    <th class="py-3" scope="col">Phone</th>
                    <th class="py-3" scope="col">Dath of Birth</th>
                    <th class="py-3" scope="col">Address</th>
                    <th class="py-3" scope="col">Created_Date</th>
                    <th class="py-3" scope="col">Updated_Date</th>
                    <th class="py-3" scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>
                @if (count($users))
                    @foreach ($users as $key => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $key }}</td>
                            <td><a data-bs-toggle="modal" data-bs-target="#detailModal_{{ $user->id }}">
                                    <div class="d-flex align-items-center"><img class="profile"
                                            src="{{ asset('profiles/' . $user->profile) }}"><span
                                            class="ms-2">{{ $user->name }}</span>
                                    </div>
                                </a>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->createdUser->name }} </td>
                            <td>
                                @if ($user->type == 1)
                                    User
                                @else
                                    Admin
                                @endif
                            </td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->dob }}</td>
                            <td>{{ $user->address }}</td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>{{ $user->updated_at->format('d/m/Y') }}</td>
                            <td>
                                <a class="btn btn-info btn-edit" href="{{ route('users.edit', $user->id) }}"><i
                                        class="bi bi-pen"></i></a>
                                <a data-bs-toggle="modal" class="btn btn-danger"
                                    data-bs-target="#deleteModal_{{ $user->id }}"
                                    data-action="{{ route('users.destroy', $user->id) }}"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <!-- Detail Modal -->
                        <div class="modal fade" id="detailModal_{{ $user->id }}" data-backdrop="static" tabindex="-1"
                            role="dialog" aria-labelledby="detailPostModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailPostModalLabel">Detail User </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="mt-4 col-3">
                                                <img class="detail-image"
                                                    src="{{ asset('profiles/' . $user->profile) }}">
                                            </div>
                                            <div class="mt-4 col-sm-9">
                                                <div class="row mb-3">
                                                    <label for="name" class="col-form-label"
                                                        style="width: 36.33333%">Name:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control"
                                                            value="{{ $user->name }}" id="name" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="title" class="col-form-label"
                                                        style="width: 36.33333%">Email:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control"
                                                            value="{{ $user->email }}" id="title" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="type" class="col-form-label"
                                                        style="width: 36.33333%">Type:</label>
                                                    <div class="col-md-6">
                                                        @if ($user->type === 1)
                                                            <input type="text" class="form-control" id="type"
                                                                value="User" disabled>
                                                        @else
                                                            <input type="text" class="form-control" id="type"
                                                                value="Admin" disabled>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="phone" class="col-form-label"
                                                        style="width: 36.33333%">Phone:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="phone"
                                                            value="{{ $user->phone }}" disabled />
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="dob" class="col-form-label"
                                                        style="width: 36.33333%">Dath of
                                                        Birth:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="dob"
                                                            value="{{ $user->dob }}" disabled />
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="address" class="col-form-label"
                                                        style="width: 36.33333%">Address:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="address"
                                                            value="{{ $user->address }}" disabled />
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="created_at" class="col-form-label"
                                                        style="width: 36.33333%">Created
                                                        Date:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control"
                                                            value="{{ $user->created_at->format('d/m/Y') }}"
                                                            id="created_at" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="created_user_id" class="col-form-label"
                                                        style="width: 36.33333%">Created
                                                        User:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control"
                                                            value="{{ $user->createdUser->name }}" id="created_user_id"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="updated_at" class="col-form-label"
                                                        style="width: 36.33333%">Updated
                                                        Date:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control"
                                                            value="{{ $user->updated_at->format('d/m/Y') }}"
                                                            id="updated_at" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="updated_user_id" class="col-form-label"
                                                        style="width: 36.33333%">Updated
                                                        User:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control"
                                                            value="{{ $user->createdUser->name }}" id="updated_user_id"
                                                            disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal_{{ $user->id }}" data-backdrop="static"
                            tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteUserModalLabel">Delete User
                                            Confirm</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                        <div class="modal-body">
                                            @csrf
                                            @method('DELETE')
                                            <h5 class="text-start delete-confirm-text">Are you sure to delete this
                                                User?</h5>
                                            <div class="mt-4">
                                                <div class="row mb-3">
                                                    <label for="id" class="col-form-label col-md-4">ID:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control"
                                                            value="{{ $user->id }}" id="id" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="name" class="col-form-label col-md-4">Name:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control"
                                                            value="{{ $user->name }}" id="name" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="email" class="col-form-label col-md-4">Email:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="email"
                                                            value="{{ $user->email }}" disabled />
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="type" class="col-form-label col-md-4">Type:</label>
                                                    <div class="col-md-6">
                                                        @if ($user->type == 1)
                                                            <input type="text" class="form-control" id="type"
                                                                value="User" disabled>
                                                        @else
                                                            <input type="text" class="form-control" id="type"
                                                                value="Admin" disabled>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="phone" class="col-form-label col-md-4">Phone:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="phone"
                                                            value="{{ $user->phone }}" disabled />
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="dob" class="col-form-label col-md-4">Date of
                                                        Birth:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="dob"
                                                            value="{{ $user->dob }}" disabled />
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="address" class="col-form-label col-md-4">Address:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="address"
                                                            value="{{ $user->address }}" disabled />
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
                        <td colspan="11">No Data Found</td>
                    </tr>
                @endif

            </tbody>
        </table>
        <div class="float-end">
            {{ $users->links() }}
        </div>
        {{-- </div>
        </div>
    </div> --}}
    </div>

@endsection