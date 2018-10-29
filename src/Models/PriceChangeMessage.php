<?php
namespace Twinsen\AmazonMwsRepricing\Models;

class PriceChangeMessage
{
    /**
     * @var string
     */
    protected $asin;
    /**
     * @var \DateTime
     */
    protected $date;
    /**
     * @var PriceChangeItem[]
     */
    protected $items;

    /**
     * @return PriceChangeItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param PriceChangeItem[] $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getAsin()
    {
        return $this->asin;
    }

    /**
     * @param mixed $asin
     */
    public function setAsin($asin)
    {
        $this->asin = $asin;
    }


}
