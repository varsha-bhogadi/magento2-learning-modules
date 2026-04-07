<?php
namespace Vendor\Routing\Controller;

use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\RequestInterface;

class Router implements RouterInterface
{
    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');

        if ($identifier === 'custom-page') {
            // Rewrite to standard route
            $request->setPathInfo('/customroute/index/index');
        }

        return null;
    }
}
