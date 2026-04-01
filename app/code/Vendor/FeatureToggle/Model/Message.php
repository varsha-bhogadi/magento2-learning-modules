<?php
declare(strict_types=1);

namespace Vendor\FeatureToggle\Model;

use Vendor\FeatureToggle\Api\MessageInterface;
use Vendor\FeatureToggle\Helper\Data as ConfigHelper;

/**
 * Preference implementation
 */
class Message implements MessageInterface
{
    /**
     * Config helper
     *
     * @var ConfigHelper
     */
    private $configHelper;

    /**
     * Constructor
     *
     * @param ConfigHelper $configHelper
     */
    public function __construct(ConfigHelper $configHelper)
    {
        $this->configHelper = $configHelper;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage(): string
    {
        if (!$this->configHelper->isEnabled()) {
            return 'Module disabled';
        }
        return 'Module enabled – Preference active';
    }
}
