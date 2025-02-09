<?php

class Database
{
    public function __construct(
        private string $host,
        private string $name,
        private string $user,
        private string $password,
        private string $charset,
    )
    {}

    /**
     * @return PDO
     */
    public function getPdoConnection(): PDO
    {
        $dsn="mysql:host={$this->host};dbname={$this->name};charset={$this->charset}";

        return new PDO($dsn, $this->user, $this->password,
        [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES  => false,
        ]);
    }
}
