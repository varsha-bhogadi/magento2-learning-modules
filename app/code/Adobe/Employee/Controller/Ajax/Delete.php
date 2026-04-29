<?php
declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Adobe\Employee\Controller\Ajax;

use Adobe\Employee\Model\EmployeeFactory;
use Adobe\Employee\Model\ResourceModel\Employee;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;

class Delete implements HttpPostActionInterface
{
    private JsonFactory $resultJsonFactory;
    private RequestInterface $request;
    private EmployeeFactory $employeeFactory;
    private Employee $resource;

    public function __construct(
        JsonFactory $resultJsonFactory,
        RequestInterface $request,
        EmployeeFactory $employeeFactory,
        Employee $resource
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->request = $request;
        $this->employeeFactory = $employeeFactory;
        $this->resource = $resource;
    }

    /**
     * Execute
     *
     * @return Json
     */
    public function execute(): Json
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get(
            \Magento\Customer\Model\Session::class
        );

        if (!$customerSession->isLoggedIn()) {
            return $result->setData([
                'success' => false,
                'message' => 'Login required.'
            ]);
        }
        $result = $this->resultJsonFactory->create();

        $id = (int) $this->request->getParam('id');

        $employee = $this->employeeFactory->create();
        $this->resource->load($employee, $id);

        if ($employee->getId()) {
            $this->resource->delete($employee);
        }

        return $result->setData([
            'success' => true
        ]);
    }
}