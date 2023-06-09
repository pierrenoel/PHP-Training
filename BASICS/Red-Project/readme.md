# PHP - Basic Training

In this briefing, we are learning how to write a website using PHP, a server language. 

The project we are going to do is a simple **blog**. 

## Why a blog?

Maybe thanks to this project, we are going to introduce the PHP and go further when we will see OOP (Oriented object programming).


When you type an url on a website, for example : '/posts' something is doing on the background.  

1. You type ```/posts``` a **get request** makes to the server
2. The server looks after a **resource**, it could be a page, or json
3. The server returns a **response**

You remark that are some bold words like **GET**, **REQUEST**, **RESPONSE**. Some are missing, but for the moment, let see them.

## The Request/Response Procedure

At its most basic level, the request/response process consists of a web browser asking the web server to send it a web page and the server sending back the page. The browser then takes care of displaying the page.

![](https://www.oreilly.com/api/v2/epubs/9781449337452/files/httpatomoreillycomsourceoreillyimages1614577.png)

## The red project

The first thing to do is create the structure of the project

```
|── index.php
|── views
    |── templates
        |── header.php
        |── footer.php
|── assets
    |── css
    |── scss
    |── img
    
```

## Steps for the project

- Initiate the structure of the project (a very easy task, see below)
- Constructing the router (not a hard one)
- Initiate the view
- Evolution of the structure project with controllers