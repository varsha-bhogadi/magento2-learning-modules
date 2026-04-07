<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Vendor\Routing\Block\Frontend;

use Magento\Framework\View\Element\Template;

class Custom extends Template
{
    public function getInternName()
    {
        return 'Varsha';
    }

    public function getCurrentUrl()
    {
        return $this->getUrl('*/*/*', ['_current' => true]);
    }
}
