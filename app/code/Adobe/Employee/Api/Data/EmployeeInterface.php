<?php
declare(strict_types=1);
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Adobe\Employee\Api\Data;

interface EmployeeInterface
{
    const ENTITY_ID = 'entity_id';
    const NAME = 'name';
    const JOINING_DATE = 'joining_date';
    const DESIGNATION = 'designation';
    const ADDRESS = 'address';
    const STATUS = 'status';
    const CUSTOMER_ID = 'customer_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function getEntityId();
    public function setEntityId($entityId);
    public function getName();
    public function setName($name);
    public function getJoiningDate();
    public function setJoiningDate($joiningDate);
    public function getDesignation();
    public function setDesignation($designation);
    public function getAddress();
    public function setAddress($address);
    public function getStatus();
    public function setStatus($status);
    public function getCustomerId();
    public function setCustomerId($customerId);
}
