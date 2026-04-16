<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Ui\Component\Listing\Column;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Employee Actions Column
 */
class EmployeeActions extends Column
{
    /**
     * Edit URL path
     */
    private const EMPLOYEE_EDIT_URL = 'employee/employee/edit';

    /**
     * Delete URL path
     */
    private const EMPLOYEE_DELETE_URL = 'employee/employee/delete';

    /**
     * @var UrlInterface
     */
    private UrlInterface $urlBuilder;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare data source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['entity_id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                self::EMPLOYEE_EDIT_URL,
                                ['entity_id' => $item['entity_id']]
                            ),
                            'label' => __('Edit'),
                            '__disableTmpl' => true
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                self::EMPLOYEE_DELETE_URL,
                                ['entity_id' => $item['entity_id']]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete Employee'),
                                'message' => __(
                                    'Are you sure you want to delete this employee?'
                                )
                            ],
                            '__disableTmpl' => true
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
