<?php
namespace Twinsen\AmazonMwsRepricing;
use Twinsen\AmazonMwsRepricing\Models\MwsConfigInterface;
use Twinsen\AmazonMwsRepricing\Models\PriceChangeItem;
use Twinsen\AmazonMwsRepricing\Models\ReportListItem;
use \Twinsen\AmazonMwsRepricing\Processors\MerchantDataListingProcessor;
/**
 * Class MwsClient
 * @package Twinsen\AmazonRepricer\AmazonMwsRepricing
 */
class MwsService
{
    /**
     * @var MwsConfigInterface
     */
    public $config;
    /**
     * @var \MarketplaceWebService_Client
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
        $this->service = new \MarketplaceWebService_Client($config->getKeyId(), $config->getAccessKey(), $configArray,
            $config->getApplicationName(), $config->getApplicationVersion());
        $this->config = $config;
    }

    /**
     * @return ReportListItem[]
     */
    public function getReportList()
    {
        $returnList = array();
        //$request = new MarketplaceWebServiceProducts_Model_GetProductCategoriesForASINRequest();
        $request = new \MarketplaceWebService_Model_GetReportListRequest();
        $request->setMerchant($this->config->getMerchantId());
        $request->setMarketplace($this->config->getMarketPlaceId());
        $request->setMaxCount(100);
        $typeList = new \MarketplaceWebService_Model_TypeList();
        $typeList->setType("_GET_MERCHANT_LISTINGS_DATA_");
        $request->setReportTypeList($typeList);
        $response = $this->service->getReportList($request);
        var_dump($response);
        if ($response->isSetGetReportListResult()) {
            $getReportListResult = $response->getGetReportListResult();
            $reportInfoList = $getReportListResult->getReportInfoList();
            foreach ($reportInfoList as $reportInfo) {
                $report = new ReportListItem();

                if ($reportInfo->isSetReportId())
                {
                    $report->setReportId($reportInfo->getReportId());
                }
                if ($reportInfo->isSetReportType())
                {
                    $report->setReportType($reportInfo->getReportType());
                }
                if ($reportInfo->isSetReportRequestId())
                {
                    $report->setReportRequestId($reportInfo->getReportRequestId());
                }
                if ($reportInfo->isSetAvailableDate())
                {
                    $report->setAvailableDate($reportInfo->getAvailableDate());
                }
                if ($reportInfo->isSetAcknowledged())
                {
                    $report->setAcknowledged($reportInfo->getAcknowledged());
                }
                if ($reportInfo->isSetAcknowledgedDate())
                {
                    $report->setAcknowledgedDate($reportInfo->getAcknowledgedDate());
                }
                $returnList[] = $report;
            }
        }
        return $returnList;
    }

    /**
     * @param ReportListItem $report
     * @return string
     */
    public function getReport(ReportListItem $report){

        $request = new \MarketplaceWebService_Model_GetReportRequest();
        $request->setReport(@fopen('php://memory', 'rw+'));
        $request->setReportId($report->getReportId());
        $request->setMerchant($this->config->getMerchantId());
        $request->setMarketplace($this->config->getMarketPlaceId());
        $this->service->getReport($request);
        $reportData = stream_get_contents($request->getReport());
        return $reportData;

    }

    /**
     * @return string
     */
    public function getLastInventoryReport(){
        $lastReport = $this->getLastInventoryReportItem();
        //print_r($lastReport);
        $reportData = $this->getReport($lastReport);
        //file_put_contents('inventory.csv',$reportData);
        //print_r($reportData);
        return $reportData;


    }

    /**
     * @return ReportListItem
     */
    public function getLastInventoryReportItem(){
        // Get Report Id:
        $reportList = $this->getReportList();
        $lastReport = new ReportListItem();
        foreach($reportList as $report){
            if($report->getReportType()!="_GET_MERCHANT_LISTINGS_DATA_"){
                continue;
            }
            if($report->getAvailableDate() > $lastReport->getAvailableDate()){
                $lastReport = $report;
            }
        }
        return $lastReport;
    }

    /**
     * @return Models\MerchantDataListing[]
     */
    public function getInventoryItems(){
        $reportData = $this->getLastInventoryReport();
        $processor = new MerchantDataListingProcessor();
        $data = $processor->processData($reportData);
        return $data;
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
