# API written in PHP

![image](https://media.licdn.com/dms/image/C4D12AQHh6l0xkbhTPg/article-cover_image-shrink_720_1280/0/1622931040032?e=2147483647&v=beta&t=EHgKOBJdStMxkHMaFWOu8s_kBXQu4bXQuytJG3eB7Po)

## Project overview

- Type of challenge : **learning**
- Duration : **at your rhythm**
- Group : **Solo**

## Learning objective

- Create a RESTful API
- MVC pattern ***(without the V)***
- CRUD operations ***(Create, Read, Update, Delete)***
- MYSQL database ***(PDO)***
- Validation ***(filter_var)***

## The Mission

Your company has decided to create an API to share data with other companies. You have been asked to create this API in PHP.

### Features

The API will have the following endpoints:

| Method | Endpoint  | Description         |
| --- |-----------|---------------------|
| GET | /posts    | Get all posts       |
| GET | /post/:id | Get a post by id    |
| POST | /post     | Create a new post   |
| PUT | /post/:id | Update a post by id |
| DELETE | /post/:id | Delete a post by id |

The url of the API will be for example: `http://localhost:8000/api/v1/posts`

### Project structure

Create the following folders:

- `config`: This folder will contain the configuration files of the project.
- `controllers`: This folder will contain the controllers of the project.
- `models`: This folder will contain the models of the project.
- `routes`: This folder will contain the routes of the project.
- `utils`: This folder will contain the utility files of the project.
- `vendor`: This folder will contain the dependencies of the project.

### Database

Create a database called `api` and a table called `posts` with the following fields:

- id: int(11) auto_increment
- title: varchar(255)
- body: text
- author: varchar(255)
- created_at: datetime
- updated_at: datetime

### Dependencies (not mandatory)

- For the router, you can use this package [Klein](https://github.com/klein/klein.php)
- To protect your env, you can use this package [PHP dotenv](https://github.com/vlucas/phpdotenv)

### How the data must be returned

The data must be returned in JSON format.

``` json
{
    "status": 200,
    "message": "OK",
    "data": [
        {
            "id": 1,
            "title": "Lorem ipsum dolor sit amet",
            "body": "Lorem ipsum dolor sit amet,..."
            "author": "John Doe",
            "created_at": "2021-06-06 12:00:00",
            "updated_at": "2021-06-06 12:00:00"
        },
```


### Go further

- Http status code (200, 201, 400, 404, 500) 
- Implement a better Request & Response system (using symfony/http-foundation for example) [Requests & Responses](https://symfony.com/doc/current/components/http_foundation.html)
- Add a pagination system  (limit, offset)
- Add an authentication system (login, register, logout) like [JWT](https://jwt.io/)

### Resources

- Read [this](https://aws.amazon.com/fr/what-is/restful-api/) for better understanding
- If you want to test your API, use Postman [Here](https://www.postman.com/downloads/)