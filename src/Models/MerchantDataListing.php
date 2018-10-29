<?php
namespace Twinsen\AmazonMwsRepricing\Models;


class MerchantDataListing extends \stdClass
{
    /**
     * @param $array array
     */
    public function setData($array)
    {
        foreach ($array as $key => $value) {
            $key = str_replace('-','',$key);
            $this->$key = $value;
        }
    }

    /**
     *
    1 = Used; Like New
    2 = Used; Very Good
    3 = Used; Good
    4 = Used; Acceptable
    5 = Collectible; Like New
    6 = Collectible; Very Good
    7 = Collectible; Good
    8 = Collectible; Acceptable
    9 = Not used
    10 = Refurbished
    11 = New
     */
    public function getCondition(){
        switch($this->itemcondition){
            case 1:
                $condition = ItemCondition::CONDITION_LIKE_NEW;
                break;
            case 2:
                $condition = ItemCondition::CONDITION_VERY_GOOD;
                break;
            case 3:
                $condition = ItemCondition::CONDITION_GOOD;
                break;
            case 4:
                $condition = ItemCondition::CONDITION_ACCEPTABLE;
                break;
            case 5:
                $condition = ItemCondition::CONDITION_COLLECTIBLE_LIKE_NEW;
                break;
            case 6:
                $condition = ItemCondition::CONDITION_COLLECTIBLE_VERY_GOOD;
                break;
            case 7:
                $condition = ItemCondition::CONDITION_COLLECTIBLE_GOOD;
                break;
            case 8:
                $condition = ItemCondition::CONDITION_COLLECTIBLE_ACCEPTABLE;
                break;
            case 11:
                $condition = ItemCondition::CONDITION_NEW;
                break;
            default:
                $condition = ItemCondition::CONDITION_UNKNOWN;
             break;

        }
        return $condition;
    }
}
/**
 * http://bettermws.com/report-types
 * Following Columns are available:
 * item-name
 * item-description
 * listing-id
 * seller-sku
 * price
 * quantity
 * open-date
 * image-url
 * item-is-marketplace
 * product-id-type
 * zshop-shipping-fee
 * item-note
 * item-condition
 * zshop-category1
 * zshop-browse-path
 * zshop-storefront-feature
 * asin1
 * asin2
 * asin3
 * will-ship-internationally
 * expedited-shipping
 * zshop-boldface
 * product-id
 * bid-for-featured-placement
 * add-delete
 * pending-quantity
 * fulfillment-channel

 * http://www.amazon.com/gp/help/customer/display.html?nodeId=1161312
 *
 */