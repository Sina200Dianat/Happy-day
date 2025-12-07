import './bootstrap';

// Small confetti helper (vanilla) — call _confetti() to burst a few pieces
window._confetti = function(){
	const count = 40;
	for(let i=0;i<count;i++){
		const el = document.createElement('div');
		el.style.position = 'fixed';
		el.style.zIndex = 9999;
		el.style.left = Math.random()*100 + '%';
		el.style.top = Math.random()*50 + '%';
		el.style.width = '8px';
		el.style.height = '8px';
		el.style.borderRadius = '2px';
		el.style.background = ['#FFC0CB','#FFD700','#FFB6C1','#FF69B4'][Math.floor(Math.random()*4)];
		el.style.opacity = '0.9';
		el.style.transform = `translateY(0) rotate(${Math.random()*360}deg)`;
		document.body.appendChild(el);
		setTimeout(()=>{
			el.style.transition = 'transform 1.2s ease-out, opacity 1.2s';
			el.style.transform = `translateY(400px) rotate(${Math.random()*720}deg)`;
			el.style.opacity = '0';
		},50);
		setTimeout(()=> el.remove(),1400);
	}
}

// Flower particles helper — call _flowers() to emit a few flower emojis
window._flowers = function(count = 12){
	const colors = ['#FFC0CB','#FFD1DC','#FFE4E1','#FFD700','#FFB6C1'];
	for(let i=0;i<count;i++){
		const el = document.createElement('div');
		el.className = 'flower-particle';
		el.style.position = 'fixed';
		el.style.zIndex = 9998;
		el.style.left = (10 + Math.random()*80) + '%';
		el.style.bottom = '-20px';
		el.style.fontSize = (14 + Math.random()*18) + 'px';
		el.style.pointerEvents = 'none';
		el.style.opacity = '0.95';
		el.style.transition = 'transform 2.2s ease-out, opacity 2.2s';
		el.style.transform = `translateY(0) rotate(${Math.random()*360}deg)`;
		el.textContent = '🌸';
		document.body.appendChild(el);
		// animate upward with slight horizontal drift and rotation
		setTimeout(()=>{
			const drift = (Math.random()*120 - 60);
			el.style.transform = `translate(${drift}px, -420px) rotate(${Math.random()*720}deg)`;
			el.style.opacity = '0';
		}, 50 + Math.random()*200);
		setTimeout(()=> el.remove(), 2600);
	}
}
