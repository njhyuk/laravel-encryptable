# Laravel Encryptable

Laravel eloquent automatic encryption and decryption using mysql AES function.

## Installation

It will be distributed as pakigist.

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