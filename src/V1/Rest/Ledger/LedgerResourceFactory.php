<?php
namespace ApigilityFinance\V1\Rest\Ledger;

class LedgerResourceFactory
{
    public function __invoke($services)
    {
        return new LedgerResource($services);
    }
}
