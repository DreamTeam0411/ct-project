<?php

namespace App\Repositories\HomePageFooter;

class HomePageFooterBlockUpdateDTO
{
    public function __construct(
        protected string $description,
        protected string $privacyPolicyLink = '',
        protected string $termsAndCondition = '',
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
     * @return string
     */
    public function getPrivacyPolicyLink(): string
    {
        return $this->privacyPolicyLink;
    }

    /**
     * @return string
     */
    public function getTermsAndCondition(): string
    {
        return $this->termsAndCondition;
    }
}
