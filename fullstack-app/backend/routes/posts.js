const express = require('express');
const { body, validationResult } = require('express-validator');
const { pool } = require('../config/database');
const { authenticateToken } = require('../middleware/auth');

const router = express.Router();

// Get all posts (public)
router.get('/', async (req, res) => {
  try {
    const page = parseInt(req.query.page) || 1;
    const limit = parseInt(req.query.limit) || 10;
    const offset = (page - 1) * limit;

    const result = await pool.query(`
      SELECT p.id, p.title, p.content, p.created_at, p.updated_at,
             u.id as user_id, u.username as author
      FROM posts p
      JOIN users u ON p.user_id = u.id
      ORDER BY p.created_at DESC
      LIMIT $1 OFFSET $2
    `, [limit, offset]);

    const countResult = await pool.query('SELECT COUNT(*) FROM posts');
    const totalPosts = parseInt(countResult.rows[0].count);
    const totalPages = Math.ceil(totalPosts / limit);

    res.json({
      posts: result.rows,
      pagination: {
        currentPage: page,
        totalPages,
        totalPosts,
        hasNextPage: page < totalPages,
        hasPrevPage: page > 1
      }
    });
  } catch (error) {
    console.error('Get posts error:', error);
    res.status(500).json({ message: 'Server error' });
  }
});

// Get post by ID
router.get('/:id', async (req, res) => {
  try {
    const postId = parseInt(req.params.id);
    
    if (isNaN(postId)) {
      return res.status(400).json({ message: 'Invalid post ID' });
    }

    const result = await pool.query(`
      SELECT p.id, p.title, p.content, p.created_at, p.updated_at,
             u.id as user_id, u.username as author
      FROM posts p
      JOIN users u ON p.user_id = u.id
      WHERE p.id = $1
    `, [postId]);

    if (result.rows.length === 0) {
      return res.status(404).json({ message: 'Post not found' });
    }

    res.json({ post: result.rows[0] });
  } catch (error) {
    console.error('Get post error:', error);
    res.status(500).json({ message: 'Server error' });
  }
});

// Create new post (authenticated)
router.post('/', authenticateToken, [
  body('title').isLength({ min: 1, max: 200 }).trim().escape(),
  body('content').isLength({ min: 1 }).trim()
], async (req, res) => {
  try {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }

    const { title, content } = req.body;
    const userId = req.user.id;

    const result = await pool.query(`
      INSERT INTO posts (title, content, user_id)
      VALUES ($1, $2, $3)
      RETURNING id, title, content, created_at, updated_at
    `, [title, content, userId]);

    const post = result.rows[0];

    res.status(201).json({
      message: 'Post created successfully',
      post: {
        ...post,
        user_id: userId,
        author: req.user.username
      }
    });
  } catch (error) {
    console.error('Create post error:', error);
    res.status(500).json({ message: 'Server error' });
  }
});

// Update post (authenticated, only own posts)
router.put('/:id', authenticateToken, [
  body('title').optional().isLength({ min: 1, max: 200 }).trim().escape(),
  body('content').optional().isLength({ min: 1 }).trim()
], async (req, res) => {
  try {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }

    const postId = parseInt(req.params.id);
    const { title, content } = req.body;
    const userId = req.user.id;

    if (isNaN(postId)) {
      return res.status(400).json({ message: 'Invalid post ID' });
    }

    // Check if post exists and belongs to user
    const existingPost = await pool.query(
      'SELECT id, user_id FROM posts WHERE id = $1',
      [postId]
    );

    if (existingPost.rows.length === 0) {
      return res.status(404).json({ message: 'Post not found' });
    }

    if (existingPost.rows[0].user_id !== userId) {
      return res.status(403).json({ message: 'Not authorized to update this post' });
    }

    // Build update query
    const updateFields = [];
    const updateParams = [];
    let paramCount = 1;

    if (title) {
      updateFields.push(`title = $${paramCount}`);
      updateParams.push(title);
      paramCount++;
    }

    if (content) {
      updateFields.push(`content = $${paramCount}`);
      updateParams.push(content);
      paramCount++;
    }

    if (updateFields.length === 0) {
      return res.status(400).json({ message: 'No fields to update' });
    }

    updateParams.push(postId);

    const result = await pool.query(`
      UPDATE posts 
      SET ${updateFields.join(', ')}, updated_at = CURRENT_TIMESTAMP
      WHERE id = $${paramCount}
      RETURNING id, title, content, created_at, updated_at
    `, updateParams);

    res.json({
      message: 'Post updated successfully',
      post: {
        ...result.rows[0],
        user_id: userId,
        author: req.user.username
      }
    });
  } catch (error) {
    console.error('Update post error:', error);
    res.status(500).json({ message: 'Server error' });
  }
});

// Delete post (authenticated, only own posts)
router.delete('/:id', authenticateToken, async (req, res) => {
  try {
    const postId = parseInt(req.params.id);
    const userId = req.user.id;

    if (isNaN(postId)) {
      return res.status(400).json({ message: 'Invalid post ID' });
    }

    // Check if post exists and belongs to user
    const existingPost = await pool.query(
      'SELECT id, user_id FROM posts WHERE id = $1',
      [postId]
    );

    if (existingPost.rows.length === 0) {
      return res.status(404).json({ message: 'Post not found' });
    }

    if (existingPost.rows[0].user_id !== userId) {
      return res.status(403).json({ message: 'Not authorized to delete this post' });
    }

    await pool.query('DELETE FROM posts WHERE id = $1', [postId]);

    res.json({ message: 'Post deleted successfully' });
  } catch (error) {
    console.error('Delete post error:', error);
    res.status(500).json({ message: 'Server error' });
  }
});

// Get posts by user
router.get('/user/:userId', async (req, res) => {
  try {
    const userId = parseInt(req.params.userId);
    const page = parseInt(req.query.page) || 1;
    const limit = parseInt(req.query.limit) || 10;
    const offset = (page - 1) * limit;

    if (isNaN(userId)) {
      return res.status(400).json({ message: 'Invalid user ID' });
    }

    const result = await pool.query(`
      SELECT p.id, p.title, p.content, p.created_at, p.updated_at,
             u.id as user_id, u.username as author
      FROM posts p
      JOIN users u ON p.user_id = u.id
      WHERE p.user_id = $1
      ORDER BY p.created_at DESC
      LIMIT $2 OFFSET $3
    `, [userId, limit, offset]);

    const countResult = await pool.query(
      'SELECT COUNT(*) FROM posts WHERE user_id = $1',
      [userId]
    );
    const totalPosts = parseInt(countResult.rows[0].count);
    const totalPages = Math.ceil(totalPosts / limit);

    res.json({
      posts: result.rows,
      pagination: {
        currentPage: page,
        totalPages,
        totalPosts,
        hasNextPage: page < totalPages,
        hasPrevPage: page > 1
      }
    });
  } catch (error) {
    console.error('Get user posts error:', error);
    res.status(500).json({ message: 'Server error' });
  }
});

module.exports = router;