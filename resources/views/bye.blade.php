@extends('layouts.app')

@section('title','Thanks')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-white">
  <div class="text-center p-6">
    <h2 class="text-2xl font-semibold text-pink-600">Your wish is saved with the stars! ✨</h2>
    <p class="text-gray-600 mt-3">Thank you — I'll keep this moment safe. Closing shortly...</p>
  </div>
</div>

<script>
  // Optional: after 2s, redirect to external (e.g., Instagram) or close window
  setTimeout(()=>{
    // try to close; if blocked, go to homepage or external link
    try{ window.close(); }catch(e){ window.location = 'https://instagram.com'; }
  },2000);
</script>

@endsection
