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

