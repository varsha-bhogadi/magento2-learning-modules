<?php
/**
 * Copyright © Adobe. All rights reserved.
 */

declare(strict_types=1);

namespace Adobe\Employee\Cron;

use Adobe\Employee\Model\ResourceModel\Employee\CollectionFactory;
use Psr\Log\LoggerInterface;

class DeleteOldEmployees
{
    /**
     * @param CollectionFactory $collectionFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly CollectionFactory $collectionFactory,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Delete employees older than 3 days
     *
     * @return void
     */
    public function execute(): void
    {
        try {
            // $oldDate = date('Y-m-d H:i:s', strtotime('-3 days'));
            $oldDate = date('Y-m-d H:i:s', strtotime('-1 minute'));

            $employeeCollection = $this->collectionFactory->create();

            $employeeCollection->addFieldToFilter(
                'created_at',
                ['lt' => $oldDate]
            );

            foreach ($employeeCollection as $employee) {
                $employee->delete();
            }

            $this->logger->info(
                __('Old employee records deleted successfully.')
            );
        } catch (\Exception $exception) {
            $this->logger->error(
                __('Error while deleting old employee records: %1', $exception->getMessage())
            );
        }
    }
}