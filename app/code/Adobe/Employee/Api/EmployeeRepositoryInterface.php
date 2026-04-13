<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Api;

use Adobe\Employee\Api\Data\EmployeeInterface;

interface EmployeeRepositoryInterface
{
    /**
     * Save employee
     */
    public function save(EmployeeInterface $employee): EmployeeInterface;

    /**
     * Get employee by ID
     */
    public function getById(int $id): EmployeeInterface;

    /**
     * Delete employee
     */
    public function delete(EmployeeInterface $employee): bool;
}