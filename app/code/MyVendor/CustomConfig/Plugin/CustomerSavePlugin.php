<?php
namespace MyVendor\CustomConfig\Plugin;

use Magento\Customer\Api\Data\CustomerInterface;

class CustomerSavePlugin
{
    //run this method before original save method
    public function beforeSave(
        \Magento\Customer\Api\CustomerRepositoryInterface $subject,
        CustomerInterface $customer
    ) {
        $email = strtolower(trim($customer->getEmail()));

        if (str_ends_with($email, '@adobe.com')) {

            $firstname = $customer->getFirstname();

            if (!str_ends_with($firstname, ' adobe')) {
                $customer->setFirstname($firstname . ' adobe');
            }
        }

        return [$customer];
    }
}
