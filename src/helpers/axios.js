import axios from 'axios';
import {backendUrl} from '../config.js';

const adminSlug = window.location.hash.split("/")[1];

const axiosInstance = axios.create({
baseURL: `${backendUrl}/${adminSlug}`,
});



export default axiosInstance;