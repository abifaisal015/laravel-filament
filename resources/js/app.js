// Load the application CSS so Vite bundles/injects it during dev and build
import '../css/app.css';

// Import dan inisialisasi Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Place to register client-side JS (Alpine, Livewire hooks, etc.)
// Example: import './bootstrap';