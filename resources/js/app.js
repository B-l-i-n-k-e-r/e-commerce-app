import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

Alpine.plugin(focus);

window.Alpine = Alpine;

Alpine.start();

// Remove or comment out the Vue.js related code
// import { createApp } from 'vue';
// import ExampleComponent from './components/ExampleComponent.vue';
// app.component('example-component', ExampleComponent);
//
// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });
//
// app.mount('#app');