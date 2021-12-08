@extends('podcast.master')

@push('scripts-head')
<style>
  div .post-item img {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 600px;
  }
</style>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush

@section('content')
<div class="container-fluid py-4 bg-info">
  <div class="row">
    <div class="col-3"></div>
    <div class="col-6 text-center">
      <img src="{{ asset("$profile->photo") }}" alt="profile photo" class="rounded-circle" width="200px" height="200px" style="object-fit: cover;">
      <h2 class="text-dark mb-0 mt-2">{{ $profile->fullname}}</h2>
      <p class="text-dark">{{$user->name}}</p>
      @if(Auth::id() != $user->id)
      <form method="POST" action="{{ route('profile.follow', ['profile' => $user->id]) }}">
        @csrf
        @if($follow_status)
        <button class="btn btn-outline-primary">Unfollow</button>
        @else
        <button class="btn btn-primary">Follow</button>
        @endif
      </form>
      @endif
    </div>
    <div class="col-3">
      @if (Auth::id() == $user->id)
      <div class="d-flex justify-content-end">
        <a href="{{ route('profile.edit', ['profile' => $user->id]) }}" class="btn btn-secondary">Edit Profile</a>
      </div>
      <div class="d-flex justify-content-end my-2">
        <button class="btn btn-danger p-0" style="height: 25px; width: 97px;" data-toggle="modal" data-target="#DeleteModal">
          <small class="text-wrap">Delete Account</small>
        </button>
      </div>
      @endif
    </div>
  </div>
</div>

<div class="container-fluid my-5 px-5">
  <div class="row">
    <div class="col-3">
      <p class="m-0">Followers</p>
      <h4>{{ $following }}</h4>
      <p class="m-0">Following</p>
      <h4>{{ $followers }}</h4>
      <p class="m-0">Email</p>
      <p><b>{{$user->email}}</b></p>
      <p class="m-0">Bio</p>
      <p><b>{!! nl2br($profile->bio) !!}</b></p>
    </div>
    <div class="col-9">
      <div class="border px-4 py-3">
        @forelse ($user->posts->reverse() as $post)
        <div class="row py-3">
          <div class="col-1 px-1">
            <img src="{{asset($post->user->profile->photo)}}" width="80" height="80" style="object-fit: cover" class="rounded-circle mx-auto">
          </div>
          <div class="col-11 px-3 mx-auto text-justify">
            <div class="d-flex justify-content-between">
              <a href="{{ route('profile.show', ['profile' => $post->user->id]) }}">
                <h5>{{ $post->user->name }}</h5>
              </a>
              @if (Auth::id() == $user->id)
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" style="height: 30px; padding: 5px;" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Option
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <button type="button" class="dropdown-item" data-toggle="modal" data-target="#PostModal{{ $post->id }}">
                    Edit
                  </button>
                  <form action="{{ route('post.destroy', ['post' => $post->id]) }}" method="POST">
                    @csrf
                    @method("DELETE")
                    <input type="submit" class="dropdown-item" value="Delete">
                  </form>
                </div>
              </div>
              @endif
            </div>
            <div class="post-item">
              {!! $post->text !!}
            </div>

            <div class="row mb-4">
              <div class="col-2">
                <form action="{{ route('post.like', ['post' => $post->id]) }}" method="POST">
                  @csrf
                  @if ($post->like_posts()->where('post_id', $post->id)->where('user_id', Auth::id())->get()->count())
                  <button type="submit" class="btn btn-outline-primary btn-block bg-transparent" role="button">
                    <img src="{{ asset('podcast/images/favorite-heart-button.png') }}" width="20">
                    <b class="ml-1">{{ $post->like_posts()->where('post_id', $post->id)->get()->count() }}</b>
                  </button>
                  @else
                  <button type="submit" class="btn btn-outline-primary btn-block bg-transparent" role="button">
                    <img src="{{ asset('podcast/images/favorite-heart-outline-button.png') }}" width="20">
                    <b class="ml-1">{{ $post->like_posts()->where('post_id', $post->id)->get()->count() }}</b>
                  </button>
                  @endif
                </form>
              </div>
              <div class="col-10">
                <a class="btn btn-info btn-sm btn-block" href="{{ route('post.show', ['post' => $post->id]) }}" role="button">View more comments</a>
              </div>
            </div>

            <form action="{{ route('comment.create', ['comment' => $post->id]) }}" method="POST">
              @csrf
              <div class="row mb-4">
                <div class="col-11">
                  <textarea class="form-control" id="comment" name="comment" value="{{ old('comment','') }}" rows="3" placeholder="your comment here"></textarea>
                </div>
                <div class="col-1">
                  <button class="btn bg-white" role="button"><img src="{{ asset('podcast/images/send-button.png') }}" width="40"></button>
                </div>
              </div>
            </form>

            @if(count($post->comments))
            <div class="row">
              <div class="col justify-content-around">
                <div class="d-flex">
                  <a href="{{ route('profile.show', ['profile' => $post->comments[0]->user->id]) }}">
                    <h5>{{ $post->comments[0]->user->name }}</h5>
                  </a>
                  @if (Auth::id() == $post->comments[0]->user->id || Auth::id() == $post->user->id)
                  <button class="btn btn-secondary dropdown-toggle ml-2" style="height: 30px; padding: 5px;" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Option
                  </button>

                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    @if (Auth::id() == $post->comments[0]->user->id)
                    <button type="button" class="dropdown-item" data-toggle="modal" data-target="#Comment{{$post->id}}Modal{{$post->comments[0]->id}}">
                      Edit
                    </button>
                    @endif
                    <form action="{{ route('comment.destroy', ['comment' => $post->comments[0]->id]) }}" method="post">
                      @csrf
                      @method('DELETE')
                      <input type="submit" value="Delete" class="dropdown-item">
                    </form>
                  </div>
                  @endif
                </div>

                <div class="d-flex">
                  <p>{!! nl2br($post->comments[0]->text) !!}</p>
                  <div>
                    <form action="{{ route('comment.like', ['comment' => $post->comments[0]->id]) }}" method="POST">
                      @csrf
                      @if ($post->comments[0]->like_comments()->where('comment_id', $post->comments[0]->id)->where('user_id', Auth::id())->get()->count())
                      <button class="btn ml-2 p-1 bg-transparent" type="submit" style="height: 30px; padding: 5px;" role="button">
                        <img src="{{ asset('podcast/images/favorite-heart-button.png') }}" width="20">
                        <b class="ml-1">{{ $post->comments[0]->like_comments()->where('comment_id', $post->comments[0]->id)->get()->count() }}</b>
                      </button>
                      @else
                      <button class="btn ml-2 p-1 bg-transparent" type="submit" style="height: 30px; padding: 5px;" role="button">
                        <img src="{{ asset('podcast/images/favorite-heart-outline-button.png') }}" width="20">
                        <b class="ml-1">{{ $post->comments[0]->like_comments()->where('comment_id', $post->comments[0]->id)->get()->count() }}</b>
                      </button>
                      @endif
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endif
            <label class="text-muted font-italic m-0"><small>{{ count($post->comments) }} comments</small></label>
          </div>
        </div>
        <hr>
        @empty
        <h4>Empty</h4>
        @endforelse
      </div>
    </div>
  </div>
</div>

<!-- Edit Post Modal -->
@foreach ($user->posts->reverse() as $post)
<div class="modal fade bd-example-modal-lg" id="PostModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="PostModal{{ $post->id }}Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="PostModal{{ $post->id }}Title">Edit Your Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('post.update', ['post' => $post->id]) }}" method="POST">
          @csrf
          @method("PUT")
          <div class="form-group">
            <textarea name="post" class="form-control my-editor">{!! old('post', $post->text) !!}</textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Save changes">
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach

<!-- Edit Comment Modal -->
@foreach ($user->posts->reverse() as $post)
@if (count($post->comments))
<div class="modal fade bd-example-modal-lg" id="Comment{{$post->id}}Modal{{$post->comments[0]->id}}" tabindex="-1" role="dialog" aria-labelledby="Comment{{$post->id}}Modal{{$post->comments[0]->id}}Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Comment{{$post->id}}Modal{{$post->comments[0]->id}}Title">Edit Your Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('comment.update', ['comment' => $post->comments[0]->id])}}" method="POST">
          @csrf
          @method('PUT')
          <div class="form-group">
            <textarea class="form-control" id="comment" name="comment" rows="3">{{ $post->comments[0]->text }}</textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endif
@endforeach

<!-- Delete Account Modal -->
<div class="modal fade bd-example-modal-lg" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="DeleteModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="DeleteModalTitle">Delete Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure to delete your account forever ?</p>
      </div>
      <div class="modal-footer">
        <form action="{{ route('profile.destroy', ['profile' => Auth::id()])}}" method="POST">
          @csrf
          @method('DELETE')
          <button type="button" class="btn btn-info" data-dismiss="modal" style="width: 100px;">No</button>
          <button type="submit" class="btn btn-outline-danger" style="width: 100px;">Yes</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  var editor_config = {
    path_absolute: "/",
    selector: "textarea.my-editor",
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback: function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file: cmsURL,
        title: 'Filemanager',
        width: x * 0.8,
        height: y * 0.8,
        resizable: "yes",
        close_previous: "no"
      });
    }
  };

  tinymce.init(editor_config);
</script>
@endpush