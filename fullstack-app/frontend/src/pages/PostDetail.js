import React, { useState, useEffect } from 'react';
import { useParams, useNavigate, Link } from 'react-router-dom';
import { postsAPI } from '../services/api';
import { useAuth } from '../contexts/AuthContext';
import LoadingSpinner from '../components/ui/LoadingSpinner';
import Alert from '../components/ui/Alert';

const PostDetail = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const { user, isAuthenticated } = useAuth();
  const [post, setPost] = useState(null);
  const [loading, setLoading] = useState(true);
  const [deleting, setDeleting] = useState(false);
  const [error, setError] = useState('');
  const [showDeleteConfirm, setShowDeleteConfirm] = useState(false);

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
      setPost(response.data.post);
    } catch (error) {
      console.error('Error fetching post:', error);
      if (error.response?.status === 404) {
        setError('Post not found.');
      } else {
        setError('Failed to load post. Please try again later.');
      }
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async () => {
    if (!showDeleteConfirm) {
      setShowDeleteConfirm(true);
      return;
    }

    try {
      setDeleting(true);
      await postsAPI.deletePost(id);
      navigate('/', { replace: true });
    } catch (error) {
      console.error('Error deleting post:', error);
      setError('Failed to delete post. Please try again.');
      setShowDeleteConfirm(false);
    } finally {
      setDeleting(false);
    }
  };

  const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    });
  };

  const formatContent = (content) => {
    return content.split('\n').map((paragraph, index) => (
      <p key={index} className="mb-4 text-gray-700 leading-relaxed">
        {paragraph}
      </p>
    ));
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
          <Link to="/" className="btn btn-primary">
            Go Back Home
          </Link>
        </div>
      </div>
    );
  }

  const isAuthor = isAuthenticated && user && post && user.id === post.user_id;

  return (
    <div className="w-full" style={{ maxWidth: '800px', margin: '0 auto' }}>
      {error && (
        <Alert 
          type="error" 
          message={error} 
          onClose={() => setError('')} 
        />
      )}

      {post && (
        <article className="card">
          {/* Post Header */}
          <header className="card-header">
            <h1 className="card-title mb-4">{post.title}</h1>
            
            <div className="flex justify-between align-center mb-4">
              <div className="flex align-center gap-4">
                <Link 
                  to={`/users/${post.user_id}`}
                  className="font-medium text-primary-color"
                >
                  {post.author}
                </Link>
                <span className="text-gray-500">•</span>
                <time className="text-gray-500 text-sm">
                  {formatDate(post.created_at)}
                </time>
                {post.updated_at !== post.created_at && (
                  <>
                    <span className="text-gray-500">•</span>
                    <span className="text-gray-500 text-sm">
                      Updated {formatDate(post.updated_at)}
                    </span>
                  </>
                )}
              </div>

              {/* Action Buttons for Author */}
              {isAuthor && (
                <div className="flex gap-2">
                  <Link 
                    to={`/edit-post/${post.id}`}
                    className="btn btn-secondary btn-sm"
                  >
                    Edit
                  </Link>
                  <button
                    onClick={handleDelete}
                    disabled={deleting}
                    className={`btn btn-danger btn-sm ${showDeleteConfirm ? 'bg-red-600' : ''}`}
                  >
                    {deleting ? (
                      <div className="flex align-center gap-2">
                        <LoadingSpinner size="sm" />
                        Deleting...
                      </div>
                    ) : showDeleteConfirm ? (
                      'Confirm Delete'
                    ) : (
                      'Delete'
                    )}
                  </button>
                  {showDeleteConfirm && (
                    <button
                      onClick={() => setShowDeleteConfirm(false)}
                      className="btn btn-secondary btn-sm"
                    >
                      Cancel
                    </button>
                  )}
                </div>
              )}
            </div>
          </header>

          {/* Post Content */}
          <div className="post-content">
            {formatContent(post.content)}
          </div>

          {/* Post Footer */}
          <footer className="mt-8 pt-6 border-t border-gray-200">
            <div className="flex justify-between align-center">
              <Link 
                to={`/users/${post.user_id}`}
                className="flex align-center gap-2 text-gray-600"
              >
                <div className="w-8 h-8 bg-primary-color rounded-full flex align-center justify-center text-white text-sm font-medium">
                  {post.author.charAt(0).toUpperCase()}
                </div>
                <div>
                  <div className="font-medium text-gray-900">{post.author}</div>
                  <div className="text-sm text-gray-500">View Profile</div>
                </div>
              </Link>

              <div className="flex gap-2">
                <Link to="/" className="btn btn-secondary btn-sm">
                  ← Back to Posts
                </Link>
                {!isAuthor && (
                  <Link to="/create-post" className="btn btn-primary btn-sm">
                    Write a Post
                  </Link>
                )}
              </div>
            </div>
          </footer>
        </article>
      )}

      {/* Delete Confirmation Warning */}
      {showDeleteConfirm && (
        <div className="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
          <p className="text-red-800 text-sm">
            <strong>Warning:</strong> This action cannot be undone. 
            Click "Confirm Delete" again to permanently delete this post.
          </p>
        </div>
      )}
    </div>
  );
};

export default PostDetail;