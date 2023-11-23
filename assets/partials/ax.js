import axios, { AxiosError } from "axios";

const ax = axios.create({
  baseURL: process.env.API
});

ax.interceptors.response.use((response) => {
    return response;
}, /** @param error { AxiosError } */ function (error) {
    if (error.response?.status == 401) {
        window.location.reload();
    }
    return Promise.reject(error);
});

export default ax;
