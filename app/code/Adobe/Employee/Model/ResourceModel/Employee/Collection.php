<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Model\ResourceModel\Employee;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Adobe\Employee\Model\Employee as Model;
use Adobe\Employee\Model\ResourceModel\Employee as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * Initialize collection
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }

    /**
     * After collection load
     * (optional place for future filters)
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        // Default ordering (recommended for My Account UI)
        $this->setOrder('entity_id', 'DESC');

        return $this;
    }
}