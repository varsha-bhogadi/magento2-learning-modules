<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Model;

use Adobe\Employee\Api\Data\EmployeeInterface;
use Adobe\Employee\Model\ResourceModel\Employee as EmployeeResource;
use Magento\Framework\Model\AbstractModel;

/**
 * Employee Model
 */
class Employee extends AbstractModel implements EmployeeInterface
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(EmployeeResource::class);
    }

    /**
     * Get entity ID
     *
     * @return int|null
     */
    public function getId(): mixed
    {
        return $this->getData(self::ENTITY_ID)
            ? (int) $this->getData(self::ENTITY_ID)
            : null;
    }

    /**
     * Set entity ID
     *
     * @param mixed $entityId
     * @return $this
     */
    public function setId(mixed $entityId): static
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get gender
     *
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->getData(self::GENDER);
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return $this
     */
    public function setGender(string $gender): static
    {
        return $this->setData(self::GENDER, $gender);
    }

    /**
     * Get designation
     *
     * @return string|null
     */
    public function getDesignation(): ?string
    {
        return $this->getData(self::DESIGNATION);
    }

    /**
     * Set designation
     *
     * @param string $designation
     * @return $this
     */
    public function setDesignation(string $designation): static
    {
        return $this->setData(self::DESIGNATION, $designation);
    }

    /**
     * Get joining date
     *
     * @return string|null
     */
    public function getJoiningDate(): ?string
    {
        return $this->getData(self::JOINING_DATE);
    }

    /**
     * Set joining date
     *
     * @param string $joiningDate
     * @return $this
     */
    public function setJoiningDate(string $joiningDate): static
    {
        return $this->setData(self::JOINING_DATE, $joiningDate);
    }

    /**
     * Get address
     *
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     * Set address
     *
     * @param string $address
     * @return $this
     */
    public function setAddress(string $address): static
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * Get status
     *
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->getData(self::STATUS) !== null
            ? (int) $this->getData(self::STATUS)
            : null;
    }

    /**
     * Set status
     *
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status): static
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get hobbies
     *
     * @return string|null
     */
    public function getHobbies(): ?string
    {
        return $this->getData(self::HOBBIES) ?? '';
    }

    /**
     * Set hobbies
     *
     * @param string $hobbies
     * @return $this
     */
    public function setHobbies(string $hobbies): static
    {
        return $this->setData(self::HOBBIES, $hobbies);
    }

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }
}