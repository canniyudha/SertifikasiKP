@extends('podcast.master')

@push('scripts-head')
<style>
	div .post-item img {
		display: block;
		margin-left: auto;
		margin-right: auto;
		width: 650px;
	}
</style>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endpush

@section('content')
<div class="p-2 py-5" style="margin-left: 150px; margin-right: 150px">
	<div class="row mb-5">
		<div class="col-1 px-1">
			<img src="{{asset(Auth::user()->profile->photo)}}" width="100" height="100" style="object-fit: cover" class="rounded-circle mx-auto">
		</div>

		<div class="col-11">
			<form action="{{ route('post.store') }}" method="POST">
				@csrf
				<div class="form-group">
					<h5 class="text-center">Create your post here</h5>
					<textarea name="post" class="form-control my-editor">{!! old('post', '') !!}</textarea>
				</div>

				<input type="submit" class="btn btn-info btn-lg btn-block" role="button" value="Create Post">
			</form>
		</div>
	</div>

	<div class="border px-4 py-3">
		@forelse ($posts as $post)
		<div class="row py-3">
			<div class="col-1 px-1">
				<img src="{{asset($post->user->profile->photo)}}" width="100" height="100" style="object-fit: cover" class="rounded-circle mx-auto">
			</div>

			<div class="col-11 px-3 mx-auto text-justify">
				<a href="{{ route('profile.show', ['profile' => $post->user->id]) }}">
					<h5>{{ $post->user->name }}</h5>
				</a>
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
		<h4 class="text-center">Empty</h4>
		@endforelse
	</div>
</div>

<!-- Edit Comment Modal -->
@foreach ($posts as $post)
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
