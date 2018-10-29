<?php
namespace Twinsen\AmazonMwsRepricing\Models;

class MwsConfigModel implements MwsConfigInterface
{
    /**
     * @var string
     */
    protected $serviceUrl;
    /**
     * @var string
     */
    protected $keyId;
    /**
     * @var string
     */
    protected $accessKey;
    /**
     * @var string
     */
    protected $marketPlaceId;
    /**
     * @var string
     */
    protected $merchantId;

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @param string $merchantId
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    /**
     * @return string
     */
    public function getServiceUrl()
    {
        return $this->serviceUrl;
    }

    /**
     * @param string $serviceUrl
     */
    public function setServiceUrl($serviceUrl)
    {
        $this->serviceUrl = $serviceUrl;
    }

    /**
     * @return string
     */
    public function getKeyId()
    {
        return $this->keyId;
    }

    /**
     * @param string $keyId
     */
    public function setKeyId($keyId)
    {
        $this->keyId = $keyId;
    }

    /**
     * @return string
     */
    public function getAccessKey()
    {
        return $this->accessKey;
    }

    /**
     * @param string $accessKey
     */
    public function setAccessKey($accessKey)
    {
        $this->accessKey = $accessKey;
    }

    /**
     * @return string
     */
    public function getMarketPlaceId()
    {
        return $this->marketPlaceId;
    }

    /**
     * @param string $marketPlaceId
     */
    public function setMarketPlaceId($marketPlaceId)
    {
        $this->marketPlaceId = $marketPlaceId;
    }
    /**
     * @return string
     */
    public function getApplicationName()
    {
        return 'Twinsen AmazonRepricer';
    }

    /**
     * @return string
     */
    public function getApplicationVersion()
    {
        return '1.0';
    }


}
