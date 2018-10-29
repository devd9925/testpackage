<?php
namespace Twinsen\AmazonMwsRepricing\Models;


class PaaConfigModel implements PaaConfigInterface
{
    /**
     * @var string
     */
    protected $country;
    /**
     * @var string
     */
    protected $accessKey;
    /**
     * @var string
     */
    protected $secretKey;
    /**
     * @var string
     */
    protected $associateTag;

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
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
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param string $secretKey
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @return string
     */
    public function getAssociateTag()
    {
        return $this->associateTag;
    }

    /**
     * @param string $associateTag
     */
    public function setAssociateTag($associateTag)
    {
        $this->associateTag = $associateTag;
    }
}
