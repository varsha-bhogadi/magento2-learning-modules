<?php
declare(strict_types=1);

namespace Vendor\FeatureToggle\Api;

interface MessageInterface
{
    /**
     * Get message
     *
     * @return string
     */
    public function getMessage(): string;
}
