<<<<<<< HEAD
@extends('layouts.home')

@section('content')
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">My Account</h1>
                <ul>
                    <li>
                        <a href="#">Home </a>
                    </li>
                    <li class="active"> My Account </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End -->

</div>
<div class="section section-margin">
    <div class="container">

        <div class="row mb-n10 justify-content-center">

            <div class="col-lg-6 col-md-8 m-auto m-lg-0 pb-10">
                <!-- Register Wrapper Start -->
                <div class="register-wrapper ">

                    <!-- Title and Description Start -->
                    <div class="section-content text-center mb-5 ">
                        <h2 class="title mb-2">Create Account</h2>
                        <p class="desc-content">Please Register using account details below.</p>
                    </div>
                    <!-- Title and Description End -->

                    <!-- Form Start -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name Input Start -->
                        <div class="single-input-item mb-3">
                            <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Name Input End -->

                        <!-- Email Input Start -->
                        <div class="single-input-item mb-3">
                            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Email Input End -->

                        <!-- Password Input Start -->
                        <div class="single-input-item mb-3">
                            <input type="password" name="password" placeholder="Password" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Password Input End -->

                        <!-- Confirm Password Input Start -->
                        <div class="single-input-item mb-3">
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Confirm Password Input End -->

                        <!-- Newsletter Checkbox Start -->
                        <div class="single-input-item mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="subscribe_newsletter" name="subscribe_newsletter">
                                <label class="custom-control-label" for="subscribe_newsletter">Subscribe to Our Newsletter</label>
                            </div>
                        </div>
                        <!-- Newsletter Checkbox End -->

                        <!-- Register Button Start -->
                        <div class="single-input-item mb-3">
                            <button type="submit" class="btn btn-dark btn-hover-primary rounded-0">Register</button>
                        </div>
                        <!-- Register Button End -->

                        <!-- Login Link Start -->
                        <span class="text">
                            <a href="{{ route('login') }}">Already have an account?</a>
                        </span>
                        <!-- Login Link End -->

                    </form>
                    <!-- Form End -->

                </div>
                <!-- Register Wrapper End -->
            </div>
        </div>

    </div>
</div>
@endsection
=======
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
