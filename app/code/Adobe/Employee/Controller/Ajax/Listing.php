<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Controller\Ajax;

use Adobe\Employee\Model\ResourceModel\Employee\CollectionFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class Listing
 *
 * Ajax controller to return employee listing with pagination
 */
class Listing implements HttpGetActionInterface
{
    /**
     * @var JsonFactory
     */
    private JsonFactory $resultJsonFactory;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * Constructor
     *
     * @param JsonFactory $resultJsonFactory
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface $request
     */
    public function __construct(
        JsonFactory $resultJsonFactory,
        CollectionFactory $collectionFactory,
        RequestInterface $request
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->collectionFactory = $collectionFactory;
        $this->request = $request;
    }

    /**
     * Execute action
     *
     * @return Json
     */
    public function execute(): Json
    {
        $result = $this->resultJsonFactory->create();

        try {
            /** Get current page (default = 1) */
            $currentPage = (int) $this->request->getParam('page', 1);

            /** Set page size (records per page) */
            $pageSize = 5;

            /** Create collection */
            $collection = $this->collectionFactory->create();

            /** Get total records count */
            $totalRecords = (int) $collection->getSize();

            /** Apply sorting (latest first) */
            $collection->setOrder('entity_id', 'DESC');

            /** Apply pagination */
            $collection->setCurPage($currentPage);
            $collection->setPageSize($pageSize);

            /** Prepare data */
            $items = [];
            foreach ($collection as $employee) {
                $items[] = $employee->getData();
            }

            /** Calculate last page */
            $lastPage = (int) ceil($totalRecords / $pageSize);

            return $result->setData([
                'success'       => true,
                'items'         => $items,
                'current_page'  => $currentPage,
                'last_page'     => $lastPage
            ]);

        } catch (\Exception $exception) {
            return $result->setData([
                'success' => false,
                'items'   => [],
                'message' => __('Something went wrong while fetching employees.')
            ]);
        }
    }
}