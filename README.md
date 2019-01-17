# Laravel Encryptable

Laravel eloquent automatic encryption and decryption using mysql AES function.

## Installation

```
composer require njhyuk/laravel-encryptable
```

## Usage

### modify the Eloquent model to be applied.

Use the `Njhyuk\LaravelEncryptable\Encryptable` trait and add your encryptable table columns.

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
        'name'
    ];
}    
```
