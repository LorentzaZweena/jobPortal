@extends('front.layouts.app')

@section('main')

<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>

        @if (Session::get('success'))
            <div class="alert alert-success">
                <p class="mb-0 pb-0">{{ Session::get('success') }}</p>
            </div>
        @endif

        @if (Session::get('error'))
            <div class="alert alert-danger">
                <p class="mb-0 pb-0">{{ Session::get('error') }}</p>
            </div>
        @endif

        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Reset Password</h1>
                    <form action="{{ route('account.processResetPassword') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="password" class="mb-2">New Password*</label>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <p class="invalid-feedback">{{ $message }}</p>  
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="mb-2">Confirm Password*</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required>
                            @error('password_confirmation')
                                <p class="invalid-feedback">{{ $message }}</p>  
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-danger mt-2">Reset Password</button>
                    </form>
                </div>
                <div class="mt-4 text-center">
                    <p>Remembered your password? <a href="{{ route('account.login') }}" class="text-danger">Login</a></p>
                </div>
            </div>
        </div>

        <div class="py-lg-5">&nbsp;</div>
    </div>
</section>

@endsection
