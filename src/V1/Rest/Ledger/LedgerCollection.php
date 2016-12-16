<?php
namespace ApigilityFinance\V1\Rest\Ledger;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareCollection;

class LedgerCollection extends ApigilityObjectStorageAwareCollection
{
    protected $itemType = LedgerEntity::class;
}
