import './bootstrap';

// We don't import or start Alpine manually here anymore 
// because Livewire 3+ does it automatically.

document.addEventListener('livewire:init', () => {
    // If you need to add plugins:
    // window.Alpine.plugin(focus); 
    
    // This is where you can define global data if not doing it in Blade
    window.Alpine.data('navComponent', () => ({
        open: false,
        toggle() { this.open = !this.open }
    }));
});