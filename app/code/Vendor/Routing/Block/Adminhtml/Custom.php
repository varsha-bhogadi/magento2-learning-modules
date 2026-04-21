<?php
<!-- /**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */ -->
 declare(strict_types=1);
namespace Vendor\Routing\Block\Adminhtml;

use Magento\Backend\Block\Template;

class Custom extends Template
{
    public function getAdminMessage()
    {
        return __('Admin Routing Dashboard');
    }

    public function getRouteInfo()
    {
        return [
            'route_id' => 'customadmin',
            'controller' => 'Index',
            'action' => 'Index',
            'url' => $this->getUrl('customadmin/index/index')
        ];
    }
}
