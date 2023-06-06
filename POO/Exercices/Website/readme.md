# Website - define what the client wants!

## Your objective

The objective of the day is to use the **Decorator** design pattern. Your role is to add 

```php

interface WebsiteInterface
{
    /**
     * @return int
     */
    public function getPrice() : int;

    /**
     * @return string
     */
    public function getDescription() : string;
}

class BasicWebsite implements WebsiteInterface
{
    /**
     * @return int
     */
    public function getPrice(): int
    {
        return '1000';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'This is a basic website';
    }
}
```