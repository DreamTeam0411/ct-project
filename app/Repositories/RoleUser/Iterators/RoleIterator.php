<?php

namespace App\Repositories\RoleUser\Iterators;

class RoleIterator
{
    protected int $id;
    protected string $name;

    /**
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->id   = $data->role_id;
        $this->name = $data->role_name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
