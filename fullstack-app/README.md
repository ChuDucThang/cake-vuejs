# Full-Stack Blog Application

A modern full-stack web application built with **React.js**, **Node.js Express**, and **PostgreSQL**. This project demonstrates a complete blog platform with user authentication, post management, and a responsive user interface.

## 🚀 Features

### Backend (Node.js + Express + PostgreSQL)
- **RESTful API** with Express.js
- **PostgreSQL database** with proper relationships
- **JWT Authentication** for secure user sessions
- **Password hashing** with bcryptjs
- **Input validation** and sanitization
- **Rate limiting** for API protection
- **CORS configuration** for frontend integration
- **Database migrations** and seeding
- **Error handling** middleware

### Frontend (React.js)
- **Modern React** with hooks and functional components
- **React Router** for client-side routing
- **Context API** for state management
- **Responsive design** with custom CSS
- **Form validation** and error handling
- **Protected routes** for authenticated users
- **Axios** for API communication
- **Loading states** and user feedback

### Features
- 🔐 **User Registration & Login**
- 📝 **Create, Read, Update, Delete Posts**
- 👤 **User Profiles** with editable information
- 📄 **Pagination** for posts and users
- 🎨 **Modern UI** with responsive design
- 🔒 **Protected Routes** for authenticated content
- 📱 **Mobile-friendly** design

## 🛠️ Tech Stack

- **Frontend**: React.js, React Router, Axios, CSS3
- **Backend**: Node.js, Express.js, JWT, bcryptjs
- **Database**: PostgreSQL
- **Tools**: Docker (optional), pgAdmin (optional)

## 📋 Prerequisites

- **Node.js** (v16 or higher)
- **npm** or **yarn**
- **PostgreSQL** (v12 or higher)
- **Git**

## 🚀 Quick Start

### 1. Clone the Repository

\`\`\`bash
git clone <repository-url>
cd fullstack-app
\`\`\`

### 2. Database Setup

#### Option A: Using Docker (Recommended)

\`\`\`bash
# Start PostgreSQL with Docker Compose
docker-compose up -d postgres

# The database will be automatically created and initialized
\`\`\`

#### Option B: Local PostgreSQL

1. Install PostgreSQL locally
2. Create a database named \`fullstack_app\`
3. Update database credentials in \`backend/.env\`

### 3. Backend Setup

\`\`\`bash
# Navigate to backend directory
cd backend

# Install dependencies
npm install

# Set up environment variables
cp .env.example .env
# Edit .env file with your database credentials

# Set up database tables
npm run db:setup

# Seed database with sample data (optional)
npm run db:seed

# Start the development server
npm run dev
\`\`\`

The backend will run on http://localhost:5000

### 4. Frontend Setup

Open a new terminal:

\`\`\`bash
# Navigate to frontend directory
cd frontend

# Install dependencies
npm install

# Start the development server
npm start
\`\`\`

The frontend will run on http://localhost:3000

### 5. Start Both Servers

From the root directory:

\`\`\`bash
# Install root dependencies
npm install

# Start both backend and frontend concurrently
npm run dev
\`\`\`

## 📚 API Documentation

### Authentication Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/auth/register` | Register a new user |
| POST | `/api/auth/login` | Login user |
| GET | `/api/auth/me` | Get current user (protected) |

### User Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/users` | Get all users (paginated) |
| GET | `/api/users/:id` | Get user by ID |
| PUT | `/api/users/profile` | Update user profile (protected) |

### Post Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/posts` | Get all posts (paginated) |
| GET | `/api/posts/:id` | Get post by ID |
| POST | `/api/posts` | Create new post (protected) |
| PUT | `/api/posts/:id` | Update post (protected, owner only) |
| DELETE | `/api/posts/:id` | Delete post (protected, owner only) |
| GET | `/api/posts/user/:userId` | Get posts by user |

## 🧪 Demo Credentials

Use these credentials to test the application:

| Email | Password | Role |
|-------|----------|------|
| admin@example.com | admin123 | Admin User |
| john@example.com | password123 | Regular User |
| jane@example.com | password123 | Regular User |

## 📁 Project Structure

\`\`\`
fullstack-app/
├── backend/                 # Express.js backend
│   ├── config/             # Database configuration
│   ├── middleware/         # Custom middleware
│   ├── routes/            # API routes
│   ├── scripts/           # Database scripts
│   ├── .env               # Environment variables
│   ├── .env.example       # Environment template
│   ├── package.json       # Backend dependencies
│   └── server.js          # Main server file
├── frontend/               # React.js frontend
│   ├── public/            # Static files
│   ├── src/
│   │   ├── components/    # Reusable components
│   │   ├── contexts/      # React contexts
│   │   ├── pages/         # Page components
│   │   ├── services/      # API services
│   │   ├── App.js         # Main app component
│   │   ├── index.js       # App entry point
│   │   └── index.css      # Global styles
│   └── package.json       # Frontend dependencies
├── database/              # Database files
│   └── init.sql          # Database initialization
├── docker-compose.yml     # Docker services
├── package.json          # Root package.json
└── README.md             # This file
\`\`\`

## 🔧 Available Scripts

### Root Directory

- \`npm run dev\` - Start both frontend and backend
- \`npm run install:all\` - Install all dependencies
- \`npm run setup\` - Complete setup including database

### Backend

- \`npm start\` - Start production server
- \`npm run dev\` - Start development server with nodemon
- \`npm run db:setup\` - Create database tables
- \`npm run db:seed\` - Seed database with sample data

### Frontend

- \`npm start\` - Start development server
- \`npm run build\` - Build for production
- \`npm test\` - Run tests

## 🌍 Environment Variables

### Backend (.env)

\`\`\`env
NODE_ENV=development
PORT=5000
DB_HOST=localhost
DB_PORT=5432
DB_NAME=fullstack_app
DB_USER=postgres
DB_PASSWORD=password
JWT_SECRET=your-secret-key
FRONTEND_URL=http://localhost:3000
\`\`\`

## 🚢 Deployment

### Backend Deployment

1. Set production environment variables
2. Build and deploy to your preferred platform (Heroku, AWS, etc.)
3. Set up production PostgreSQL database
4. Run database migrations

### Frontend Deployment

1. Build the React app: \`npm run build\`
2. Deploy the \`build\` folder to your hosting platform
3. Configure API URL for production

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch: \`git checkout -b feature-name\`
3. Commit your changes: \`git commit -m 'Add feature'\`
4. Push to the branch: \`git push origin feature-name\`
5. Submit a pull request

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Ensure PostgreSQL is running
   - Check database credentials in \`.env\`
   - Verify database exists

2. **CORS Errors**
   - Check \`FRONTEND_URL\` in backend \`.env\`
   - Ensure both servers are running

3. **Authentication Issues**
   - Clear browser local storage
   - Check JWT secret configuration

### Getting Help

- Check the [Issues](link-to-issues) page
- Create a new issue with detailed information
- Include error messages and steps to reproduce

## 🎉 Acknowledgments

- React.js team for the excellent frontend framework
- Express.js for the robust backend framework
- PostgreSQL for the reliable database system
- The open-source community for amazing packages and tools

---

**Happy Coding!** 🚀