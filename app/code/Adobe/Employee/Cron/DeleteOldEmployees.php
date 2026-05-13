<?php
/**
 * Copyright © Adobe. All rights reserved.
 */

declare(strict_types=1);

namespace Adobe\Employee\Cron;

use Adobe\Employee\Api\EmployeeRepositoryInterface;
use Adobe\Employee\Model\ResourceModel\Employee\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;

/**
 * Delete old employee records cron job
 */
class DeleteOldEmployees
{
    /**
     * XML paths
     */
    private const XML_PATH_ENABLE = 'employee/cron/enable';

    private const XML_PATH_DELETE_DAYS = 'employee/cron/delete_days';

    /**
     * @param CollectionFactory $collectionFactory
     * @param EmployeeRepositoryInterface $employeeRepository
     * @param ScopeConfigInterface $scopeConfig
     * @param DateTime $dateTime
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly CollectionFactory $collectionFactory,
        private readonly EmployeeRepositoryInterface $employeeRepository,
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly DateTime $dateTime,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Delete old employees
     *
     * @return void
     */
    public function execute(): void
    {
        try {
            $isEnabled = (bool)$this->scopeConfig->getValue(
                self::XML_PATH_ENABLE,
                ScopeInterface::SCOPE_STORE
            );

            if (!$isEnabled) {
                return;
            }

            $deleteDays = (int)$this->scopeConfig->getValue(
                self::XML_PATH_DELETE_DAYS,
                ScopeInterface::SCOPE_STORE
            );

            $oldDate = $this->dateTime->gmtDate(
                'Y-m-d H:i:s',
                // strtotime("-{$deleteDays} days")
                strtotime("-{$deleteDays} minutes")
            );

            $employeeCollection = $this->collectionFactory->create();

            $employeeCollection->addFieldToFilter(
                'created_at',
                ['lt' => $oldDate]
            );

            foreach ($employeeCollection as $employee) {
                $this->employeeRepository->delete($employee);
            }

            $this->logger->info(
                __('Old employee records deleted successfully.')
            );

        } catch (\Exception $exception) {

            $this->logger->error(
                __(
                    'Error while deleting old employee records: %1',
                    $exception->getMessage()
                )
            );
        }
    }
}
