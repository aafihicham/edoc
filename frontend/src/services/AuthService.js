import http from './axiosInstance'; 

const AuthService = {
    login(credentials) {
        return http.post('login', credentials).then(response => {
            if (response.data.token) {
                localStorage.setItem('token', response.data.token);
            }
            return response.data; 
        });
    },
    logout() {
        return http.post('logout').then(response => {
            localStorage.removeItem('token');
            return response.data;
        });
    },
    getUser() {
        return http.get('user');
    }
};

export default AuthService;
