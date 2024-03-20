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
I created 2 accounts with the following information:
```
User1
email: pham.bqt@gmail.com
pass: pass1234

User2
email: pham.bqt2@gmail.com
pass: pass1234
```

#### To get access token (login):

- Request:
```
POST http://localhost:34251/login
{
    "email": "pham.bqt@gmail.com",
    "password": "pass1234"
}
```
- Response:
```
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJteWFwcCIsInN1YiI6MSwiZXhwIjoxNzEwOTI2NjQ3fQ.Hw12qMLfvEf51wVgEVT1OupSgRRgLyrAUxJugcY36_yMST6NpoNfZ7N0-b7DYYPbaCWQ5evqJf0_ZB6abREgJ0dFYfGano3e7kikIOUB_90sIeo7LBlBJCXvVGLZdtDFw_Qxs_Qqd0rtXiDM3NQ04uFiovVkKZz0DxYVe6y2fA8"
}
```
The received access token will be used to authenticate requests that require authentication. 
Access token is generated by JWT(JSON Web Tokens). You can get more detail at https://jwt.io/.


Note: The access token validity period is 60 minutes.

### Article Management
#### 1, Retrieve All Articles (GET).
- Request:
```
GET http://localhost:34251/articles.json
```
- Response:
```
{
  "articles": [
    {
      "total_likes": 1,
      "id": 1,
      "user_id": 1,
      "title": "title article 113 update",
      "body": "body article 1",
      "created_at": "2024-03-20T03:41:22+00:00",
      "updated_at": "2024-03-20T08:25:17+00:00"
    },
    {
      "total_likes": 1,
      "id": 2,
      "user_id": 1,
      "title": "title article 3 update",
      "body": "body article 2",
      "created_at": "2024-03-20T03:41:22+00:00",
      "updated_at": "2024-03-20T06:14:48+00:00"
    },
    .
    .
    .
   {
      "total_likes": 0,
      "id": 6,
      "user_id": 1,
      "title": "title article 7",
      "body": "body article 7",
      "created_at": "2024-03-20T08:59:19+00:00",
      "updated_at": "2024-03-20T09:01:20+00:00"
    }
  ]
}
```
#### 2, Retrieve a Single Article (GET)
In this example, I retrieve data from article table with id is 4.
- Request:
```
GET http://localhost:34251/articles/4.json
```
- Response:
```
{
  "article": {
    "total_likes": 2,
    "id": 4,
    "user_id": 1,
    "title": "title article 7",
    "body": "body article 7",
    "created_at": "2024-03-20T06:29:18+00:00",
    "updated_at": "2024-03-20T09:01:04+00:00"
  }
}
```

#### 3, Create an Article (POST)
- Request:
```
POST http://localhost:34251/articles.json
Content-Type: application/json
Authorization: <access token>
{
  "title": "title article 6",
  "body" : "body article 6"
}
```
- Response:
```
{
  "message": "The article has been saved.",
  "article": {
    "title": "title article 6",
    "body": "body article 6",
    "user_id": 1,
    "created_at": "2024-03-20T08:59:19+00:00",
    "updated_at": "2024-03-20T08:59:19+00:00",
    "id": 6
  }
}
```
#### 4, Update an Article (PUT)
Update data for column title and body for an article with id is 6.

- Request:
```
PUT http://localhost:34251/articles/6.json
Content-Type: application/json
Authorization: <access token>
{
  "title": "title article 7",
  "body" : "body article 7"
}
```
- Response:
```
{
  "message": "The article has been saved.",
  "article": {
    "id": 6,
    "user_id": 1,
    "title": "title article 7",
    "body": "body article 7",
    "created_at": "2024-03-20T08:59:19+00:00",
    "updated_at": "2024-03-20T09:01:20+00:00"
  }
}
```
#### 5, Delete an Article (DELETE)
In this example, I delete an article with id is 6.
- Request:
```
http://localhost:34251/articles/6.json
Authorization: <access token>
```

- Response:
```
{
  "message": "The article has been deleted."
}
```



### Like Feature

Like endpoint: _/articles/{article_id}/likes.json_
In this example, I like an article with id is 2.
- Request:
```
POST http://localhost:34251/articles/2/likes.json
Authorization: <access token>
```

- Response:
```
{
  "message": "Like success!!!"
}
```

About [**All users can see like count on an article**], you can find them (total_likes) at [1, Retrieve All Articles (GET)](#1-retrieve-all-articles-get) or [2, Retrieve a Single Article (GET)](#2-retrieve-a-single-article-get).
