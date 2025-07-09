import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { postsAPI } from '../services/api';
import { useAuth } from '../contexts/AuthContext';
import LoadingSpinner from '../components/ui/LoadingSpinner';
import Alert from '../components/ui/Alert';

const CreatePost = () => {
  const [formData, setFormData] = useState({
    title: '',
    content: ''
  });
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const [fieldErrors, setFieldErrors] = useState({});

  const { user } = useAuth();
  const navigate = useNavigate();

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
    setLoading(true);
    setError('');

    if (!validateForm()) {
      setLoading(false);
      return;
    }

    try {
      const postData = {
        title: formData.title.trim(),
        content: formData.content.trim()
      };

      const response = await postsAPI.createPost(postData);
      
      if (response.data.post) {
        // Redirect to the newly created post
        navigate(`/posts/${response.data.post.id}`);
      } else {
        setError('Post created but unable to redirect. Please check your posts.');
      }
    } catch (error) {
      console.error('Create post error:', error);
      
      if (error.response?.data?.errors) {
        // Handle validation errors from backend
        const backendErrors = {};
        error.response.data.errors.forEach(err => {
          backendErrors[err.path || err.param] = err.msg;
        });
        setFieldErrors(backendErrors);
      } else {
        setError(error.response?.data?.message || 'Failed to create post. Please try again.');
      }
    } finally {
      setLoading(false);
    }
  };

  const handleCancel = () => {
    navigate(-1); // Go back to previous page
  };

  return (
    <div className="w-full" style={{ maxWidth: '800px', margin: '0 auto' }}>
      <div className="card">
        <div className="card-header">
          <h2 className="card-title">Create New Post</h2>
          <p className="text-gray-600">Share your thoughts with the community</p>
        </div>

        {error && (
          <Alert 
            type="error" 
            message={error} 
            onClose={() => setError('')} 
          />
        )}

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
              placeholder="Write your post content here... Share your ideas, experiences, or insights."
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
              disabled={loading}
              className="btn btn-primary"
            >
              {loading ? (
                <div className="flex align-center gap-2">
                  <LoadingSpinner size="sm" />
                  Publishing...
                </div>
              ) : (
                'Publish Post'
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

        {/* Writing Tips */}
        <div className="mt-8 p-4 bg-gray-50 rounded-lg">
          <h4 className="font-medium text-gray-700 mb-2">Writing Tips:</h4>
          <ul className="text-sm text-gray-600 space-y-1">
            <li>• Use a clear, descriptive title that captures the essence of your post</li>
            <li>• Structure your content with paragraphs for better readability</li>
            <li>• Share personal experiences, insights, or helpful information</li>
            <li>• Be respectful and constructive in your writing</li>
            <li>• Proofread your post before publishing</li>
          </ul>
        </div>
      </div>
    </div>
  );
};

export default CreatePost;