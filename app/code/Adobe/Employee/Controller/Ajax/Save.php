<?php
declare(strict_types=1);

namespace Adobe\Employee\Controller\Ajax;

use Adobe\Employee\Model\EmployeeFactory;
use Adobe\Employee\Model\ResourceModel\Employee;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Customer\Model\Session;

class Save implements HttpPostActionInterface
{
    private JsonFactory $resultJsonFactory;
    private RequestInterface $request;
    private EmployeeFactory $employeeFactory;
    private Employee $resource;
    private Session $customerSession;

    public function __construct(
        JsonFactory $resultJsonFactory,
        RequestInterface $request,
        EmployeeFactory $employeeFactory,
        Employee $resource,
        Session $customerSession
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->request = $request;
        $this->employeeFactory = $employeeFactory;
        $this->resource = $resource;
        $this->customerSession = $customerSession;
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();

        if (!$this->customerSession->isLoggedIn()) {
            return $result->setData([
                'success' => false,
                'message' => 'Login required.'
            ]);
        }

        try {
            $id = (int) $this->request->getParam('id');

            $employee = $this->employeeFactory->create();

            if ($id) {
                $this->resource->load($employee, $id);
            }

            if (!$this->request->getParam('name')) {
                return $result->setData([
                    'success' => false,
                    'message' => 'Name is required'
                ]);
            }

            $employee->setData('name', (string) $this->request->getParam('name'));
            $employee->setData('gender', (string) $this->request->getParam('gender'));
            $employee->setData('joining_date', (string) $this->request->getParam('joining_date'));
            $employee->setData('designation', (string) $this->request->getParam('designation'));
            $employee->setData('address', (string) $this->request->getParam('address'));
            $employee->setData('status', (int) $this->request->getParam('status'));
            $employee->setData('hobbies', (string) $this->request->getParam('hobbies'));

            $this->resource->save($employee);

            return $result->setData([
                'success' => true,
                'message' => 'Employee saved successfully'
            ]);

        } catch (\Exception $e) {
            return $result->setData([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}