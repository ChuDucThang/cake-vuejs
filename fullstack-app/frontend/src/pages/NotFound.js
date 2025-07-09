import React from 'react';
import { Link } from 'react-router-dom';

const NotFound = () => {
  return (
    <div className="text-center" style={{ minHeight: '60vh', display: 'flex', flexDirection: 'column', justifyContent: 'center', alignItems: 'center' }}>
      <div className="card" style={{ maxWidth: '500px', margin: '0 auto' }}>
        <div style={{ fontSize: '6rem', marginBottom: '1rem' }}>🔍</div>
        
        <h1 style={{ fontSize: '4rem', fontWeight: 'bold', color: 'var(--primary-color)', marginBottom: '1rem' }}>
          404
        </h1>
        
        <h2 className="mb-4">Page Not Found</h2>
        
        <p className="text-gray-600 mb-6">
          Sorry, the page you're looking for doesn't exist. It might have been moved, deleted, or you entered the wrong URL.
        </p>
        
        <div className="flex justify-center gap-4">
          <Link to="/" className="btn btn-primary">
            Go Home
          </Link>
          <Link to="/posts" className="btn btn-secondary">
            Browse Posts
          </Link>
        </div>
      </div>
    </div>
  );
};

export default NotFound;