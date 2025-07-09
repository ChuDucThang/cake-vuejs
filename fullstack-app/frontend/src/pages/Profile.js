import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';
import { usersAPI, postsAPI } from '../services/api';
import LoadingSpinner from '../components/ui/LoadingSpinner';
import Alert from '../components/ui/Alert';

const Profile = () => {
  const { user, updateUser } = useAuth();
  const [editing, setEditing] = useState(false);
  const [loading, setLoading] = useState(false);
  const [userPosts, setUserPosts] = useState([]);
  const [postsLoading, setPostsLoading] = useState(true);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const [formData, setFormData] = useState({
    username: user?.username || '',
    email: user?.email || ''
  });

  useEffect(() => {
    if (user) {
      fetchUserPosts();
    }
  }, [user]);

  const fetchUserPosts = async () => {
    try {
      setPostsLoading(true);
      const response = await postsAPI.getPostsByUser(user.id);
      setUserPosts(response.data.posts);
    } catch (error) {
      console.error('Error fetching user posts:', error);
    } finally {
      setPostsLoading(false);
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');
    setSuccess('');

    try {
      const response = await usersAPI.updateProfile(formData);
      updateUser(response.data.user);
      setSuccess('Profile updated successfully!');
      setEditing(false);
    } catch (error) {
      console.error('Profile update error:', error);
      setError(error.response?.data?.message || 'Failed to update profile');
    } finally {
      setLoading(false);
    }
  };

  const handleCancel = () => {
    setFormData({
      username: user?.username || '',
      email: user?.email || ''
    });
    setEditing(false);
    setError('');
  };

  const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    });
  };

  if (!user) {
    return (
      <div className="flex justify-center align-center" style={{ minHeight: '400px' }}>
        <LoadingSpinner size="lg" />
      </div>
    );
  }

  return (
    <div className="w-full" style={{ maxWidth: '800px', margin: '0 auto' }}>
      {/* Profile Section */}
      <div className="card mb-8">
        <div className="card-header">
          <div className="flex justify-between align-center">
            <h2 className="card-title">My Profile</h2>
            {!editing && (
              <button
                onClick={() => setEditing(true)}
                className="btn btn-secondary btn-sm"
              >
                Edit Profile
              </button>
            )}
          </div>
        </div>

        {error && (
          <Alert 
            type="error" 
            message={error} 
            onClose={() => setError('')} 
          />
        )}

        {success && (
          <Alert 
            type="success" 
            message={success} 
            onClose={() => setSuccess('')} 
          />
        )}

        {editing ? (
          <form onSubmit={handleSubmit}>
            <div className="form-group">
              <label htmlFor="username" className="form-label">
                Username
              </label>
              <input
                type="text"
                id="username"
                name="username"
                value={formData.username}
                onChange={handleChange}
                className="form-input"
                required
              />
            </div>

            <div className="form-group">
              <label htmlFor="email" className="form-label">
                Email Address
              </label>
              <input
                type="email"
                id="email"
                name="email"
                value={formData.email}
                onChange={handleChange}
                className="form-input"
                required
              />
            </div>

            <div className="flex gap-4">
              <button
                type="submit"
                disabled={loading}
                className="btn btn-primary"
              >
                {loading ? (
                  <div className="flex align-center gap-2">
                    <LoadingSpinner size="sm" />
                    Updating...
                  </div>
                ) : (
                  'Save Changes'
                )}
              </button>
              
              <button
                type="button"
                onClick={handleCancel}
                disabled={loading}
                className="btn btn-secondary"
              >
                Cancel
              </button>
            </div>
          </form>
        ) : (
          <div>
            <div className="mb-4">
              <h3 className="font-semibold text-gray-700">Username</h3>
              <p className="text-gray-600">{user.username}</p>
            </div>
            
            <div className="mb-4">
              <h3 className="font-semibold text-gray-700">Email</h3>
              <p className="text-gray-600">{user.email}</p>
            </div>
            
            <div className="mb-4">
              <h3 className="font-semibold text-gray-700">Member Since</h3>
              <p className="text-gray-600">{formatDate(user.created_at)}</p>
            </div>
          </div>
        )}
      </div>

      {/* Posts Section */}
      <div className="card">
        <div className="card-header">
          <div className="flex justify-between align-center">
            <h3 className="card-title">My Posts</h3>
            <Link to="/create-post" className="btn btn-primary btn-sm">
              Write New Post
            </Link>
          </div>
        </div>

        {postsLoading ? (
          <div className="flex justify-center py-8">
            <LoadingSpinner size="md" />
          </div>
        ) : userPosts.length === 0 ? (
          <div className="text-center py-8">
            <p className="text-gray-500 mb-4">You haven't written any posts yet.</p>
            <Link to="/create-post" className="btn btn-primary">
              Write Your First Post
            </Link>
          </div>
        ) : (
          <div className="space-y-4">
            {userPosts.map((post) => (
              <div key={post.id} className="border rounded-lg p-4">
                <div className="flex justify-between align-center mb-2">
                  <h4 className="font-medium">
                    <Link to={`/posts/${post.id}`} className="text-gray-900">
                      {post.title}
                    </Link>
                  </h4>
                  <div className="flex gap-2">
                    <Link 
                      to={`/edit-post/${post.id}`} 
                      className="btn btn-secondary btn-sm"
                    >
                      Edit
                    </Link>
                    <Link 
                      to={`/posts/${post.id}`} 
                      className="btn btn-primary btn-sm"
                    >
                      View
                    </Link>
                  </div>
                </div>
                
                <p className="text-gray-600 text-sm mb-2">
                  {post.content.length > 100 
                    ? `${post.content.substring(0, 100)}...` 
                    : post.content
                  }
                </p>
                
                <div className="text-xs text-gray-500">
                  Created: {formatDate(post.created_at)}
                  {post.updated_at !== post.created_at && (
                    <span> • Updated: {formatDate(post.updated_at)}</span>
                  )}
                </div>
              </div>
            ))}
          </div>
        )}
      </div>
    </div>
  );
};

export default Profile;