<?php

namespace Njhyuk\LaravelEncryptable;

use Illuminate\Support\Facades\Config;

trait Encryptable
{
    /**
     * Encrypted columns
     *
     * @var array
     */
    protected $encryptable = [];

    /**
     * Get a new query builder instance for the connection.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();

        return new EncryptQueryBuilder(
            $connection, $connection->getQueryGrammar(), $connection->getPostProcessor(), $this->getEncryptKey(), $this->encryptable
        );
    }

    /**
     * encrypt
     * @param $data
     * @return string
     */
    public function encrypt($data)
    {

        $enc = \openssl_encrypt(
            $data,
            $this->getEncryptCipher(),
            $this->getEncryptKey(),
            OPENSSL_RAW_DATA
        );
        return strtoupper(bin2hex($enc));
    }

    /**
     * hex to bin
     * @param $h
     * @return string|null
     */
    function hex2bin($h)
    {
        if (!is_string($h)) return null;
        $r = '';
        for ($a = 0; $a < strlen($h); $a += 2) {
            $r .= chr(hexdec($h{$a} . $h{($a + 1)}));
        }
        return $r;
    }

    /**
     * decrypt
     * @param $data
     * @return bool|string
     */
    public function decrypt($data)
    {
        $data = $this->hex2bin($data);
        $dec = \openssl_decrypt(
            $data,
            $this->getEncryptCipher(),
            $this->getEncryptKey(),
            OPENSSL_RAW_DATA
        );
        return $dec;
    }

    /**
     * get encrypt key
     * @return mixed
     */
    public function getEncryptKey()
    {
        return Config('encryptable.key');
    }

    /**
     * get encrypt cipher
     * @return mixed
     */
    public function getEncryptCipher()
    {
        return Config('encryptable.cipher');
    }

    /**
     * get encryptable
     * @return mixed
     */
    public function getEncryptable()
    {
        return $this->encryptable;
    }

    /**
     * decrypt attribute
     * @param $key
     * @return string
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (isset($this->encryptable) && in_array($key, $this->encryptable) && (!is_null($value))) {
            $value = $this->decrypt($value);
        }

        return $value;
    }

    /**
     * encrypt attribute
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if (isset($this->encryptable) && in_array($key, $this->encryptable)) {
            $value = $this->encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }
}