<!-- @extends('layouts.app') -->
@section('content')
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header py-3">{{ __('Profile') }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="mt-4 col-3">
                                <img class="detail-image" src="{{ asset('profiles/' . $user->profile) }}">
                            </div>
                            <div class="mt-4 col-sm-9">
                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label">Name:</label>
                                    <div class="col-md-6">
                                        <input type="text" class="col-md-4 form-control" value="{{ $user->name }}"
                                            id="name" disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="title" class="col-md-4 col-form-label">Email:</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="{{ $user->email }}"
                                            id="title" disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="type" class="col-md-4 col-form-label">Type:</label>
                                    <div class="col-md-6">
                                        @if ($user->type == 1)
                                            <input type="text" class="form-control" id="type" value="User"
                                                disabled>
                                        @else
                                            <input type="text" class="form-control" id="type" value="Admin"
                                                disabled>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="phone" class="col-md-4 col-form-label">Phone:</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="phone"
                                            value="{{ $user->phone }}" disabled />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="dob" class="col-md-4 col-form-label">Dath of
                                        Birth:</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="dob"
                                            value="{{ $user->dob }}" disabled />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="address" class="col-md-4 col-form-label">Address:</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="address"
                                            value="{{ $user->address }}" disabled />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 offset-md-4">
                                        <a class="btn cmn-btn"
                                            href="{{ route('profile.edit') }}">{{ __('Edit Profile') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
