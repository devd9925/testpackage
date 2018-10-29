<?php
namespace Twinsen\AmazonMwsRepricing;

use Sunra\PhpSimple\HtmlDomParser;

class AmazonRestService
{
    protected $lastUrl;

    public function getSellerName($sellerId, $marketPlace = "A1PA6795UKMFR9")
    {
        $url = "http://www.amazon.de/gp/aag/main?ie=UTF8&marketplaceID=" . $marketPlace . "&orderID=&seller=" . $sellerId;
        //echo $url;
        $this->lastUrl = $url;
        $html = file_get_contents($url);
        $dom = HtmlDomParser::str_get_html($html);
        $sellerName = null;
        $rightColumn = $dom->find('.amabot_right',0);


        $UlElement = $rightColumn->find('ul.aagLegalData', 0);
        if($UlElement != null){
            $LiElement = $UlElement->find('li.aagLegalRow', 0);
            if($LiElement != null){
                $LiElement->children(0)->innertext = "";
                $sellerName = $LiElement->plaintext;
            }
        }else{
            $pElement = $rightColumn->find('p', 0);
            $children = $pElement->children(0);
            if($children){
                $children->innertext = "";
            }
            $sellerName = $pElement->plaintext;
        }



        return $sellerName;

    }

    public function getLastUrl()
    {
        return $this->lastUrl;
    }

}