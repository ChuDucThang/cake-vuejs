import axios from 'axios';

// Create axios instance with base configuration
export const apiService = axios.create({
  baseURL: process.env.REACT_APP_API_URL || '/api',
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
  },
});

// Request interceptor
apiService.interceptors.request.use(
  (config) => {
    // Add timestamp to prevent caching
    config.params = {
      ...config.params,
      _t: Date.now(),
    };
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Response interceptor
apiService.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    // Handle common errors
    if (error.response?.status === 401) {
      // Unauthorized - remove token and redirect to login
      localStorage.removeItem('token');
      delete apiService.defaults.headers.common['Authorization'];
      
      // Only redirect if we're not already on login/register pages
      if (!window.location.pathname.includes('/login') && !window.location.pathname.includes('/register')) {
        window.location.href = '/login';
      }
    }
    
    return Promise.reject(error);
  }
);

// API endpoints
export const authAPI = {
  login: (credentials) => apiService.post('/auth/login', credentials),
  register: (userData) => apiService.post('/auth/register', userData),
  getCurrentUser: () => apiService.get('/auth/me'),
};

export const usersAPI = {
  getUsers: (params = {}) => apiService.get('/users', { params }),
  getUserById: (id) => apiService.get(`/users/${id}`),
  updateProfile: (userData) => apiService.put('/users/profile', userData),
};

export const postsAPI = {
  getPosts: (params = {}) => apiService.get('/posts', { params }),
  getPostById: (id) => apiService.get(`/posts/${id}`),
  getPostsByUser: (userId, params = {}) => apiService.get(`/posts/user/${userId}`, { params }),
  createPost: (postData) => apiService.post('/posts', postData),
  updatePost: (id, postData) => apiService.put(`/posts/${id}`, postData),
  deletePost: (id) => apiService.delete(`/posts/${id}`),
};

export default apiService;