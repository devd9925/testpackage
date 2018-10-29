<?php
namespace Twinsen\AmazonMwsRepricing;

use Twinsen\AmazonMwsRepricing\Models\MwsConfigInterface;

/**
 * Class MwsClient
 * @package Twinsen\AmazonRepricer\AmazonMwsRepricing
 */
class MwsProductService
{
    /**
     * @var MwsConfigInterface
     */
    public $config;
    /**
     * @var \RaffW\MwsProductApi\MwsClient
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
        $this->service = new \RaffW\MwsProductApi\MwsClient($config->getKeyId(), $config->getAccessKey(),
            $config->getApplicationName(), $config->getApplicationVersion(),$configArray);
        $this->config = $config;
    }

    /**
     * List or a single Asin
     * @param array|string $ASIN
     */
    public function getCompetitivePriceForASIN($ASIN)
    {
        if(is_string($ASIN)){
            $asinArray = array($ASIN);
        }else if(is_array($ASIN)){
            $asinArray = $ASIN;
        }else{
            return null;
        }
        $asin_list = new \RaffW\MwsProductApi\Model\ASINListType();
        $asin_list->setASIN($asinArray);
        //print_r($asin_list);


        $request = new \RaffW\MwsProductApi\Model\GetCompetitivePricingForASINRequest();
        $request->setSellerId($this->config->getMerchantId());
        $request->setMarketplaceId($this->config->getMarketPlaceId());
        $request->setASINList($asin_list);
        $response = $this->service->GetCompetitivePricingForASIN($request);

        $dom = new \DOMDocument();
        $dom->loadXML($response->toXML());
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        echo $dom->saveXML();
        var_dump($response->getGetCompetitivePricingForASINResult());
    }

    /**
     * @param \MarketplaceWebService_Exception $ex
     */
    private function processError(\MarketplaceWebService_Exception $ex)
    {

        echo("Caught Exception: " . $ex->getMessage() . "\n");
        echo("Response Status Code: " . $ex->getStatusCode() . "\n");
        echo("Error Code: " . $ex->getErrorCode() . "\n");
        echo("Error Type: " . $ex->getErrorType() . "\n");
        echo("Request ID: " . $ex->getRequestId() . "\n");
        echo("XML: " . $ex->getXML() . "\n");
        echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
        die();
    }
}
