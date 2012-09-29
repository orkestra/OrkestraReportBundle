<?php

namespace Orkestra\Bundle\ReportBundle\Presenter\Snapshot;

/**
 * Defines options available for Reports supporting the SnapshotPresenter
 */
class SnapshotOptions
{
	/**
     * @var callable
	 */
	protected $_valueFormatter;

	/**
	 * @var array
	 */
	protected $_categories = array();

	/**
	 * @var array
	 */
	protected $_series = array();

	/**
	 * Constructor
	 *
	 * @param array $options An array of options
	 */
	public function __construct(array $options = array())
	{
		$this->_valueFormatter = function($fact, $value) { return $value; };
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
	 * Sets the value formatter
	 *
	 * The formatter should be a valid callable that can take two parameters,
	 * the fact name and the current value. The callable should return a string
	 * with the formatted value.
	 *
	 * An example that would format the value as USD:
	 * <code>
	 * $options->setValueFormatter(function($fact, $value) {
	 *     return '$' . number_format($value, 2);
	 * });
	 * </code>
	 *
	 * @param callable $formatter
	 *
	 * @return \Orkestra\Bundle\ReportBundle\Presenter\Snapshot\SnapshotOptions The current SnapshotOptions
	 */
	public function setValueFormatter($formatter)
	{
		$this->_valueFormatter = $formatter;

		return $this;
	}

	/**
	 * Gets the value formatter
	 *
	 * @return callable
	 */
	public function getValueFormatter()
	{
		return $this->_valueFormatter;
	}

    /**
	 * Sets the categories
	 *
	 * @param array $categories
	 *
	 * @return SnapshotOptions The current instance
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
	 * @return SnapshotOptions The current instance
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

	/**
	 * Formats the given value using the specified formatter
	 *
	 * If no formatter is specified, the value is returned unchanged
	 *
	 * @param string $fact
	 * @param string $value
	 */
	public function formatValue($fact, $value)
	{
		$formatter = $this->_valueFormatter;

		foreach ($this->_series as $series) {
			if (empty($series['valueFormatter']) || !in_array($fact, $series['facts'])) {
				continue;
			}

			$formatter = $series['valueFormatter'];
		}

		return call_user_func($formatter, $fact, $value);
	}
}
