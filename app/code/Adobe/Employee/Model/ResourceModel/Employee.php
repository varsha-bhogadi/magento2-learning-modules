<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Employee extends AbstractDb
{
    /**
     * Initialize table and primary key
     */
    protected function _construct()
    {
        $this->_init('adobe_employee', 'entity_id');
    }
}