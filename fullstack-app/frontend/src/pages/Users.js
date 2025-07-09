import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { usersAPI } from '../services/api';
import LoadingSpinner from '../components/ui/LoadingSpinner';
import Alert from '../components/ui/Alert';

const Users = () => {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [pagination, setPagination] = useState({});
  const [currentPage, setCurrentPage] = useState(1);

  useEffect(() => {
    fetchUsers(currentPage);
  }, [currentPage]);

  const fetchUsers = async (page = 1) => {
    try {
      setLoading(true);
      setError('');
      const response = await usersAPI.getUsers({ page, limit: 12 });
      setUsers(response.data.users);
      setPagination(response.data.pagination);
    } catch (error) {
      console.error('Error fetching users:', error);
      setError('Failed to load users. Please try again later.');
    } finally {
      setLoading(false);
    }
  };

  const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    });
  };

  const getInitials = (username) => {
    return username.charAt(0).toUpperCase();
  };

  if (loading) {
    return (
      <div className="flex justify-center align-center" style={{ minHeight: '400px' }}>
        <LoadingSpinner size="lg" />
      </div>
    );
  }

  return (
    <div>
      {/* Header */}
      <div className="text-center mb-8">
        <h1 className="mb-4">Our Community</h1>
        <p className="text-lg text-gray-600 mb-6">
          Meet the amazing writers and contributors in our blogging community.
        </p>
        <Link to="/register" className="btn btn-primary">
          Join Our Community
        </Link>
      </div>

      {/* Error Alert */}
      {error && (
        <Alert 
          type="error" 
          message={error} 
          onClose={() => setError('')} 
        />
      )}

      {/* Users Count */}
      {pagination.totalUsers && (
        <div className="mb-6">
          <p className="text-gray-600">
            Showing {users.length} of {pagination.totalUsers} members
          </p>
        </div>
      )}

      {users.length === 0 ? (
        <div className="text-center py-8">
          <p className="text-gray-500 mb-4">No users found.</p>
          <Link to="/register" className="btn btn-primary">
            Be the first to join!
          </Link>
        </div>
      ) : (
        <>
          {/* Users Grid */}
          <div className="grid" style={{ 
            display: 'grid', 
            gridTemplateColumns: 'repeat(auto-fit, minmax(280px, 1fr))', 
            gap: '1.5rem',
            marginBottom: '2rem'
          }}>
            {users.map((user) => (
              <div key={user.id} className="card text-center">
                {/* Avatar */}
                <div 
                  className="w-16 h-16 bg-primary-color rounded-full flex align-center justify-center text-white text-xl font-bold mx-auto mb-4"
                >
                  {getInitials(user.username)}
                </div>

                {/* User Info */}
                <h3 className="mb-2">{user.username}</h3>
                <p className="text-gray-600 mb-4">{user.email}</p>
                
                <div className="text-sm text-gray-500 mb-4">
                  Member since {formatDate(user.created_at)}
                </div>

                {/* Actions */}
                <div className="flex justify-center gap-2">
                  <Link 
                    to={`/users/${user.id}`} 
                    className="btn btn-primary btn-sm"
                  >
                    View Profile
                  </Link>
                  <Link 
                    to={`/posts/user/${user.id}`} 
                    className="btn btn-secondary btn-sm"
                  >
                    View Posts
                  </Link>
                </div>
              </div>
            ))}
          </div>

          {/* Pagination */}
          {pagination.totalPages > 1 && (
            <div className="flex justify-center align-center gap-2">
              <button
                onClick={() => setCurrentPage(pagination.currentPage - 1)}
                disabled={!pagination.hasPrevPage}
                className="btn btn-secondary btn-sm"
              >
                Previous
              </button>
              
              <span className="px-4 py-2 text-sm text-gray-600">
                Page {pagination.currentPage} of {pagination.totalPages}
              </span>
              
              <button
                onClick={() => setCurrentPage(pagination.currentPage + 1)}
                disabled={!pagination.hasNextPage}
                className="btn btn-secondary btn-sm"
              >
                Next
              </button>
            </div>
          )}
        </>
      )}

      {/* Call to Action */}
      <div className="text-center mt-12 p-8 bg-white rounded-lg shadow-md">
        <h3 className="mb-4">Want to join our community?</h3>
        <p className="text-gray-600 mb-6">
          Create an account to start writing, sharing your thoughts, and connecting with other writers.
        </p>
        <div className="flex justify-center gap-4">
          <Link to="/register" className="btn btn-primary">
            Sign Up Now
          </Link>
          <Link to="/login" className="btn btn-secondary">
            Already a Member?
          </Link>
        </div>
      </div>
    </div>
  );
};

export default Users;