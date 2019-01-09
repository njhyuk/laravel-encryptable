<?php

namespace Njhyuk\LaravelEncryptable;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Database\Query\Processors\Processor;

class EncryptQueryBuilder extends Builder
{
    /**
     * Cryptographic key
     * @var string encryptKey
     */
    private $encryptKey;

    /**
     * Encrypted columns
     * @var array
     */
    protected $encryptable = [];

    /**
     * EncryptQueryBuilder constructor.
     * @param ConnectionInterface $connection
     * @param Grammar|null $grammar
     * @param Processor|null $processor
     * @param $encryptKey
     * @param array $encryptable
     */
    function __construct(ConnectionInterface $connection, Grammar $grammar = null, Processor $processor = null, $encryptKey, array $encryptable)
    {
        $this->encryptable = $encryptable;
        $this->encryptKey = $encryptKey;
        parent::__construct($connection, $grammar, $processor);
    }

    /**
     * make where
     * @param array|\Closure|string $column
     * @param null $operator
     * @param null $value
     * @param string $boolean
     * @return Builder|void
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        $column = $this->decryptColumn($column);
        parent::where($column, $operator, $value, $boolean);

    }

    /**
     * make decrypt Column query
     * @param $column
     * @return mixed
     */
    protected function decryptColumn($column)
    {
        if (isset($this->encryptable) && is_array($this->encryptable)) {
            if (in_array($column, $this->encryptable)) {
                $column = \DB::raw('AES_DECRYPT(UNHEX('.$column.'), "'.$this->encryptKey.'")');
            }
        }
        return $column;
    }
}