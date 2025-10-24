document.addEventListener('DOMContentLoaded', () => {
  // Mobile menu toggle
  const btn = document.getElementById('menu-toggle');
  const menu = document.getElementById('mobile-menu');
  if (btn && menu) {
    btn.addEventListener('click', () => {
      const wasHidden = menu.classList.toggle('hidden');
      const isOpen = !wasHidden;
      btn.setAttribute('aria-expanded', String(isOpen));
    });
    menu.addEventListener('click', (e) => {
      const a = e.target.closest('a');
      if (a) {
        menu.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
      }
    });
  }

  // Lazy-load inline SVG from <template> into placeholders
  const targets = document.querySelectorAll('[data-lazy-svg]');
  if (targets.length) {
    const load = (el) => {
      const id = el.getAttribute('data-lazy-svg');
      const tpl = document.getElementById(id);
      if (tpl && 'content' in tpl) {
        el.appendChild(tpl.content.cloneNode(true));
        el.removeAttribute('data-lazy-svg');
      }
    };

    if ('IntersectionObserver' in window) {
      const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            load(entry.target);
            io.unobserve(entry.target);
          }
        });
      }, { rootMargin: '200px 0px' });
      targets.forEach(t => io.observe(t));
    } else {
      targets.forEach(load);
    }
  }
});

