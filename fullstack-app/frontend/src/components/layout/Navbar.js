import React, { useState } from 'react';
import { Link, useLocation, useNavigate } from 'react-router-dom';
import { useAuth } from '../../contexts/AuthContext';

const Navbar = () => {
  const { user, isAuthenticated, logout } = useAuth();
  const location = useLocation();
  const navigate = useNavigate();
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);

  const handleLogout = () => {
    logout();
    navigate('/');
    setIsMobileMenuOpen(false);
  };

  const isActive = (path) => {
    return location.pathname === path;
  };

  const navItems = [
    { path: '/', label: 'Home', public: true },
    { path: '/users', label: 'Users', public: true },
    { path: '/create-post', label: 'Create Post', public: false },
    { path: '/profile', label: 'Profile', public: false },
  ];

  return (
    <nav className="navbar">
      <div className="container">
        <div className="navbar-content">
          <Link to="/" className="navbar-brand">
            BlogApp
          </Link>

          {/* Desktop Navigation */}
          <div className="navbar-nav" style={{ display: window.innerWidth <= 768 && isMobileMenuOpen ? 'none' : 'flex' }}>
            {navItems.map((item) => {
              if (!item.public && !isAuthenticated) return null;
              
              return (
                <Link
                  key={item.path}
                  to={item.path}
                  className={`nav-link ${isActive(item.path) ? 'active' : ''}`}
                >
                  {item.label}
                </Link>
              );
            })}

            {isAuthenticated ? (
              <div className="flex align-center gap-4">
                <span className="text-sm text-gray-600">
                  Welcome, {user?.username}!
                </span>
                <button onClick={handleLogout} className="btn btn-secondary btn-sm">
                  Logout
                </button>
              </div>
            ) : (
              <div className="flex gap-2">
                <Link to="/login" className="btn btn-secondary btn-sm">
                  Login
                </Link>
                <Link to="/register" className="btn btn-primary btn-sm">
                  Register
                </Link>
              </div>
            )}
          </div>

          {/* Mobile Menu Button */}
          <button
            className="btn btn-secondary btn-sm"
            style={{ display: window.innerWidth <= 768 ? 'block' : 'none' }}
            onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
          >
            ☰
          </button>
        </div>

        {/* Mobile Navigation */}
        {isMobileMenuOpen && (
          <div className="flex flex-column gap-2 mt-4" style={{ display: window.innerWidth <= 768 ? 'flex' : 'none' }}>
            {navItems.map((item) => {
              if (!item.public && !isAuthenticated) return null;
              
              return (
                <Link
                  key={item.path}
                  to={item.path}
                  className={`nav-link ${isActive(item.path) ? 'active' : ''}`}
                  onClick={() => setIsMobileMenuOpen(false)}
                >
                  {item.label}
                </Link>
              );
            })}

            {isAuthenticated ? (
              <div className="flex flex-column gap-2">
                <span className="text-sm text-gray-600 p-2">
                  Welcome, {user?.username}!
                </span>
                <button onClick={handleLogout} className="btn btn-secondary btn-sm">
                  Logout
                </button>
              </div>
            ) : (
              <div className="flex flex-column gap-2">
                <Link 
                  to="/login" 
                  className="btn btn-secondary btn-sm"
                  onClick={() => setIsMobileMenuOpen(false)}
                >
                  Login
                </Link>
                <Link 
                  to="/register" 
                  className="btn btn-primary btn-sm"
                  onClick={() => setIsMobileMenuOpen(false)}
                >
                  Register
                </Link>
              </div>
            )}
          </div>
        )}
      </div>
    </nav>
  );
};

export default Navbar;