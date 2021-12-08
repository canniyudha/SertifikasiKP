@extends('podcast.master')

@section('content')
<div class="site-blocks-cover overlay inner-page-cover aos-init aos-animate" style="background-image: url({{ asset('podcast/images/hero_bg_1.jpg') }}); background-position: 50% -81.4px;" data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                <h1 class="text-white">Login / Register</h1>
            </div>
        </div>
    </div>
</div>

<div class="container py-5 my-5">
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
		                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
	                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
