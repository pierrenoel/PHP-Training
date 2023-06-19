# How to use the API

## Factory console

```bash
php factory/Console

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display help for the given command. When no command is given display help for the list command
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  completion       Dump the shell completion script
  help             Display help for a command
  list             List commands
 make
  make:controller  Generate a new controller
  make:model       Generate a new model
```

## New Controller

- To initiate a new controller use ```php factory/Console make:controller```

```php
<?php

namespace app\controllers;

use app\repositories\PostRepository;

class PostController extends Controller
{
    protected PostRepository $postRepository;

    public function __construct()
    {
        parent::__construct();
        $this->postRepository = new PostRepository();
    }

```

### findall() method 

```php 
public function index(): void
{
    $this->response->execute($this->postRepository->findAll(),[
        'success_title' => 'posts',
    ]);
}
```

If you want to query something from your database, please use the correct repository and
call a method you want.

In the second param, it accepts only an array.

```json
{
    "response_code": 200,
    "posts": [
        {
            "id": 70,
            "title": "How to make an api in php",
            "excerpt": "Lorem ipsum dolor sit amet, consectetur adipiscing elit ...",
            "body": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod ...",
            "category_id": 1
        }
```

### find($id) method 

```php 
$this->response->execute($this->postRepository->find($id),[
    'success_title' => 'post',
    'error_message' => 'The post is not found',
    'error_code' => 404
]);
```

You can add here a ```error_message``` and a ```error_code``` in case if the post is not found 

```json 
{
    "response_code": 404,
    "message": "The post is not found"
}
```

## Relationship 

### HasOne

hasOne() method take two params - the foreign id and the foreign table

```php 
public function index(): void
{
    $this->response->execute($this->postRepository->hasOne('category_id','categories'),[
        'success_title' => 'posts',
    ]);
}
```

```json
{
    "response_code": 200,
    "posts": [
        {
            "id": 70,
            "title": "How to make an api in php",
            "excerpt": "Lorem ipsum dolor sit amet, consectetur adipiscing elit ...",
            "body": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod ...",
            "category_id": 1,
            "category": [
                {
                  "id": 1,
                  "name": "php",
                  "description": "Je suis une belle catégorie qui comporte tous les articles en php"
                }
          ]
        },
```

You can also pass an id ```hasOne('category_id,'categories,$id)``` if you want to show a specific post.