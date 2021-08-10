<?php
// namespace administrator\components\com_jmap\framework\google;
/**
 *
 * @package JMAP::FRAMEWORK::administrator::components::com_jmap
 * @subpackage framework
 * @subpackage google
 * @author Joomla! Extensions Store
 * @copyright (C) 2021 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ();

class Google_Service_AnalyticsData_Metadata extends Google_Collection
{
  protected $collection_key = 'metrics';
  protected $dimensionsType = 'Google_Service_AnalyticsData_DimensionMetadata';
  protected $dimensionsDataType = 'array';
  protected $metricsType = 'Google_Service_AnalyticsData_MetricMetadata';
  protected $metricsDataType = 'array';
  public $name;

  /**
   * @param Google_Service_AnalyticsData_DimensionMetadata
   */
  public function setDimensions($dimensions)
  {
    $this->dimensions = $dimensions;
  }
  /**
   * @return Google_Service_AnalyticsData_DimensionMetadata
   */
  public function getDimensions()
  {
    return $this->dimensions;
  }
  /**
   * @param Google_Service_AnalyticsData_MetricMetadata
   */
  public function setMetrics($metrics)
  {
    $this->metrics = $metrics;
  }
  /**
   * @return Google_Service_AnalyticsData_MetricMetadata
   */
  public function getMetrics()
  {
    return $this->metrics;
  }
  public function setName($name)
  {
    $this->name = $name;
  }
  public function getName()
  {
    return $this->name;
  }
}
