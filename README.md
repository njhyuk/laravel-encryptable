# Laravel Encryptable

Automatically encrypt Laravel Eloquent Model columns using Mysql AES functions.

It is possible to database search because it uses Mysql AES functions.

## Notice

Mysql AES functions do not use initialization vectors.

If you give up searching in Mysql, it is better to use a different solution.

## Installation

### Installing the package

```
composer require njhyuk/laravel-encryptable
```

### Configuring the package

```
 php artisan vendor:publish --provider="Njhyuk\LaravelEncryptable\EncryptableProvider"
```

### Add encryption key in env file

```
ENCRYPTABLE_KEY=SetYour16ByteKey
```

## Usage

### Specify the model's encryption columns

Use the `Njhyuk\LaravelEncryptable\Encryptable` trait and add columns to be encrypted.

```php
<?php

namespace App\Models;

use Njhyuk\LaravelEncryptable\Encryptable;

class User extends Authenticatable
{
    use Notifiable;
    use Encryptable;

    /**
     * Encrypted columns
     * 
     * @var array
     */
    protected $encryptable = [
        'name',
        'email'
    ];
}    
```

## Inserting & Updating Models

```php
$user = new User;
$user->email = 'example@example.com'; //It is encrypted and stored.
$user->save();
```

## Retrieving Models

```php
User::where('email','like','%example%')->get(); //Encrypted data retrieval is possible.
```
