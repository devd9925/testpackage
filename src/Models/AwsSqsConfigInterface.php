<?php
namespace Twinsen\AmazonMwsRepricing\Models;
interface AwsSqsConfigInterface
{
    /**
     * @return string
     */
    public function getRegion();
    /**
     * @return string
     */
    public function getAccessKey();
    /**
     * @return string
     */
    public function getSecretKey();

}
