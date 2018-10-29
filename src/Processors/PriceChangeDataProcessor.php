<?php
namespace Twinsen\AmazonMwsRepricing\Processors;

use Aws\CloudFront\Exception\Exception;
use Twinsen\AmazonMwsRepricing\Models\ItemCondition;
use Twinsen\AmazonMwsRepricing\Models\PriceChangeItem;
use Twinsen\AmazonMwsRepricing\Models\PriceChangeMessage;

/**
 * Class PriceChangeDataProcessor
 * @package Twinsen\AmazonMwsRepricing\Processors
 */
class PriceChangeDataProcessor
{

    public function processMessages($messagesArray)
    {

    }

    /**
     * @param $inputData
     * @return
     */
    public function processData($inputData)
    {
        $element = simplexml_load_string($inputData);
        $offers = $element->NotificationPayload->AnyOfferChangedNotification->Offers->Offer;
        $items = array();
        $asin = (string)$element->NotificationPayload->AnyOfferChangedNotification->OfferChangeTrigger->ASIN;
        $sellerId = (string)$element->NotificationMetaData->SellerId;
        foreach ($offers as $offer) {

            $item = new PriceChangeItem();
            $item->setSellerId((string)$offer->SellerId);
            $item->setAsin($asin);
            if ($sellerId == (string)$offer->SellerId) {
                $item->setOwn(true);
            }else{
                $item->setOwn(false);
            }
            $condition = (string)$offer->SubCondition;
            switch ($condition) {
                case "new":
                    $item->setCondition(ItemCondition::CONDITION_NEW);
                    break;
                case "good":
                    $item->setCondition(ItemCondition::CONDITION_GOOD);
                    break;
                case "very_good":
                    $item->setCondition(ItemCondition::CONDITION_VERY_GOOD);
                    break;
                case "acceptable":
                    $item->setCondition(ItemCondition::CONDITION_ACCEPTABLE);
                    break;
                case "like_new":
                    $item->setCondition(ItemCondition::CONDITION_LIKE_NEW);
                    break;

                default:
                    throw new Exception('Condition is unresolved' . $condition);
                    break;
            }
            $item->setPrice((string)$offer->ListingPrice->Amount);
            $item->setShipping((string)$offer->Shipping->Amount);
            $items[] = $item;
        }
        $priceChangeMessage = new PriceChangeMessage();
        $priceChangeMessage->setAsin($asin);
        $timeStr = (string)$element->NotificationPayload->AnyOfferChangedNotification->OfferChangeTrigger->TimeOfOfferChange;
        $priceChangeMessage->setDate($this->convertDate($timeStr));
        $priceChangeMessage->setItems($items);
        return $priceChangeMessage;
    }

    /**
     * @param string $timeStr
     * @return \DateTime
     */
    private function convertDate($timeStr){
        $retTime = new \DateTime($timeStr);
        return $retTime;
    }
}
