@extends('layouts.app')

@section('title', 'Celebrate')

@section('content')
<div class="min-h-screen flex items-center justify-center">
  <div class="text-center p-6">
    <div x-data="surprise()" class="relative">
      <button x-show="!played" x-on:click="start()" aria-label="Start Surprise"
        class="w-20 h-20 rounded-full bg-red-400 shadow-lg animate-pulse flex items-center justify-center text-white text-xl">
        ❤
      </button>

      <audio id="song" src="/storage/song.mp3"></audio>

      <div x-show="messageVisible" x-cloak class="mt-6 max-w-xl mx-auto text-center text-white p-6 bg-black/40 rounded">
        <div x-html="typedHtml" class="text-2xl leading-relaxed"></div>
        <div class="mt-4">
          <button x-show="showWishButton" x-cloak x-on:click="openWish()"
            class="inline-block bg-yellow-300 text-pink-700 font-semibold py-2 px-4 rounded shadow-md hover:bg-yellow-400">
            حالا آرزو کن ✨
          </button>
        </div>
      </div>
    </div>
  </div>

  {{-- Wish modal partial --}}
  @include('wish-modal')

  <script>
    function surprise(){
      return {
          played: false,
          messageVisible: false,
          typedHtml: '',
          fullText: `نازنین جان
امیدوارم در تمامی مراحل زندگیت مثل همیشه بدرخشی و به هر آرزویی که داری برسی زندگی تنها گذر کردن از چالش هایی  برای تجربه و یادگیری است  امیدوارم مسیر زندیگت پر از چالش های قشنگ و زیبا باشه مثل لبخندت مثل صدات مثل زیبایی که توصیفی برایش نیست

امیدوارم این  هدیه و سوپرایز کوچیک به دلت بشینه و لبخندی بر لبانت بنشاند
تو دختری از جنس برگ هستی نازک و شکننده اما درونی قدرتمند داری که برای رسیدن به موفقیت از تمامی تلاطم های زندگی عبور میکنه

ساده بگویم 
تولدت مبارک جانا

من چراغم کشتنم را حاجت شمشیر نیست
میتوان افشاند دامانی که بس باشد مرا
`,
          showWishButton: false,
          flowerInterval: null,
          start(){
            this.played = true;
            const audio = document.getElementById('song');
            audio.volume = 0.5;
            audio.play().catch(()=>{});
            // start emitting flowers periodically during the typewriter animation
            if(window._flowers) this.flowerInterval = setInterval(()=> window._flowers(50), 600);
            // typewriter
            this.typeWriter(0);
          },
        typeWriter(i){
          this.messageVisible = true;
          if(i <= this.fullText.length){
            this.typedHtml = this.fullText.slice(0,i).replace(/\n/g,'<br>');
            setTimeout(()=> this.typeWriter(i+1), 45);
          } else {
            // When typing is finished, stop flowers and show the "Make a wish" button
            if(this.flowerInterval){ clearInterval(this.flowerInterval); this.flowerInterval = null; }
            // small final bloom
            if(window._flowers) window._flowers(10);
            setTimeout(()=> { this.showWishButton = true; }, 400);
          }
        },
        openWish(){
          // optional confetti helper
          if(window._confetti) window._confetti();
          const modal = document.getElementById('wishModal');
          modal.classList.remove('hidden');
          // Focus on the textarea for better UX
          setTimeout(() => {
            const textarea = document.getElementById('wishInput');
            if (textarea) textarea.focus();
          }, 100); // Small delay to ensure modal is fully visible
        }
      }
    }
  </script>
</div>
@endsection