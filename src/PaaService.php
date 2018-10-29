<?php
namespace Twinsen\AmazonMwsRepricing;

use Twinsen\AmazonMwsRepricing\Models\MwsConfigInterface;
use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
use Twinsen\AmazonMwsRepricing\Models\PaaConfigInterface;


class PaaService
{
    /**
     * @var ApaiIO
     */
    protected $service;
    public function connect(PaaConfigInterface $config){
        $conf = new GenericConfiguration();
        try {
            $conf
                ->setCountry($config->getCountry())
                ->setAccessKey($config->getAccessKey())
                ->setSecretKey($config->getSecretKey())
                ->setAssociateTag($config->getAssociateTag());
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
        $this->service = new ApaiIO($conf);


    }
    public function getCompetitivePriceForItems(){


//echo $formattedResponse;
// Change the ResponseTransformer to DOMDocument.

    }

    /**
     * @param $asinList
     */
    public function getCompetivePriceForAsin($asinList){
        $lookup = new Lookup();
        $lookup->setItemId($asinList);
        //$lookup->setMerchantId("test");
        $lookup->setResponseGroup(array('Offers'));
        $formattedResponse = $this->service->runOperation($lookup);
        $simpleXML = simplexml_load_string($formattedResponse);
        return $simpleXML;
    }
    public function debugResponse(\SimpleXMLElement $element){
        $dom = new \DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($element->asXML());
        return $dom->saveXML();
    }



}
