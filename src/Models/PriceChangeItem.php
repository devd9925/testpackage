<?php
namespace Twinsen\AmazonMwsRepricing\Models;

class PriceChangeItem
{
    /**
     * @var string
     */
    protected $asin;
    /**
     * @var float
     */
    protected $price;
    /**
     * @var float
     */
    protected $shipping;
    /**
     * @var string
     */
    protected $sellerId;
    /**
     * @var int
     */
    protected $condition;
    /**
     * @var boolean
     */
    protected $own;

    /**
     * @return string
     */
    public function getAsin()
    {
        return $this->asin;
    }

    /**
     * @param string $asin
     */
    public function setAsin($asin)
    {
        $this->asin = $asin;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param float $shipping
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * @return string
     */
    public function getSellerId()
    {
        return $this->sellerId;
    }

    /**
     * @param string $sellerId
     */
    public function setSellerId($sellerId)
    {
        $this->sellerId = $sellerId;
    }

    /**
     * @return int
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param int $condition
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    /**
     * @return boolean
     */
    public function isOwn()
    {
        return $this->own;
    }

    /**
     * @param boolean $own
     */
    public function setOwn($own)
    {
        $this->own = $own;
    }


}
