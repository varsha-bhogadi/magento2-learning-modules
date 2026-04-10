<?php
declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Adobe\Employee\Api;

use Adobe\Employee\Api\Data\EmployeeInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface EmployeeRepositoryInterface
{
    /**
     * Save Employee
     *
     * @param EmployeeInterface $employee
     * @return EmployeeInterface
     * @throws LocalizedException
     */
    public function save(EmployeeInterface $employee): EmployeeInterface;

    /**
     * Get Employee by ID
     *
     * @param int $entityId
     * @return EmployeeInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $entityId): EmployeeInterface;

    /**
     * Delete Employee
     *
     * @param EmployeeInterface $employee
     * @return bool
     * @throws LocalizedException
     */
    public function delete(EmployeeInterface $employee): bool;

    /**
     * Delete Employee by ID
     *
     * @param int $entityId
     * @return bool
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $entityId): bool;
}
