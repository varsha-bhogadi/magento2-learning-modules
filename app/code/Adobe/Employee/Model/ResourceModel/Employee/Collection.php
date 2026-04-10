<?php
declare(strict_types=1);
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Adobe\Employee\Model\ResourceModel\Employee;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Adobe\Employee\Model\Employee;
use Adobe\Employee\Model\ResourceModel\Employee as EmployeeResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Employee::class, EmployeeResource::class);
    }
}
