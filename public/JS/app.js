import './bootstrap'; // Ensure this line exists if you need Bootstrap or other dependencies

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key:'02c14683a1bbc058e455',
    cluster: 'eu',
    forceTLS: true,
});
