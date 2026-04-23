<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Api\Data;

/**
 * Employee Interface
 */
interface EmployeeInterface
{
    /**
     * Constants for field names
     */
    public const ENTITY_ID    = 'entity_id';
    public const NAME         = 'name';
    public const GENDER       = 'gender';
    public const DESIGNATION  = 'designation';
    public const JOINING_DATE = 'joining_date';
    public const ADDRESS      = 'address';
    public const STATUS       = 'status';
    public const HOBBIES      = 'hobbies';
    public const CREATED_AT   = 'created_at';
    public const UPDATED_AT   = 'updated_at';

    /**
     * Get entity ID
     *
     * @return int|null
     */
    public function getId(): mixed;

    /**
     * Set entity ID
     *
     * @param int $entityId
     * @return $this
     */
    public function setId(mixed $entityId): static;

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static;

    /**
     * Get gender
     *
     * @return string|null
     */
    public function getGender(): ?string;

    /**
     * Set gender
     *
     * @param string $gender
     * @return $this
     */
    public function setGender(string $gender): static;

    /**
     * Get designation
     *
     * @return string|null
     */
    public function getDesignation(): ?string;

    /**
     * Set designation
     *
     * @param string $designation
     * @return $this
     */
    public function setDesignation(string $designation): static;

    /**
     * Get joining date
     *
     * @return string|null
     */
    public function getJoiningDate(): ?string;

    /**
     * Set joining date
     *
     * @param string $joiningDate
     * @return $this
     */
    public function setJoiningDate(string $joiningDate): static;

    /**
     * Get address
     *
     * @return string|null
     */
    public function getAddress(): ?string;

    /**
     * Set address
     *
     * @param string $address
     * @return $this
     */
    public function setAddress(string $address): static;

    /**
     * Get status
     *
     * @return int|null
     */
    public function getStatus(): ?int;

    /**
     * Set status
     *
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status): static;

    /**
     * Get hobbies
     *
     * @return string|null
     */
    public function getHobbies(): ?string;

    /**
     * Set hobbies
     *
     * @param string $hobbies
     * @return $this
     */
    public function setHobbies(string $hobbies): static;

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;
}