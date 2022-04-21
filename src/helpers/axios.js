import axios from 'axios';
import {backendUrl} from '../config.js';

const adminSlug = window.location.hash.split("/")[1];
const adminString = (adminSlug) ? `/${adminSlug}` : ''; 

const axiosInstance = axios.create({
baseURL: `${backendUrl}${adminString}`,
});



export default axiosInstance;