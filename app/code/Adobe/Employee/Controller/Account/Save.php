<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Controller\Account;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface;
use Adobe\Employee\Api\EmployeeRepositoryInterface;
use Adobe\Employee\Model\EmployeeFactory;

class Save implements HttpPostActionInterface
{
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @var EmployeeRepositoryInterface
     */
    private EmployeeRepositoryInterface $employeeRepository;

    /**
     * @var EmployeeFactory
     */
    private EmployeeFactory $employeeFactory;

    /**
     * @var ManagerInterface
     */
    private ManagerInterface $messageManager;

    public function __construct(
        RequestInterface $request,
        RedirectFactory $redirectFactory,
        EmployeeRepositoryInterface $employeeRepository,
        EmployeeFactory $employeeFactory,
        ManagerInterface $messageManager
    ) {
        $this->request = $request;
        $this->redirectFactory = $redirectFactory;
        $this->employeeRepository = $employeeRepository;
        $this->employeeFactory = $employeeFactory;
        $this->messageManager = $messageManager;
    }

    /**
     * Save Employee (Create / Update)
     */
    public function execute()
    {
        $resultRedirect = $this->redirectFactory->create();

        try {
            $data = $this->request->getPostValue();

            if (!$data) {
                $this->messageManager->addErrorMessage(__('Invalid request.'));
                return $resultRedirect->setPath('employee/account/index');
            }

            $id = isset($data['entity_id']) ? (int)$data['entity_id'] : 0;

            $employee = $id
                ? $this->employeeRepository->getById($id)
                : $this->employeeFactory->create();

            // Basic fields
            $employee->setName(trim($data['name'] ?? ''));
            $employee->setGender($data['gender'] ?? '');
            $employee->setDesignation(trim($data['designation'] ?? ''));
            $employee->setJoiningDate($data['joining_date'] ?? '');
            $employee->setAddress(trim($data['address'] ?? ''));
            $employee->setStatus((int)($data['status'] ?? 1));

            /**
             * Hobbies (checkbox array → string)
             */
            $hobbies = $data['hobbies'] ?? [];

            if (is_array($hobbies)) {
                $hobbies = implode(',', $hobbies);
            }

            $employee->setHobbies($hobbies);

            // Save
            $this->employeeRepository->save($employee);

            $this->messageManager->addSuccessMessage(
                __('Employee saved successfully.')
            );

            return $resultRedirect->setPath('employee/account/index');

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __('Something went wrong while saving employee.')
            );

            return $resultRedirect->setPath('employee/account/create');
        }
    }
}
