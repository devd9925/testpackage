<?php
namespace Twinsen\AmazonMwsRepricing\Models;

class AwsSqsConfigModel implements AwsSqsConfigInterface
{
    /**
     * @var string
     */
    protected $region;
    /**
     * @var string
     */
    protected $accessKey;
    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
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

}
