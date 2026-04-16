<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Ui\DataProvider\Employee;

use Adobe\Employee\Model\ResourceModel\Employee\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Employee Listing DataProvider
 */
class ListingDataProvider extends AbstractDataProvider
{
    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->collection->setOrder('entity_id', 'ASC');
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
    }

    /**
     * Add fulltext filter support
     *
     * @param Filter $filter
     * @return void
     */
    public function addFilter(Filter $filter): void
    {
        if ($filter->getField() === 'fulltext') {
            $value = $filter->getValue();
            $this->collection->addFieldToFilter(
                [
                    'name',
                    'gender',
                    'designation',
                    'address',
                    'hobbies'
                ],
                [
                    ['like' => "%{$value}%"],
                    ['like' => "%{$value}%"],
                    ['like' => "%{$value}%"],
                    ['like' => "%{$value}%"],
                    ['like' => "%{$value}%"]
                ]
            );
        } else {
            parent::addFilter($filter);
        }
    }
}