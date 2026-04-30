<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Api;

/**
 * Employee Repository Interface
 */
interface EmployeeRepositoryInterface
{
    /**
     * Save employee
     *
     * @param \Adobe\Employee\Api\Data\EmployeeInterface $employee
     * @return \Adobe\Employee\Api\Data\EmployeeInterface
     */
    public function save(
        \Adobe\Employee\Api\Data\EmployeeInterface $employee
    ): \Adobe\Employee\Api\Data\EmployeeInterface;

    /**
     * Update employee by ID
     *
     * @param int $entityId
     * @param \Adobe\Employee\Api\Data\EmployeeInterface $employee
     * @return \Adobe\Employee\Api\Data\EmployeeInterface
     */
    public function update(
        int $entityId,
        \Adobe\Employee\Api\Data\EmployeeInterface $employee
    ): \Adobe\Employee\Api\Data\EmployeeInterface;

    /**
     * Get employee by ID
     *
     * @param int $entityId
     * @return \Adobe\Employee\Api\Data\EmployeeInterface
     */
    public function getById(
        int $entityId
    ): \Adobe\Employee\Api\Data\EmployeeInterface;

    /**
     * Get list of employees
     *
     * @return \Adobe\Employee\Api\Data\EmployeeInterface[]
     */
    public function getList(): array;

    /**
     * Delete employee
     *
     * @param \Adobe\Employee\Api\Data\EmployeeInterface $employee
     * @return bool
     */
    public function delete(
        \Adobe\Employee\Api\Data\EmployeeInterface $employee
    ): bool;

    /**
     * Delete employee by ID
     *
     * @param int $entityId
     * @return bool
     */
    public function deleteById(int $entityId): bool;
}
