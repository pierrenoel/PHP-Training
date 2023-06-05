# Roles & Permissions

Your CTO asks you to develop a roles / permissions system for the project. 

## Requirements
- PHP
- POO
- Namespacing

## Topic seen during this project 
- Classes (attributes & methods)
- Abstract class
- Interface 
- Polymorphism


## Instructions
At the end of the exercise, you have to get this: 

```php
// Create a new role
$adminRole = new Admin();

// Create a new permission
$permissionOne = new Permission('one');

// Assign permission to a role
$adminRole->setPermissions([$permissionOne]);

// Create a new user
$user = new User('Pierre','pierrenoel@hotmail.be','password',$adminRole);

// Display the permissions from a user 
foreach($user->getRole()->getPermissions() as $permission)
{
    echo $permission->getName();
}
```

## Where to start?

- **Create a role interface, including two methods**

```php
public function getName() : string;
public function getPermissions() : array;
```

- **Create a role abstract class** 

```php 
protected string $name;
protected array $permissions = [];
```

*And don't forget to add a setter for the permissions*

- **Create an Admin or a User role class**

```php
class Admin extends Role
{
    protected string $name = "Admin";
}
```

## What next?
It is a very easy one but if you want to go further, please ... But what I suggest is to 
add a role by default to the user (e.g. add a default Member role when a new object is
instantiate from its class ). And for the second thing you can add, is to create an 
interface (including an auth system) and moreover, an email system when a new user
is registered (User-Registration)