## Get Started

This guide will walk you through the steps needed to get this project up and running on your local machine.

### Prerequisites

Before you begin, ensure you have the following installed:

- Docker
- Docker Compose

### Building the Docker Environment

Build and start the containers:

```
docker-compose up -d --build
```

### Installing Dependencies

```
docker-compose exec app sh
composer install
```

### Database Setup

Set up the database:

```
bin/cake migrations migrate
```

### Accessing the Application

The application should now be accessible at http://localhost:34251

## How to check

### Authentication
I created 2 accounts with the following information (Please run the migration again if you have run it before):
```
User1
email: pham.bqt@gmail.com
pass: P@ss1234tai

User2
email: pham.bqt2@gmail.com
pass: P@ss1234tai2
```
Login page:
http://localhost:34251/login

