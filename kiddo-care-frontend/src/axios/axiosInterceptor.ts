import axios from 'axios';
import type { AxiosInstance, AxiosResponse, AxiosError, InternalAxiosRequestConfig } from 'axios';
import { ElNotification } from 'element-plus'

// Get the base URL from environment variables
const baseURL = import.meta.env.VITE_API_BASE_URL || 'http://localhost/api';

// Create an instance of Axios
const instance: AxiosInstance = axios.create({
    baseURL: baseURL,
    headers: {
        'Content-Type': 'application/json',
    },
});

// Request interceptor
instance.interceptors.request.use(
    (config: InternalAxiosRequestConfig) => {
        // Do something before request is sent
        return config;
    },
    (error: AxiosError) => {
        // Do something with request error
        return Promise.reject(error);
    }
);

// Response interceptor
instance.interceptors.response.use(
    (response: AxiosResponse) => {
        // Do something with response data
        if (response.data.message) {
            ElNotification({
                title: 'Error',
                message: response.data.message,
                type: 'success',
            })
        }

        return response;
    },
    (error: any) => {
        // Do something with response error
        const errorMessage = error.response?.data?.message;
        ElNotification({
            title: 'Error',
            message: errorMessage,
            type: 'error',
        })
        return Promise.reject(error);
    }
);

export default instance;
