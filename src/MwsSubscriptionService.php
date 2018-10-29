<?php
namespace Twinsen\AmazonMwsRepricing;

use Twinsen\AmazonMwsRepricing\Models\MwsConfigInterface;

/**
 * Class MwsClient
 * @package Twinsen\AmazonRepricer\AmazonMwsRepricing
 */
class MwsSubscriptionService
{
    /**
     * @var MwsConfigInterface
     */
    public $config;
    /**
     * @var \MWSSubscriptionsService_Client
     */
    public $service;

    /**
     * @param MwsConfigInterface $config
     */

    public function connect(MwsConfigInterface $config)
    {
        $configArray = array(
            'ServiceURL' => $config->getServiceUrl(),
            'ProxyHost' => null,
            'ProxyPort' => -1,
            'MaxErrorRetry' => 3,
        );
        $this->service = new \MWSSubscriptionsService_Client($config->getKeyId(), $config->getAccessKey(),
            $config->getApplicationName(), $config->getApplicationVersion(), $configArray);


        $this->config = $config;
    }

    public function listSubscriptions()
    {
        $request = new \MWSSubscriptionsService_Model_ListSubscriptionsInput();
        $request->setSellerId($this->config->getMerchantId());
        $request->setMarketplaceId($this->config->getMarketPlaceId());
        $response = $this->service->ListSubscriptions($request);
        //echo $this->debugResponse($response);
        /*  @var \MWSSubscriptionsService_Model_ListSubscriptionsResult $result */
        $result = $response->getListSubscriptionsResult();
        /* @var \MWSSubscriptionsService_Model_SubscriptionList $subscriptionList */
        $subscriptionList = $result->getSubscriptionList();
        $destinationArray = array();
        /*  @var \MWSSubscriptionsService_Model_Subscription $subscription */
        foreach ($subscriptionList->getmember() as $subscription) {
            /*  @var \MWSSubscriptionsService_Model_Destination $destination */
            $destination = $subscription->getDestination();

            //echo $destination->getDeliveryChannel();
            //echo $subscription->getIsEnabled();
            $destinationArray[] = $this->getDestinationLink($destination);
        }

        return $destinationArray;

    }

    public function getDestinationLink(\MWSSubscriptionsService_Model_Destination $destination)
    {
        /* @var \MWSSubscriptionsService_Model_AttributeKeyValueList $attributeList */
        $attributeList = $destination->getAttributeList();
        $attributeListMembers = $attributeList->getmember();
        /* @var \MWSSubscriptionsService_Model_AttributeKeyValue $attributeListMember */
        $attributeListMember = $attributeListMembers[0];
        //echo $attributeListMember->getKey();
        /* @var string $url */
        $url = $attributeListMember->getValue();

        return $url;
    }

    public function createSubscription($sqsUrl)
    {
        $subscription = new \MWSSubscriptionsService_Model_Subscription();
        $destination = $this->createDestination($sqsUrl);
        $subscription->setDestination($destination);
        $subscription->setNotificationType("AnyOfferChanged");
        $subscription->setIsEnabled(true);

        $request = new \MWSSubscriptionsService_Model_CreateSubscriptionInput();
        $request->setSellerId($this->config->getMerchantId());
        $request->setMarketplaceId($this->config->getMarketPlaceId());
        $request->setSubscription($subscription);
        $response = $this->service->CreateSubscription($request);
        echo $response;

    }

    public function createDestination($sqsUrl)
    {
        $attribute = new  \MWSSubscriptionsService_Model_AttributeKeyValue;
        $attribute->setKey('sqsQueueUrl');
        $attribute->setValue($sqsUrl);
        $attributeList = new \MWSSubscriptionsService_Model_AttributeKeyValueList();
        $attributeList->setmember($attribute);
        $destination = new \MWSSubscriptionsService_Model_Destination();
        $destination->setAttributeList($attributeList);
        $destination->setDeliveryChannel('SQS');

        return $destination;
    }

    public function listDestinations()
    {

        $request = new \MWSSubscriptionsService_Model_ListRegisteredDestinationsInput();
        $request->setSellerId($this->config->getMerchantId());
        $request->setMarketplaceId($this->config->getMarketPlaceId());
        $response = $this->service->ListRegisteredDestinations($request);


        /*  @var \MWSSubscriptionsService_Model_ListRegisteredDestinationsResult $result */
        $result = $response->getListRegisteredDestinationsResult();
        /* @var \MWSSubscriptionsService_Model_DestinationList $destinationsList */
        $destinationsList = $result->getDestinationList();
        /*  @var \MWSSubscriptionsService_Model_Destination $destination */
        $destinationArray = array();
        foreach ($destinationsList->getmember() as $destination) {
            /*  @var \MWSSubscriptionsService_Model_Destination $destination */
            $destinationArray[] = $this->getDestinationLink($destination);
        }

        return $destinationArray;

    }

    public function registerDestination($sqsUrl)
    {
        $request = new \MWSSubscriptionsService_Model_RegisterDestinationInput();
        $request->setSellerId($this->config->getMerchantId());
        $request->setMarketplaceId($this->config->getMarketPlaceId());

        $destination = $this->createDestination($sqsUrl);
        $request->setDestination($destination);
        $response = $this->service->RegisterDestination($request);


    }

    public function debugResponse($response)
    {
        $dom = new \DOMDocument();
        $dom->loadXML($response->toXML());
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        echo $dom->saveXML();
        echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
    }

    public function sendTestMessageToDestination($sqsUrl)
    {
        $request = new \MWSSubscriptionsService_Model_SendTestNotificationToDestinationInput();
        $request->setSellerId($this->config->getMerchantId());
        $request->setMarketplaceId($this->config->getMarketPlaceId());
        $request->setDestination($this->createDestination($sqsUrl));
        $response = $this->service->SendTestNotificationToDestination($request);
        return $response;


    }
}
