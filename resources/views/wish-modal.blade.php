<div id="wishModal" class="fixed inset-0 flex items-center justify-center bg-black/50 hidden z-50"
  data-save-url="{{ route('wish.save') }}" data-bye-url="{{ route('bye') }}">
  <div class="bg-white rounded-lg p-6 w-full max-w-4xl mx-4">
    <div class="md:flex md:gap-6">
      <!-- Left: form -->
      <div class="md:flex-1">
        <h3 class="text-xl font-semibold text-pink-600 mb-2">Write your wish ✨</h3>
        <p class="text-sm text-gray-600 mb-4">What's your wish for the year ahead? Write it here...</p>

        <form id="wishForm" onsubmit="event.preventDefault(); submitWish();">
          <textarea id="wishInput" name="wish" rows="6" class="w-full border rounded p-3 mb-3" placeholder="Your wish..."></textarea>
          <div class="flex items-center justify-between">
            <button type="submit" class="bg-yellow-300 hover:bg-yellow-400 text-pink-700 font-semibold py-2 px-4 rounded">Send ✨</button>
            <button type="button" onclick="closeWish()" class="text-sm text-gray-600">Not now</button>
          </div>
        </form>
      </div>

      <!-- Right: heartfelt note -->
      <aside class="md:w-80 mt-4 md:mt-0 bg-pink-50 border border-pink-100 rounded-lg p-4 flex flex-col items-start" dir="rtl">
        <div class="text-pink-700 text-lg font-semibold mb-2">یه حرف دلی 💌</div>
        <p class="text-sm text-gray-700 mb-3 leading-relaxed">
          عزیزم،
          <br>
          هر آرزویی که از تهِ دل می‌کنی، آرام‌آرام نزدیک‌تر می‌شود. امروز این لحظه برای توست — لبخند بزن و باور کن که همیشه کنارتم.
        </p>
        <div class="mt-auto pt-2 w-full">
          <div class="text-xs text-gray-500">با عشق،</div>
          <div class="text-sm font-medium text-pink-600">همیشهِ تو ❤</div>
        </div>
      </aside>
    </div>
  </div>
</div>

<script>
  // Trigger modal on page load (e.g., after a short delay for animation or user readiness) - commented out since button-triggered
  document.addEventListener('DOMContentLoaded', function() {
    // setTimeout(() => document.getElementById('wishModal').classList.remove('hidden'), 1000); // Auto-open example
  });

  async function submitWish(){
    const body = document.getElementById('wishInput').value.trim();
    if(!body) return alert('Please write a short wish ❤️');

    const tokenMeta = document.querySelector('meta[name=csrf-token]');
    const token = tokenMeta ? tokenMeta.getAttribute('content') : '';
    const modal = document.getElementById('wishModal');
    const saveUrl = modal.dataset.saveUrl;
    const byeUrl = modal.dataset.byeUrl;

    try{
      const res = await fetch(saveUrl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json','X-CSRF-TOKEN': token },
        body: JSON.stringify({ wish: body })
      });

      if (!res.ok) {
        if (res.status === 419) {
          return alert('Session expired — please refresh the page and try again.');
        }
        const text = await res.text();
        try {
          const json = JSON.parse(text);
          return alert(json.message || 'Could not save your wish right now.');
        } catch (err) {
          return alert('Server error (' + res.status + '). Please try again.');
        }
      }

      let data;
      try { data = await res.json(); } catch (err) { return alert('Unexpected server response. Please try again.'); }

      alert(data.message || 'Saved! ✨');

      // If server asks for next step (personal message), show the second box
      if (data.next === 'message'){
        showPersonalMessageStep();
        return;
      }

      // else finish
      if (data.done) {
        if(window._confetti) window._confetti();
        window.location = byeUrl;
      } else {
        window.location = byeUrl;
      }
    }catch(e){
      console.error('submitWish error', e);
      alert('Network error: Could not save your wish right now.');
    }
  }

  function showPersonalMessageStep(){
    const left = document.querySelector('#wishModal .md\\:flex-1');
    if(!left) return;
    left.innerHTML = `
      <h3 class="text-xl font-semibold text-pink-600 mb-2">یک حرف از دل برای او 💌</h3>
      <p class="text-sm text-gray-600 mb-4">اگر دوست داری یک پیام شخصی هم بنویس — این پیام به صورت جداگانه ذخیره می‌شود.</p>
      <form id="messageForm" onsubmit="event.preventDefault(); submitMessage();">
        <textarea id="messageInput" name="message" rows="6" class="w-full border rounded p-3 mb-3" placeholder="حرف دلت را بنویس..."></textarea>
        <div class="flex items-center justify-between">
          <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white font-semibold py-2 px-4 rounded">ارسال ♥️</button>
          <button type="button" onclick="closeWish()" class="text-sm text-gray-600">نه لازم نیست</button>
        </div>
      </form>
    `;
    // Focus on the new textarea
    setTimeout(() => {
      const textarea = document.getElementById('messageInput');
      if (textarea) textarea.focus();
    }, 100);
  }

  async function submitMessage(){
    const body = document.getElementById('messageInput').value.trim();
    if(!body) return alert('If you want, write a short message ❤️');
    const tokenMeta = document.querySelector('meta[name=csrf-token]');
    const token = tokenMeta ? tokenMeta.getAttribute('content') : '';
    const modal = document.getElementById('wishModal');
    const saveUrl = modal.dataset.saveUrl;
    const byeUrl = modal.dataset.byeUrl;

    try{
      const res = await fetch(saveUrl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json','X-CSRF-TOKEN': token },
        body: JSON.stringify({ message: body })
      });

      if (!res.ok) {
        if (res.status === 419) {
          return alert('Session expired — please refresh the page and try again.');
        }
        const text = await res.text();
        try {
          const json = JSON.parse(text);
          return alert(json.message || 'Could not save your personal message right now.');
        } catch (err) {
          return alert('Server error (' + res.status + '). Please try again.');
        }
      }

      let data;
      try { data = await res.json(); } catch (err) { return alert('Unexpected server response. Please try again.'); }

      alert(data.message || 'Saved! ✨');
      if(window._confetti) window._confetti();
      if (data.done) window.location = byeUrl; else window.location = byeUrl;
    }catch(e){
      console.error('submitMessage error', e);
      alert('Network error: Could not save your personal message right now.');
    }
  }

  function closeWish(){
    document.getElementById('wishModal').classList.add('hidden');
  }
</script>