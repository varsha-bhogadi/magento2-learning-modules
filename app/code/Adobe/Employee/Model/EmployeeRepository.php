<?php
declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Adobe\Employee\Model;

use Adobe\Employee\Api\EmployeeRepositoryInterface;
use Adobe\Employee\Api\Data\EmployeeInterface;
use Adobe\Employee\Model\ResourceModel\Employee as ResourceEmployee;
use Adobe\Employee\Model\EmployeeFactory;
use Adobe\Employee\Model\ResourceModel\Employee\CollectionFactory as EmployeeCollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    private ResourceEmployee $resource;
    private EmployeeFactory $employeeFactory;
    private EmployeeCollectionFactory $collectionFactory;

    public function __construct(
        ResourceEmployee $resource,
        EmployeeFactory $employeeFactory,
        EmployeeCollectionFactory $collectionFactory
    ) {
        $this->resource = $resource;
        $this->employeeFactory = $employeeFactory;
        $this->collectionFactory = $collectionFactory;
    }

    public function save(EmployeeInterface $employee): EmployeeInterface
    {
        try {
            $this->resource->save($employee);
        } catch (\Exception $e) {
            throw new LocalizedException(__('Could not save employee'));
        }
        return $employee;
    }

    public function getById(int $entityId): EmployeeInterface
    {
        $employee = $this->employeeFactory->create();
        $this->resource->load($employee, $entityId);

        if (!$employee->getId()) {
            throw new NoSuchEntityException(__('Employee not found'));
        }

        return $employee;
    }

    public function delete(EmployeeInterface $employee): bool
    {
        try {
            $this->resource->delete($employee);
        } catch (\Exception $e) {
            throw new LocalizedException(__('Could not delete employee'));
        }
        return true;
    }

    public function deleteById(int $entityId): bool
    {
        $employee = $this->getById($entityId);
        return $this->delete($employee);
    }
    
    public function getList(): array
    {
        $collection = $this->collectionFactory->create();
        return $collection->getItems();
    }
}
