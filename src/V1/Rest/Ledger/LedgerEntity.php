<?php
namespace ApigilityFinance\V1\Rest\Ledger;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareEntity;
use ApigilityUser\DoctrineEntity\User;
use ApigilityUser\V1\Rest\User\UserEntity;
use Zend\Form\Element\DateTime;

class LedgerEntity extends ApigilityObjectStorageAwareEntity
{
    const AMOUNT_TYPE_DEBIT = 1;
    const AMOUNT_TYPE_CREDIT = 2;

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 分录的所有者，ApigilityUser组件的User对象
     *
     * @ManyToOne(targetEntity="ApigilityUser\DoctrineEntity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * 账户名
     *
     * @Column(type="string", length=50, nullable=true)
     */
    protected $account;

    /**
     * 发生额
     *
     * @Column(type="decimal", precision=7, scale=2, nullable=false)
     */
    protected $amount;

    /**
     * 发生额的类型
     *
     * @Column(type="smallint", nullable=false)
     */
    protected $amount_type;

    /**
     * 账户余额
     *
     * @Column(type="decimal", precision=7, scale=2, nullable=false)
     */
    protected $balance;

    /**
     * 创建时间
     *
     * @Column(type="datetime", nullable=false)
     */
    protected $create_time;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        if ($this->user instanceof User) return $this->hydrator->extract(new UserEntity($this->user, $this->serviceManager));
        else return $this->user;
    }

    public function setAccount($account)
    {
        $this->account = $account;
        return $this;
    }

    public function getAccount()
    {
        return $this->account;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmountType($amount_type)
    {
        $this->amount_type = $amount_type;
        return $this;
    }

    public function getAmountType()
    {
        return $this->amount_type;
    }

    public function setBalance($balance)
    {
        $this->balance = $balance;
        return $this;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function setCreateTime(\DateTime $create_time)
    {
        $this->create_time = $create_time;
        return $this;
    }

    public function getCreateTime()
    {
        if ($this->create_time instanceof \DateTime) return $this->create_time->getTimestamp();
        else return $this->create_time;
    }
}
