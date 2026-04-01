<?php
declare(strict_types=1);

namespace Vendor\FeatureToggle\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Feature Toggle helper
 */
class Data extends AbstractHelper
{
    /**
     * Config path for enable flag
     */
    public const XML_PATH_ENABLED = 'featuretoggle/general/enable';

    /**
     * Check if module is enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isEnabled($storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
