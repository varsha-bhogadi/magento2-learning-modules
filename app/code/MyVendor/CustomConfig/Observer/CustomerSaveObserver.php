<?php
/**
 * Copyright © MyVendor. All rights reserved.
 */

namespace MyVendor\CustomConfig\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Api\Data\CustomerInterface;

class CustomerSaveObserver implements ObserverInterface
{
    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        /** @var CustomerInterface $customer */
        $customer = $observer->getEvent()->getCustomer();

        if (!$customer || !$customer->getEmail()) {
            return;
        }

        $email = strtolower(trim($customer->getEmail()));

        if (str_ends_with($email, '@adobe.com')) {

            $firstname = $customer->getFirstname();

            if ($firstname && !str_ends_with($firstname, ' adobe')) {
                $customer->setFirstname($firstname . ' adobe');
            }
        }
    }
}