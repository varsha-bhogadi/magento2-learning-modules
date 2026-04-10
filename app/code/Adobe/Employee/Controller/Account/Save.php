<?php
declare(strict_types=1);
/**
 * Copyright © AdobeEmployee. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Adobe\Employee\Controller\Account;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Adobe\Employee\Api\EmployeeRepositoryInterface;
use Adobe\Employee\Model\EmployeeFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\Result\RedirectFactory;

class Save implements HttpPostActionInterface
{
    private EmployeeRepositoryInterface $repository;
    private EmployeeFactory $employeeFactory;
    private RedirectFactory $resultRedirectFactory;
    private Context $context;

    public function __construct(
        Context $context,
        EmployeeRepositoryInterface $repository,
        EmployeeFactory $employeeFactory,
        RedirectFactory $resultRedirectFactory
    ) {
        $this->context = $context;
        $this->repository = $repository;
        $this->employeeFactory = $employeeFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    public function execute()
    {
    
        $data = $this->context->getRequest()->getPostValue();

        $redirect = $this->resultRedirectFactory->create();

        if (!$data) {
            return $redirect->setPath('*/*/index');
        }

        $employee = $this->employeeFactory->create();

        if (isset($data['entity_id'])) {
            $employee->setEntityId((int)$data['entity_id']);
        }

        $employee->setName($data['name'] ?? '');
        $employee->setDesignation($data['designation'] ?? '');
        $employee->setAddress($data['address'] ?? '');
        $employee->setStatus((int)($data['status'] ?? 1));
        $employee->setJoiningDate($data['joining_date'] ?? null);

        try {
            $this->repository->save($employee);
        } catch (LocalizedException $e) {
           
        }

        return $redirect->setPath('*/*/index');
    }
}
