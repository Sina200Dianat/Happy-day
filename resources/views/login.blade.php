@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="min-h-screen flex items-center justify-center" style="background-image: url('/storage/bg.jpg'); background-size: cover; background-position: center;">
  <div class="backdrop-blur-sm bg-white/30 rounded-xl shadow-lg p-8 w-full max-w-md mx-4">
    <h1 class="text-2xl font-semibold text-pink-700 text-center mb-4">A Little Surprise for Nazanin🎁</h1>

    @if($errors->any())
      <div class="text-red-700 text-center mb-3">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.attempt') }}">
      @csrf
      <label class="block text-sm text-gray-700 mb-2">Say the magic word</label>
      <input name="password" type="password" autocomplete="off" autofocus
        class="w-full rounded-md border-gray-200 p-3 mb-4 focus:ring-2 focus:ring-pink-200" placeholder="Enter the magic word...">
      <button class="w-full bg-pink-400 hover:bg-pink-500 text-white font-semibold py-3 rounded-md">Open the surprise 💖</button>
    </form>

    <!-- <p class="text-xs text-center text-gray-600 mt-4">Background image and song are placeholders — replace `storage/app/public/bg.jpg` and `storage/app/public/song.mp3`.</p> -->
  </div>
</div>
@endsection
