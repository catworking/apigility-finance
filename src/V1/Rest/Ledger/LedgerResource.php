<?php
namespace ApigilityFinance\V1\Rest\Ledger;

use ApigilityCatworkFoundation\Base\ApigilityResource;
use Zend\ServiceManager\ServiceManager;
use ZF\ApiProblem\ApiProblem;

class LedgerResource extends ApigilityResource
{
    /**
     * @var \ApigilityFinance\Service\LedgerService
     */
    protected $ledgerService;

    public function __construct(ServiceManager $services)
    {
        parent::__construct($services);
        $this->ledgerService = $this->serviceManager->get('ApigilityFinance\Service\LedgerService');
    }

    public function create($data)
    {
        try {
            return new LedgerEntity($this->ledgerService->createLedger($data), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetch($id)
    {
        try {
            return new LedgerEntity($this->ledgerService->getLedger($id), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetchAll($params = [])
    {
        try {
            return new LedgerCollection($this->ledgerService->getLedgers($params), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }
}
