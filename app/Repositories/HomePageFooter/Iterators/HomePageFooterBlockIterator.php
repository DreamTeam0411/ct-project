<?php

namespace App\Repositories\HomePageFooter\Iterators;

class HomePageFooterBlockIterator
{
    protected string $description;
    protected string|null $privacyPolicyLink;

    public function __construct(object $data)
    {
        $this->description          = $data->description;
        $this->privacyPolicyLink    = $data->privacy_policy_link;
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
