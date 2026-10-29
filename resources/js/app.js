import './bootstrap';
import 'trix';
import Alpine from 'alpinejs';
import imageUploader from '@/components/imageUploader';
import { initDeleteProduct } from '@/components/deleteProduct';

window.imageUploader = imageUploader;

initDeleteProduct();

window.Alpine = Alpine;
Alpine.start();

console.log('Components registered:', {
    imageUploader: typeof window.imageUploader
});

// ── Scroll Reveal ────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const revealEls = document.querySelectorAll('[data-reveal]');
    if (revealEls.length) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const delay = parseInt(entry.target.dataset.delay ?? '0', 10);
                        setTimeout(() => entry.target.classList.add('reveal-visible'), delay);
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
        );
        revealEls.forEach((el) => observer.observe(el));
    }

    // ── Navbar Scroll — adds dark bg after 50 px ─────────────────────────
    const navbar = document.querySelector('[data-navbar]');
    if (navbar) {
        const toggleScrolled = () =>
            navbar.classList.toggle('navbar-scrolled', window.scrollY > 50);
        window.addEventListener('scroll', toggleScrolled, { passive: true });
        toggleScrolled();
    }
});

