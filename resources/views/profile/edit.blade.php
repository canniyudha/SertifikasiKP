@extends('podcast.master')

@section('content')
<div class="site-blocks-cover overlay inner-page-cover aos-init aos-animate" style="background-image: url({{ asset('podcast/images/hero_bg_1.jpg') }}); background-position: 50% -81.4px;" data-aos="fade" data-stellar-background-ratio="0.5">
  <div class="container">
    <div class="row align-items-center justify-content-center text-center">
      <div class="col-md-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
        <h1 class="text-white">Edit Profile</h1>
      </div>
    </div>
  </div>
</div>

<div class="container py-5 my-5">
  <div class="row justify-content-center my-5">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <form method="POST" action="{{ route('profile.update', ['profile' => $profile->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group row">
              <label for="fullname" class="col-md-4 col-form-label text-md-right">Fullname</label>
              <div class="col-md-6">
                <input id="fullname" type="text" class="form-control" name="fullname" value="{{ old('fullname', $profile->fullname) }}" required autofocus>
              </div>
            </div>
            <div class="form-group row">
              <label for="photo" class="col-md-4 col-form-label text-md-right">Photo</label>
              <div class="col-md-6">
                <input id="photo" type="file" class="form-control" name="photo" accept="image/*">
              </div>
            </div>
            <div class="form-group row">
              <label for="bio" class="col-md-4 col-form-label text-md-right">Bio</label>
              <div class="col-md-6">
                <textarea class="form-control" name="bio" id="bio" rows="3" required>{{ old('bio', $profile->bio) }}</textarea>
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  Save Data
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