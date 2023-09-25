@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header bg-primary">{{ __('Post Edit') }}</div>

        <div class="card-body">
          <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row mb-3">
              <label for="title" class="col-md-4 col-form-label text-md-right required">{{ __('Title') }}</label>

              <div class="col-md-6">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $post->title }}" required autocomplete="title" autofocus>

                @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="description" class="col-md-4 col-form-label text-md-right required">{{ __('Description') }}</label>

              <div class="col-md-6">
                <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description">{{ $post->description }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

              <div class="col-md-6 mt-auto mb-auto">
                <div class="custom-control custom-switch">
                  @if($post->status == '0')
                  <input type="checkbox" class="custom-control-input" id="customSwitch1" name="status">
                  <label class="custom-control-label" for="customSwitch1"></label>
                  @else
                  <input type="checkbox" class="custom-control-input" id="customSwitch1" name="status" checked>
                  <label class="custom-control-label" for="customSwitch1"></label>
                  @endif
                </div>
              </div>

            </div>

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Edit') }}
                </button>
                <button type="reset" class="btn btn-secondary">
                  {{ __('Clear') }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection