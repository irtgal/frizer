import axios from 'axios';
import {backendUrl} from '../config.js';

const adminSlug = window.location.pathname.split("/")[1];
const adminString = (adminSlug) ? `/${adminSlug}` : ''; 

const axiosInstance = axios.create({
baseURL: `${backendUrl}${adminString}`,
});



export {axiosInstance as default};