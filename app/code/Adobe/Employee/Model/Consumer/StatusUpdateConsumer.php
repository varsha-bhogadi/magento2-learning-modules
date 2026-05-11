<?php
/**
 * Copyright © Adobe. All rights reserved.
 */

declare(strict_types=1);

namespace Adobe\Employee\Model\Consumer;

use Adobe\Employee\Model\EmployeeFactory;
use Psr\Log\LoggerInterface;

class StatusUpdateConsumer
{
    /**
     * @param EmployeeFactory $employeeFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly EmployeeFactory $employeeFactory,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Process queue message
     *
     * @param string $message
     * @return void
     */
    public function process($message): void
    {
        $this->logger->info(
    __('Employee status updated successfully.')
);
        $this->logger->info(
            print_r($message, true)
        );
        try {
            $data = json_decode($message, true);

            if (!is_array($data)) {
                return;
            }

            $employeeId = (int)($data['employee_id'] ?? 0);
            $status = (int)($data['status'] ?? 0);

            $employee = $this->employeeFactory->create()->load($employeeId);

            if (!$employee->getId()) {
                return;
            }

            $employee->setStatus($status);
            $employee->save();

            $this->logger->info(
                __('Employee status updated successfully.')
            );
        } catch (\Exception $exception) {
            $this->logger->error(
                __('Error while updating employee status: %1', $exception->getMessage())
            );
        }
    }
}