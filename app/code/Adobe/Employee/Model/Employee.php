<?php
declare(strict_types=1);
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Adobe\Employee\Model;

use Magento\Framework\Model\AbstractModel;
use Adobe\Employee\Api\Data\EmployeeInterface;
use Adobe\Employee\Model\ResourceModel\Employee as EmployeeResource;

class Employee extends AbstractModel implements EmployeeInterface
{
    protected function _construct()
    {
        $this->_init(EmployeeResource::class);
    }

    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }
    public function getName()
    {
        return $this->getData(self::NAME);
    }
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }
    public function getJoiningDate()
    {
        return $this->getData(self::JOINING_DATE);
    }
    public function setJoiningDate($joiningDate)
    {
        return $this->setData(self::JOINING_DATE, $joiningDate);
    }
    public function getDesignation()
    {
        return $this->getData(self::DESIGNATION);
    }
    public function setDesignation($designation)
    {
        return $this->setData(self::DESIGNATION, $designation);
    }
    public function getAddress()
    {
        return $this->getData(self::ADDRESS);
    }
    public function setAddress($address)
    {
        return $this->setData(self::ADDRESS, $address);
    }
    public function getStatus()
    {
        return (int)$this->getData(self::STATUS);
    }
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }
}
