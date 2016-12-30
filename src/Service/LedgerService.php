<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/16
 * Time: 15:16
 */
namespace ApigilityFinance\Service;

use ApigilityUser\DoctrineEntity\User;
use Zend\ServiceManager\ServiceManager;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineToolPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use ApigilityFinance\DoctrineEntity;
use Doctrine\ORM\Query\Expr;

class LedgerService
{
    protected $classMethodsHydrator;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \ApigilityUser\Service\UserService
     */
    protected $userService;

    public function __construct(ServiceManager $services)
    {
        $this->classMethodsHydrator = new ClassMethodsHydrator();
        $this->em = $services->get('Doctrine\ORM\EntityManager');
        $this->userService = $services->get('ApigilityUser\Service\UserService');
    }

    public function createLedger($data)
    {
        if (isset($data->user_id)) $user = $this->userService->getUser($data->user_id);
        else throw new \Exception('没用指定数据所属用户', 500);

        $ledger = new DoctrineEntity\Ledger();
        if (isset($data->account)) $ledger->setAccount($data->account);
        else $ledger->setAccount('default');

        if (isset($data->amount)) $ledger->setAmount($data->amount);
        else throw new \Exception('没有输入发生额', 500);

        if (isset($data->amount_type)) $ledger->setAmountType($data->amount_type);
        else throw new \Exception('没有输入发生额类型', 500);

        // TODO: 计算余额
        $top_ledger = $this->getTopLedger($user);

        switch ($data->amount_type) {
            case DoctrineEntity\Ledger::AMOUNT_TYPE_DEBIT:
                if (empty($top_ledger)) $ledger->setBalance((double)$data->amount);
                else $ledger->setBalance((double)$data->amount+(double)$top_ledger->getBalance());
                break;

            case DoctrineEntity\Ledger::AMOUNT_TYPE_CREDIT:
                if (empty($top_ledger)) $ledger->setBalance(-(double)$data->amount);
                else $ledger->setBalance((double)$top_ledger->getBalance()-(double)$data->amount);
                break;

            default:
                throw new \Exception('未知的发生额类型', 500);

        }

        $ledger->setCreateTime(new \DateTime());
        $ledger->setUser($user);

        $this->em->persist($ledger);
        $this->em->flush();

        return $ledger;
    }

    /**
     * @param $ledger_id
     * @return \ApigilityFinance\DoctrineEntity\Ledger
     * @throws \Exception
     */
    public function getLedger($ledger_id)
    {
        $ledger = $this->em->find('ApigilityFinance\DoctrineEntity\Ledger', $ledger_id);
        if (empty($ledger)) throw new \Exception('分录不存在', 404);
        else return $ledger;
    }

    /**
     * @param User $user
     * @param string $account
     * @return \ApigilityFinance\DoctrineEntity\Ledger
     */
    public function getTopLedger(User $user, $account = 'default')
    {
        $params = new \stdClass();
        $params->account = $account;
        $params->user_id = $user->getId();
        $rs = $this->getLedgers($params);
        if ($rs->count() > 0) {
            return $rs->getItems(0,1)[0];
        } else return null;
    }

    public function getLedgers($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('l')->from('ApigilityFinance\DoctrineEntity\Ledger', 'l')->orderBy(new Expr\OrderBy('l.id', 'DESC'));

        $where = '';
        if (isset($params->account)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'l.account = :account';
        }

        if (isset($params->user_id)) {
            $qb->innerJoin('l.user', 'user');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'user.id = :user_id';
        }

        if (!empty($where)) {
            $qb->where($where);
            if (isset($params->account)) $qb->setParameter('account', $params->account);
            if (isset($params->user_id)) $qb->setParameter('user_id', $params->user_id);
        }

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }
}