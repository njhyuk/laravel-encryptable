# Laravel Encryptable

**This package is still in development and is not available.**

Laravel eloquent automatic encryption and decryption using mysql AES function.

## Installation

```
composer require njhyuk/laravel-encryptable
```

## usage

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
     * @var array
     */
    protected $encryptable = [
        'name'
    ];
}    
```