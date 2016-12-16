<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/16
 * Time: 15:18
 */
namespace ApigilityFinance\Service;

use Zend\ServiceManager\ServiceManager;

class LedgerServiceFactory
{
    public function __invoke(ServiceManager $services)
    {
        return new LedgerService($services);
    }
}