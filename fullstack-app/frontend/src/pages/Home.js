import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { postsAPI } from '../services/api';
import LoadingSpinner from '../components/ui/LoadingSpinner';
import Alert from '../components/ui/Alert';

const Home = () => {
  const [posts, setPosts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [pagination, setPagination] = useState({});
  const [currentPage, setCurrentPage] = useState(1);

  useEffect(() => {
    fetchPosts(currentPage);
  }, [currentPage]);

  const fetchPosts = async (page = 1) => {
    try {
      setLoading(true);
      setError('');
      const response = await postsAPI.getPosts({ page, limit: 6 });
      setPosts(response.data.posts);
      setPagination(response.data.pagination);
    } catch (error) {
      console.error('Error fetching posts:', error);
      setError('Failed to load posts. Please try again later.');
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

  const truncateContent = (content, maxLength = 150) => {
    if (content.length <= maxLength) return content;
    return content.substr(0, maxLength) + '...';
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
      {/* Hero Section */}
      <div className="bg-white rounded-lg shadow-md p-8 mb-8 text-center">
        <h1 className="mb-4">Welcome to BlogApp</h1>
        <p className="text-lg text-gray-600 mb-6">
          Discover amazing stories, insights, and ideas from our community of writers.
          Built with React.js, Node.js Express, and PostgreSQL.
        </p>
        <div className="flex justify-center gap-4">
          <Link to="/register" className="btn btn-primary">
            Join Our Community
          </Link>
          <Link to="/users" className="btn btn-secondary">
            Browse Writers
          </Link>
        </div>
      </div>

      {/* Error Alert */}
      {error && (
        <Alert 
          type="error" 
          message={error} 
          onClose={() => setError('')} 
        />
      )}

      {/* Posts Section */}
      <div className="flex justify-between align-center mb-6">
        <h2>Latest Posts</h2>
        <Link to="/create-post" className="btn btn-primary">
          Write a Post
        </Link>
      </div>

      {posts.length === 0 ? (
        <div className="text-center py-8">
          <p className="text-gray-500 mb-4">No posts available yet.</p>
          <Link to="/create-post" className="btn btn-primary">
            Be the first to write a post!
          </Link>
        </div>
      ) : (
        <>
          {/* Posts Grid */}
          <div className="grid" style={{ 
            display: 'grid', 
            gridTemplateColumns: 'repeat(auto-fit, minmax(350px, 1fr))', 
            gap: '1.5rem',
            marginBottom: '2rem'
          }}>
            {posts.map((post) => (
              <article key={post.id} className="card">
                <div className="card-header">
                  <h3 className="card-title">
                    <Link to={`/posts/${post.id}`} className="text-gray-900">
                      {post.title}
                    </Link>
                  </h3>
                  <div className="flex justify-between align-center text-sm text-gray-500">
                    <span>By {post.author}</span>
                    <span>{formatDate(post.created_at)}</span>
                  </div>
                </div>
                
                <div className="mb-4">
                  <p className="text-gray-700">
                    {truncateContent(post.content)}
                  </p>
                </div>
                
                <div className="flex justify-between align-center">
                  <Link 
                    to={`/posts/${post.id}`} 
                    className="btn btn-primary btn-sm"
                  >
                    Read More
                  </Link>
                  <Link 
                    to={`/users/${post.user_id}`} 
                    className="text-sm text-gray-500"
                  >
                    View Profile
                  </Link>
                </div>
              </article>
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
    </div>
  );
};

export default Home;