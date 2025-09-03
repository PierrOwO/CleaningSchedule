import './schedule/house.js';
import './schedule/room.js';
import './schedule/tenant.js';

import axios from 'axios';
window.axios = axios;
axios.defaults.headers.common['X-CSRF-TOKEN'] =
document.querySelector('meta[name="csrf-token"]').getAttribute('content');