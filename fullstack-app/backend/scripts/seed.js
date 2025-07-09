const bcrypt = require('bcryptjs');
const { pool } = require('../config/database');
require('dotenv').config();

const seedDatabase = async () => {
  try {
    console.log('Seeding database with initial data...');

    // Check if users already exist
    const existingUsers = await pool.query('SELECT COUNT(*) FROM users');
    if (parseInt(existingUsers.rows[0].count) > 0) {
      console.log('Database already contains data. Skipping seed.');
      return;
    }

    // Create sample users
    const users = [
      {
        username: 'admin',
        email: 'admin@example.com',
        password: 'admin123'
      },
      {
        username: 'john_doe',
        email: 'john@example.com',
        password: 'password123'
      },
      {
        username: 'jane_smith',
        email: 'jane@example.com',
        password: 'password123'
      }
    ];

    const createdUsers = [];

    for (const user of users) {
      const hashedPassword = await bcrypt.hash(user.password, 12);
      
      const result = await pool.query(
        'INSERT INTO users (username, email, password) VALUES ($1, $2, $3) RETURNING id, username, email',
        [user.username, user.email, hashedPassword]
      );
      
      createdUsers.push(result.rows[0]);
      console.log(`✅ Created user: ${user.username}`);
    }

    // Create sample posts
    const posts = [
      {
        title: 'Welcome to Our Blog!',
        content: 'This is the first post on our amazing blog platform. Built with React.js, Node.js Express, and PostgreSQL!',
        user_id: createdUsers[0].id
      },
      {
        title: 'Getting Started with React',
        content: 'React is a powerful JavaScript library for building user interfaces. In this post, we\'ll explore the basics of React components, state management, and props.',
        user_id: createdUsers[1].id
      },
      {
        title: 'Node.js Express Best Practices',
        content: 'Express.js is a minimal and flexible Node.js web application framework. Here are some best practices for building scalable APIs with Express.',
        user_id: createdUsers[1].id
      },
      {
        title: 'PostgreSQL Tips and Tricks',
        content: 'PostgreSQL is one of the most advanced open-source relational databases. Learn some useful tips and tricks to optimize your database queries.',
        user_id: createdUsers[2].id
      },
      {
        title: 'Full-Stack Development Journey',
        content: 'Building full-stack applications requires knowledge of frontend, backend, and database technologies. This post shares insights from the development journey.',
        user_id: createdUsers[2].id
      }
    ];

    for (const post of posts) {
      await pool.query(
        'INSERT INTO posts (title, content, user_id) VALUES ($1, $2, $3)',
        [post.title, post.content, post.user_id]
      );
      console.log(`✅ Created post: ${post.title}`);
    }

    console.log('\n🎉 Database seeded successfully!');
    console.log('\nSample login credentials:');
    console.log('Email: admin@example.com, Password: admin123');
    console.log('Email: john@example.com, Password: password123');
    console.log('Email: jane@example.com, Password: password123');

  } catch (error) {
    console.error('❌ Error seeding database:', error.message);
    process.exit(1);
  } finally {
    await pool.end();
  }
};

if (require.main === module) {
  seedDatabase();
}

module.exports = { seedDatabase };