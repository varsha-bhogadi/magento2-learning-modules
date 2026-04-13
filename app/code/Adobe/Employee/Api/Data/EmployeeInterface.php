<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Api\Data;

interface EmployeeInterface
{
    public const ENTITY_ID = 'entity_id';
    public const NAME = 'name';
    public const GENDER = 'gender';
    public const DESIGNATION = 'designation';
    public const JOINING_DATE = 'joining_date';
    public const ADDRESS = 'address';
    public const STATUS = 'status';
    public const HOBBIES = 'hobbies';

    /**
     * Get ID
     */
    public function getId();

    /**
     * Set ID
     */
    public function setId($id);

    /**
     * Get Name
     */
    public function getName();

    /**
     * Set Name
     */
    public function setName($name);

    /**
     * Get Gender
     */
    public function getGender();

    /**
     * Set Gender
     */
    public function setGender($gender);

    /**
     * Get Designation
     */
    public function getDesignation();

    /**
     * Set Designation
     */
    public function setDesignation($designation);

    /**
     * Get Joining Date
     */
    public function getJoiningDate();

    /**
     * Set Joining Date
     */
    public function setJoiningDate($date);

    /**
     * Get Address
     */
    public function getAddress();

    /**
     * Set Address
     */
    public function setAddress($address);

    /**
     * Get Status
     */
    public function getStatus();

    /**
     * Set Status
     */
    public function setStatus($status);

    /**
     * Get Hobbies
     */
    public function getHobbies();

    /**
     * Set Hobbies
     */
    public function setHobbies($hobbies);
}
