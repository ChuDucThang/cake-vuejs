import React from 'react';
import { Routes, Route } from 'react-router-dom';
import { useAuth } from './contexts/AuthContext';

// Components
import Navbar from './components/layout/Navbar';
import LoadingSpinner from './components/ui/LoadingSpinner';
import ProtectedRoute from './components/auth/ProtectedRoute';

// Pages
import Home from './pages/Home';
import Login from './pages/Login';
import Register from './pages/Register';
import Profile from './pages/Profile';
import CreatePost from './pages/CreatePost';
import EditPost from './pages/EditPost';
import PostDetail from './pages/PostDetail';
import Users from './pages/Users';
import NotFound from './pages/NotFound';

function App() {
  const { loading } = useAuth();

  if (loading) {
    return (
      <div className="flex justify-center align-center" style={{ minHeight: '100vh' }}>
        <LoadingSpinner size="lg" />
      </div>
    );
  }

  return (
    <div className="App">
      <Navbar />
      <main className="container" style={{ minHeight: 'calc(100vh - 80px)', paddingTop: '2rem' }}>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
          <Route path="/users" element={<Users />} />
          <Route path="/posts/:id" element={<PostDetail />} />
          
          {/* Protected Routes */}
          <Route path="/profile" element={
            <ProtectedRoute>
              <Profile />
            </ProtectedRoute>
          } />
          <Route path="/create-post" element={
            <ProtectedRoute>
              <CreatePost />
            </ProtectedRoute>
          } />
          <Route path="/edit-post/:id" element={
            <ProtectedRoute>
              <EditPost />
            </ProtectedRoute>
          } />
          
          {/* 404 Route */}
          <Route path="*" element={<NotFound />} />
        </Routes>
      </main>
      
      {/* Footer */}
      <footer className="bg-white border" style={{ marginTop: '3rem', padding: '2rem 0' }}>
        <div className="container text-center">
          <p className="text-gray-500 text-sm">
            Built with React.js, Node.js Express, and PostgreSQL | © 2024 Full-Stack Blog App
          </p>
        </div>
      </footer>
    </div>
  );
}

export default App;