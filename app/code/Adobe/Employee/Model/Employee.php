<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Model;

use Magento\Framework\Model\AbstractModel;
use Adobe\Employee\Api\Data\EmployeeInterface;

class Employee extends AbstractModel implements EmployeeInterface
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init(\Adobe\Employee\Model\ResourceModel\Employee::class);
    }

    /**
     * Get ID
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Set ID
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * Get Name
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set Name
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get Gender
     */
    public function getGender()
    {
        return $this->getData(self::GENDER);
    }

    /**
     * Set Gender
     */
    public function setGender($gender)
    {
        return $this->setData(self::GENDER, $gender);
    }

    /**
     * Get Designation
     */
    public function getDesignation()
    {
        return $this->getData(self::DESIGNATION);
    }

    /**
     * Set Designation
     */
    public function setDesignation($designation)
    {
        return $this->setData(self::DESIGNATION, $designation);
    }

    /**
     * Get Joining Date
     */
    public function getJoiningDate()
    {
        return $this->getData(self::JOINING_DATE);
    }

    /**
     * Set Joining Date
     */
    public function setJoiningDate($date)
    {
        return $this->setData(self::JOINING_DATE, $date);
    }

    /**
     * Get Address
     */
    public function getAddress()
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     * Set Address
     */
    public function setAddress($address)
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * Get Status
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Set Status
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get Hobbies
     */
    public function getHobbies()
    {
        return $this->getData(self::HOBBIES);
    }

    /**
     * Set Hobbies
     */
    public function setHobbies($hobbies)
    {
        return $this->setData(self::HOBBIES, $hobbies);
    }
}