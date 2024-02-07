<?php

namespace App\Repositories\UserRepository;

class UserSearchDTO
{
    /**
     * @param string|null $searchInput
     */
    public function __construct(
        protected string|null $searchInput = null,
    ) {
    }

    /**
     * @return string|null
     */
    public function getSearchInput(): ?string
    {
        return $this->searchInput;
    }
}
