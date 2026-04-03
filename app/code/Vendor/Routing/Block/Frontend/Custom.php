<?php
namespace Vendor\Routing\Block\Frontend;

use Magento\Framework\View\Element\Template;

class Custom extends Template
{
    public function getInternName()
    {
        return 'Varsha';
    }

    public function getCurrentUrl()
    {
        return $this->getUrl('*/*/*', ['_current' => true]);
    }
}