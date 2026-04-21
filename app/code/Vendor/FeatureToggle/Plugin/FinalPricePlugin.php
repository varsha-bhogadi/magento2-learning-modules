<?php
declare(strict_types=1);

namespace Vendor\FeatureToggle\Plugin;

use Vendor\FeatureToggle\Helper\Data as ConfigHelper;
use Magento\Catalog\Pricing\Price\FinalPrice;

/**
 * Plugin to apply discount when module enabled
 */
class FinalPricePlugin
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
     * Apply 10% discount
     *
     * @param FinalPrice $subject
     * @param float $result
     * @return float
     */
    public function afterGetValue(FinalPrice $subject, $result)
    {
        if (!$this->configHelper->isEnabled()) {
            return $result;
        }
        return $result * 0.9;
    }
}
