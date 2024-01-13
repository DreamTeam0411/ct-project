<?php

namespace App\Repositories\HomePageFooter;

class HomePageFooterBlockUpdateDTO
{
    public function __construct(
        protected string $description,
        protected string|null $privacyPolicyLink = null,
    ){
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getPrivacyPolicyLink(): ?string
    {
        return $this->privacyPolicyLink;
    }
}
