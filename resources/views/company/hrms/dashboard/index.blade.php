@extends('layouts.hrms-layout')

@section('title', 'Feature Unavailable')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-gray-100 text-center">
  <div class=" p-10 max-w-md w-full">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Feature Unavailable</h1>
    <p class="text-gray-600 mb-6">
      Sorry, this feature is currently unavailable.
      We’re working hard to bring it to you soon!
    </p>
    <a href="{{ url()->previous() }}"
       class="inline-block px-6 py-2  text-dark rounded-lg hover:bg-indigo-700 transition">
      Go Back
    </a>
  </div>
</div>
@endsection
