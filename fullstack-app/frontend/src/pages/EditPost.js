import React, { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { postsAPI } from '../services/api';
import { useAuth } from '../contexts/AuthContext';
import LoadingSpinner from '../components/ui/LoadingSpinner';
import Alert from '../components/ui/Alert';

const EditPost = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const { user } = useAuth();
  const [post, setPost] = useState(null);
  const [formData, setFormData] = useState({
    title: '',
    content: ''
  });
  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState('');
  const [fieldErrors, setFieldErrors] = useState({});

  useEffect(() => {
    if (id) {
      fetchPost();
    }
  }, [id]);

  const fetchPost = async () => {
    try {
      setLoading(true);
      setError('');
      const response = await postsAPI.getPostById(id);
      const postData = response.data.post;
      
      // Check if user owns this post
      if (user && postData.user_id !== user.id) {
        setError('You can only edit your own posts.');
        return;
      }
      
      setPost(postData);
      setFormData({
        title: postData.title,
        content: postData.content
      });
    } catch (error) {
      console.error('Error fetching post:', error);
      if (error.response?.status === 404) {
        setError('Post not found.');
      } else if (error.response?.status === 403) {
        setError('You are not authorized to edit this post.');
      } else {
        setError('Failed to load post. Please try again later.');
      }
    } finally {
      setLoading(false);
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
    
    // Clear field error when user starts typing
    if (fieldErrors[name]) {
      setFieldErrors(prev => ({
        ...prev,
        [name]: ''
      }));
    }
  };

  const validateForm = () => {
    const errors = {};

    // Title validation
    if (!formData.title.trim()) {
      errors.title = 'Title is required';
    } else if (formData.title.trim().length < 5) {
      errors.title = 'Title must be at least 5 characters long';
    } else if (formData.title.trim().length > 200) {
      errors.title = 'Title must be less than 200 characters';
    }

    // Content validation
    if (!formData.content.trim()) {
      errors.content = 'Content is required';
    } else if (formData.content.trim().length < 20) {
      errors.content = 'Content must be at least 20 characters long';
    }

    setFieldErrors(errors);
    return Object.keys(errors).length === 0;
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setSaving(true);
    setError('');

    if (!validateForm()) {
      setSaving(false);
      return;
    }

    try {
      const postData = {
        title: formData.title.trim(),
        content: formData.content.trim()
      };

      const response = await postsAPI.updatePost(id, postData);
      
      if (response.data.post) {
        // Redirect to the updated post
        navigate(`/posts/${id}`);
      } else {
        setError('Post updated but unable to redirect. Please check your post.');
      }
    } catch (error) {
      console.error('Update post error:', error);
      
      if (error.response?.data?.errors) {
        // Handle validation errors from backend
        const backendErrors = {};
        error.response.data.errors.forEach(err => {
          backendErrors[err.path || err.param] = err.msg;
        });
        setFieldErrors(backendErrors);
      } else {
        setError(error.response?.data?.message || 'Failed to update post. Please try again.');
      }
    } finally {
      setSaving(false);
    }
  };

  const handleCancel = () => {
    navigate(`/posts/${id}`);
  };

  if (loading) {
    return (
      <div className="flex justify-center align-center" style={{ minHeight: '400px' }}>
        <LoadingSpinner size="lg" />
      </div>
    );
  }

  if (error && !post) {
    return (
      <div className="text-center">
        <Alert type="error" message={error} />
        <div className="mt-6">
          <button onClick={() => navigate(-1)} className="btn btn-secondary">
            Go Back
          </button>
        </div>
      </div>
    );
  }

  return (
    <div className="w-full" style={{ maxWidth: '800px', margin: '0 auto' }}>
      <div className="card">
        <div className="card-header">
          <h2 className="card-title">Edit Post</h2>
          <p className="text-gray-600">Update your post content</p>
        </div>

        {error && (
          <Alert 
            type="error" 
            message={error} 
            onClose={() => setError('')} 
          />
        )}

        {post && (
          <form onSubmit={handleSubmit}>
            <div className="form-group">
              <label htmlFor="title" className="form-label">
                Post Title
              </label>
              <input
                type="text"
                id="title"
                name="title"
                value={formData.title}
                onChange={handleChange}
                className={`form-input ${fieldErrors.title ? 'border-danger-color' : ''}`}
                placeholder="Enter an engaging title for your post"
                maxLength="200"
                required
              />
              {fieldErrors.title && (
                <div className="form-error">{fieldErrors.title}</div>
              )}
              <div className="text-sm text-gray-500 mt-1">
                {formData.title.length}/200 characters
              </div>
            </div>

            <div className="form-group">
              <label htmlFor="content" className="form-label">
                Content
              </label>
              <textarea
                id="content"
                name="content"
                value={formData.content}
                onChange={handleChange}
                className={`form-input form-textarea ${fieldErrors.content ? 'border-danger-color' : ''}`}
                placeholder="Write your post content here..."
                rows="12"
                required
              />
              {fieldErrors.content && (
                <div className="form-error">{fieldErrors.content}</div>
              )}
              <div className="text-sm text-gray-500 mt-1">
                {formData.content.length} characters
              </div>
            </div>

            <div className="flex gap-4">
              <button
                type="submit"
                disabled={saving}
                className="btn btn-primary"
              >
                {saving ? (
                  <div className="flex align-center gap-2">
                    <LoadingSpinner size="sm" />
                    Updating...
                  </div>
                ) : (
                  'Update Post'
                )}
              </button>
              
              <button
                type="button"
                onClick={handleCancel}
                disabled={saving}
                className="btn btn-secondary"
              >
                Cancel
              </button>
            </div>
          </form>
        )}

        {/* Update Info */}
        {post && (
          <div className="mt-8 p-4 bg-gray-50 rounded-lg">
            <h4 className="font-medium text-gray-700 mb-2">Post Information:</h4>
            <div className="text-sm text-gray-600 space-y-1">
              <p><strong>Created:</strong> {new Date(post.created_at).toLocaleString()}</p>
              {post.updated_at !== post.created_at && (
                <p><strong>Last Updated:</strong> {new Date(post.updated_at).toLocaleString()}</p>
              )}
              <p><strong>Author:</strong> {post.author}</p>
            </div>
          </div>
        )}
      </div>
    </div>
  );
};

export default EditPost;