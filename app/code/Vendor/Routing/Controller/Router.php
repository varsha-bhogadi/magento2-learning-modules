<?php
namespace Vendor\Routing\Controller;

use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ActionFactory;

class Router implements RouterInterface
{
    protected $actionFactory;

    public function __construct(ActionFactory $actionFactory)
    {
        $this->actionFactory = $actionFactory;
    }

    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');

        if ($identifier === 'customroute/index/index') {

            $request->setModuleName('customroute')
                ->setControllerName('index')
                ->setActionName('index');

            return $this->actionFactory->create(
                \Vendor\Routing\Controller\Index\Index::class
            );
        }

        return null;
    }
}