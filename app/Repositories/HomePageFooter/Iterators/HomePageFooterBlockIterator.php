<?php

namespace App\Repositories\HomePageFooter\Iterators;

class HomePageFooterBlockIterator
{
    protected string $description;
    protected string|null $privacyPolicyLink;
    protected string|null $termsAndCondition;

    public function __construct(object $data)
    {
        $this->description          = $data->description;
        $this->privacyPolicyLink    = $data->privacy_policy_link;
        $this->termsAndCondition    = $data->terms_and_condition;
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

    /**
     * @return string|null
     */
    public function getTermsAndCondition(): ?string
    {
        return $this->termsAndCondition;
    }
}
