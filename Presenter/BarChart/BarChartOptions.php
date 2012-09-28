<?php

namespace Orkestra\Bundle\ReportBundle\Presenter\BarChart;

/**
 * Defines options available for reports that support the BarChartPresenter
 */
class BarChartOptions
{
	/**
	 * Represents a Bar chart
	 */
	const BarChart = 'bar';

	/**
	 * Represents a Column chart
	 */
	const ColumnChart = 'column';

	/**
     * @var string
	 */
	protected $_yAxisTitle;

	/**
	 * @var array
	 */
	protected $_overrideOptions;

	/**
	 * @var string One of BarChart or ColumnChart
	 */
	protected $_chartType = self::BarChart;

	/**
	 * @var array
	 */
	protected $_categories;

	/**
	 * @var array
	 */
	protected $_series;

	/**
	 * Constructor
	 *
	 * @param array $options An array of options
	 */
	public function __construct(array $options = array())
	{
		$this->_setOptions($options);
	}

	/**
	 * Takes each key and attempts to call a setter with the same name
	 *
	 * @param array $options An array of options
	 */
	protected function _setOptions(array $options)
	{
		foreach ($options as $key => $value) {
			$callable = array($this, 'set' . $key);

			if (is_callable($callable)) {
			    call_user_func($callable, $value);
			}
		}
	}

	/**
	 * Sets the Y-axis title
	 *
	 * @param string $title
	 *
	 * @return BarChartOptions The current instance
	 */
	public function setYAxisTitle($title)
	{
		$this->_yAxisTitle = $title;

		return $this;
	}

	/**
	 * Gets the Y-axis title
	 *
	 * @return string
	 */
	public function getYAxisTitle()
	{
		return $this->_yAxisTitle;
	}

	/**
	 * Sets the override options
	 *
	 * These will be json_encoded and then merged with the default chart options,
	 * overriding any existing options with your new values
	 *
	 * @param array $options
	 *
	 * @return BarChartOptions The current instance
	 */
	public function setOverrideOptions($options)
	{
		$this->_overrideOptions = $options;

		return $this;
	}

	/**
	 * Gets the json_encoded override options
	 *
	 * @return string
	 */
	public function getOverrideOptions()
	{
		return json_encode($this->_overrideOptions);
	}

	/**
	 * Sets the chart type
	 *
	 * @param string $type One of the class constants BarChart or ColumnChart
	 *
	 * @throws \InvalidArgumentException if an invalid value is passed
	 * @return BarChartOptions The current instance
	 */
	public function setChartType($type)
	{
		if (!in_array($type, array(self::BarChart, self::ColumnChart))) {
			throw new \InvalidArgumentException(sprintf('Invalid chart type "%s"', $type));
		}

		$this->_chartType = $type;

		return $this;
	}

	/**
	 * Gets the chart type
	 *
	 * @return string
	 */
	public function getChartType()
	{
		return $this->_chartType;
	}

	/**
	 * Sets the categories
	 *
	 * @param array $categories
	 *
	 * @return BarChartOptions The current instance
	 */
	public function setCategories(array $categories)
	{
		$this->_categories = $categories;

		return $this;
	}

	/**
	 * Gets the categories
	 *
	 * @return array
	 */
	public function getCategories()
	{
		return $this->_categories;
	}

	/**
	 * Sets the series
	 *
	 * @param array $series
	 *
	 * @return BarChartOptions The current instance
	 */
	public function setSeries(array $series)
	{
		$this->_series = $series;

		return $this;
	}

	/**
	 * Gets the series
	 *
	 * @return array
	 */
	public function getSeries()
	{
		return $this->_series;
	}
}
