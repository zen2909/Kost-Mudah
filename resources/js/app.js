import Alpine from 'alpinejs';

import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;

Alpine.start();

// Jalankan Lucide
document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});