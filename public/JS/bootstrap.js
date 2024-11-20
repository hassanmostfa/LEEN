import _ from 'lodash';
window._ = _;

/**
 * Load the Axios HTTP library to issue requests to the Laravel back-end.
 * Axios automatically handles the CSRF token as a header based on the
 * value of the "XSRF" token cookie.
 */
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events broadcast by Laravel. It helps build robust real-time web apps.
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js'; // Import Pusher for real-time functionality

window.Pusher = Pusher; // Assign Pusher to the global scope

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '02c14683a1bbc058e455', // Replace with your Pusher app key
    cluster: 'eu',               // Replace with your Pusher app cluster
    forceTLS: true,              // Ensure TLS is enabled
});
