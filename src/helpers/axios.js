import axios from 'axios';
import {backendUrl} from '../config.js';


const axiosInstance = axios.create({
baseURL: backendUrl,
});



export default axiosInstance;