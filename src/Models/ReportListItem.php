<?php
namespace Twinsen\AmazonMwsRepricing\Models;


class ReportListItem
{
    /**
     * @var string
     */
    protected $reportId;
    /**
     * @var string
     */
    protected $reportType;
    /**
     * @var string
     */
    protected $reportRequestId;
    /**
     * @var string
     */
    protected $availableDate;
    /**
     * @var string
     */
    protected $acknowledged;
    /**
     * @var string
     */
    protected $acknowledgedDate;

    /**
     * @return string
     */
    public function getAcknowledged()
    {
        return $this->acknowledged;
    }

    /**
     * @param string $acknowledged
     */
    public function setAcknowledged($acknowledged)
    {
        $this->acknowledged = $acknowledged;
    }

    /**
     * @return string
     */
    public function getReportId()
    {
        return $this->reportId;
    }

    /**
     * @param string $reportId
     */
    public function setReportId($reportId)
    {
        $this->reportId = $reportId;
    }

    /**
     * @return string
     */
    public function getReportType()
    {
        return $this->reportType;
    }

    /**
     * @param string $reportType
     */
    public function setReportType($reportType)
    {
        $this->reportType = $reportType;
    }

    /**
     * @return string
     */
    public function getReportRequestId()
    {
        return $this->reportRequestId;
    }

    /**
     * @param string $reportRequestId
     */
    public function setReportRequestId($reportRequestId)
    {
        $this->reportRequestId = $reportRequestId;
    }

    /**
     * @return string
     */
    public function getAvailableDate()
    {
        return $this->availableDate;
    }

    /**
     * @param string $availableDate
     */
    public function setAvailableDate($availableDate)
    {
        $this->availableDate = $availableDate;
    }

    /**
     * @return string
     */
    public function getAcknowledgedDate()
    {
        return $this->acknowledgedDate;
    }

    /**
     * @param string $acknowledgedDate
     */
    public function setAcknowledgedDate($acknowledgedDate)
    {
        $this->acknowledgedDate = $acknowledgedDate;
    }

}
