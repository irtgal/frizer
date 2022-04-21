import axios from 'axios';
import {backendUrl} from '../config.js';

const adminRoutes = ["/admin"];

function prepareToken() {
    const currentHash = window.location.hash.slice(1);
    if (adminRoutes.indexOf(currentHash) == -1) {
        return;
    }
    const token = localStorage.getItem("token");
    if (!token) {
        window.location.hash = `/prijava`;
        return;
    }
    axiosInstance.interceptors.request.use((request) => {
        request.headers = {
          'Authorization': 'Bearer ' + token,
          'Accept': 'application/json',
        };    
        return request;
      });

  }

const axiosInstance = axios.create({
baseURL: backendUrl,
});

prepareToken();

window.addEventListener('hashchange', () => {
    prepareToken();
});


export default axiosInstance;