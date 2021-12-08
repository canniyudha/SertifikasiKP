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
@endpush

@section('content')
<div class="p-2 py-5" style="margin-left: 150px; margin-right: 150px">
	<div class="border px-4 py-3">
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

				<div class="row mb-4 justify-content-md-center">
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

				@foreach ($post->comments as $comment)
				<div class="row">
					<div class="col justify-content-around">
						<div class="d-flex">
							<a href="{{ route('profile.show', ['profile' => $comment->user->id]) }}">
								<h5>{{ $comment->user->name }}</h5>
							</a>
							@if (Auth::id() == $comment->user->id || Auth::id() == $post->user->id)
							<button class="btn btn-secondary dropdown-toggle ml-2" style="height: 30px; padding: 5px;" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Option
							</button>

							<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
								@if (Auth::id() == $comment->user->id)
								<button type="button" class="dropdown-item" data-toggle="modal" data-target="#Comment{{$post->id}}Modal{{$comment->id}}">
									Edit
								</button>
								@endif
								<form action="{{ route('comment.destroy', ['comment' => $comment->id]) }}" method="post">
									@csrf
									@method('DELETE')
									<input type="submit" value="Delete" class="dropdown-item">
								</form>
							</div>
							@endif
						</div>

						<div class="d-flex">
							<p>{!! nl2br($comment->text) !!}</p>

							<div>
								<form action="{{ route('comment.like', ['comment' => $comment->id]) }}" method="POST">
									@csrf
									@if ($comment->like_comments()->where('comment_id', $comment->id)->where('user_id', Auth::id())->get()->count())
									<button class="btn ml-2 p-1 bg-transparent" type="submit" style="height: 30px; padding: 5px;" role="button">
										<img src="{{ asset('podcast/images/favorite-heart-button.png') }}" width="20">
										<b class="ml-1">{{ $comment->like_comments()->where('comment_id', $comment->id)->get()->count() }}</b>
									</button>
									@else
									<button class="btn ml-2 p-1 bg-transparent" type="submit" style="height: 30px; padding: 5px;" role="button">
										<img src="{{ asset('podcast/images/favorite-heart-outline-button.png') }}" width="20">
										<b class="ml-1">{{ $comment->like_comments()->where('comment_id', $comment->id)->get()->count() }}</b>
									</button>
									@endif
								</form>
							</div>

						</div>
					</div>
				</div>
				@endforeach
				<label class="text-muted font-italic m-0"><small>{{ count($post->comments) }} comments</small></label>
			</div>
		</div>
		<hr>
	</div>
</div>

<!-- Edit Comment Modal -->
@foreach ($post->comments as $comment)
<div class="modal fade bd-example-modal-lg" id="Comment{{$post->id}}Modal{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="Comment{{$post->id}}Modal{{$comment->id}}Title" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="Comment{{$post->id}}Modal{{$comment->id}}Title">Edit Your Comment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{ route('comment.update', ['comment' => $comment->id])}}" method="POST">
					@csrf
					@method('PUT')
					<div class="form-group">
						<textarea class="form-control" id="comment" name="comment" rows="3">{{ $comment->text }}</textarea>
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
@endforeach

@endsection