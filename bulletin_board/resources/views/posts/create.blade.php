<!-- @extends("layouts.app") -->

@section("content")
  @if($errors->any())
  <div class="alert alert-warning">
    <ol>
      @foreach($errors->all() as $error)
      <li>{{$error}}</li>
      @endforeach
    </ol>
  </div>
  @endif
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header bg-primary">{{ __('Create Post') }}</div>
        <div class="card-body">
          <form method="post">
            @csrf
            <div class="mb-3">
              <label>Title</label>
              <input type="text" name="title" class="form-control">
            </div>
            <div class="mb-3">
              <label>Description</label>
              <textarea name="body" class="form-control"></textarea>
            </div>
            <button class="btn btn-primary">Create</button>
            <button class="btn btn-secondary">Clear</button>

          </form>
        </div>
      </div>
    </div>
  </div>
</div> -->
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header bg-primary">Create Post</div>
        <div class="card-body">
          <form method="POST" action="{{ route('posts.create') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row mb-3">
              <label for="title" class="col-md-4 col-form-label text-md-right required">{{ __('Title') }}</label>

              <div class="col-md-6">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" autocomplete="title" autofocus>

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
                <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description">{{ old('description') }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Create') }}
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