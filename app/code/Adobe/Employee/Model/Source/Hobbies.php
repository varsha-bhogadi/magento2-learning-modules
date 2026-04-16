<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Hobbies Source Model
 */
class Hobbies implements OptionSourceInterface
{
    /**
     * Get hobbies options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => 'reading',
                'label' => __('Reading')
            ],
            [
                'value' => 'travelling',
                'label' => __('Travelling')
            ],
            
            [
                'value' => 'Music',
                'label' => __('Music')
            ],
            [
                'value' => 'sports',
                'label' => __('Sports')
            ]
        ];
    }
}
