import axios from 'axios';

export const HTTP = axios.create({
    baseURL: '/',
    withCredentials: false,
    timeout: 3000
});
