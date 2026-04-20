<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Status Source Model
 */
class Status implements OptionSourceInterface
{
    /**
     * Status Active
     */
    public const STATUS_ACTIVE = 1;

    /**
     * Status Inactive
     */
    public const STATUS_INACTIVE = 0;

    /**
     * Get status options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::STATUS_ACTIVE,
                'label' => __('Active')
            ],
            [
                'value' => self::STATUS_INACTIVE,
                'label' => __('Inactive')
            ]
        ];
    }
}