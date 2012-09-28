<?php

namespace Orkestra\Bundle\ReportBundle\Presenter\LineChart;

/**
 * Defines options available for Reports supporting the LineChartPresenter
 */
class LineChartOptions
{
    /**
	 * Represents a Line chart
	 */
	const LineChart = 'line';

	/**
	 * Represents a Spline chart
	 */
	const SplineChart = 'spline';

	/**
	 * @var array
	 */
	protected $_yAxes = array();

	/**
	 * @var array
	 */
	protected $_overrideOptions = array();

	/**
	 * @var string One of BarChart or ColumnChart
	 */
	protected $_chartType = self::LineChart;

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
			$callable = array($this, $key);

			if (!is_callable($callable)) {
				$callable = array($this, 'set' . $key);
			}

			if (is_callable($callable)) {
				call_user_func_array($callable, (array)$value);
			}
		}
	}

	/**
	 * Adds a Y-axis
	 *
	 * @param array $options
	 */
	public function addYAxis(array $options)
	{
		$this->_yAxes[] = $options;

		return $this;
	}

	/**
	 * Gets the Y-axes
	 *
	 * @return array
	 */
	public function getYAxes()
	{
		return $this->_yAxes;
	}

	/**
	 * Sets the override options
	 *
	 * These will be json_encoded and then merged with the default chart options,
	 * overriding any existing options with your new values
	 *
	 * @param array $options
	 *
	 * @return LineChartOptions The current instance
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
		if (!in_array($type, array(self::LineChart, self::SplineChart))) {
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
}
