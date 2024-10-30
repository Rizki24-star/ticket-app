# TicketApp

TicketApp is a full-stack application designed to manage tickets efficiently. The frontend, built with React, provides an intuitive interface for users to create, update, and view tickets, while the backend, built with Laravel, handles data storage, authentication, and business logic.

## Features

- User authentication (login and logout)
- CRUD operations for tickets
- Real-time status updates
- Validation and error handling for data inputs

## Technologies Used

### Frontend (React)

- React
- Redux for state management
- Axios for HTTP requests
- Tailwind CSS for styling

### Backend (Laravel)

- Laravel
- Sanctum for API token authentication
- PostgreSQL for data storage

## Getting Started

### Prerequisites

- **Node.js** and **npm** (for frontend setup)
- **PHP** and **Composer** (for backend setup)
- **PostgreeSQL** 

### Installation

#### 1. Backend (Laravel)

1. Clone the repository and navigate to the backend folder:
   ```bash
   git clone <repository_url>
   cd ticket-app/backend
   composer install
   cp .env.example .env



update your .env
 - DB_CONNECTION=pgsql
 - DB_HOST=127.0.0.1
 - DB_PORT=3306
 - DB_DATABASE=your_db_nama
 - DB_USERNAME=root
 - DB_PASSWORD=password

  ```bash
php artisan key:generate
php artisan migrate --seed
php artisan serve
```



#### 2. Frontend (React)
 Clone the repository and navigate to the frontend folder:
   ```bash
   git clone <repository_url>
   cd ticket-app/frontend
npm install
npm run start

