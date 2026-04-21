<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Ui\DataProvider\Employee;

use Adobe\Employee\Model\ResourceModel\Employee\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Employee Form DataProvider
 */
class FormDataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    private array $loadedData = [];

    /**
     * @var DataPersistorInterface
     */
    private DataPersistorInterface $dataPersistor;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $employee) {
            $data = $employee->getData();

            // Convert hobbies string to array for checkboxset
            if (!empty($data['hobbies'])) {
                $data['hobbies'] = explode(',', $data['hobbies']);
            } else {
                $data['hobbies'] = [];
            }

            $this->loadedData[$employee->getId()] = $data;
        }

        $data = $this->dataPersistor->get('adobe_employee');

        if (!empty($data)) {
            $employee = $this->collection->getNewEmptyItem();
            $employee->setData($data);
            $this->loadedData[$employee->getId()] = $employee->getData();
            $this->dataPersistor->clear('adobe_employee');
        }

        return $this->loadedData;
    }
}
