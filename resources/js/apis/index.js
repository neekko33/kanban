import Axios from 'axios';

const axios = Axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL,
    header: {
        common: {
            'X-Requested-With': 'XMLHttpRequest',
        },
        post: {
            'Content-Type': 'application/json',
        }
    },
    timeout: 10000,
    withCredentials: true,
    withXSRFToken: true,
});

export default axios;
