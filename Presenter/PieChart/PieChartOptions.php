<?php

namespace Orkestra\Bundle\ReportBundle\Presenter\PieChart;

/**
 * Defines options available for reports that support the PieChartPresenter
 */
class PieChartOptions
{
	/**
     * @var string
	 */
	protected $_title;

    /**
     * This is the name of the series displayed for a piece of pie
     *
     * @var string
     */
    protected $_seriesName;

    /**
     * @var string
     */
    protected $_renderId;

    /**
	 * @var array
	 */
	protected $facts;

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
     * @param string $seriesName
     */
    public function setSeriesName($seriesName)
    {
        $this->_seriesName = $seriesName;
    }

    /**
     * @return string
     */
    public function getSeriesName()
    {
        return $this->_seriesName;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->_title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @param array $facts
     */
    public function setFacts(array $facts)
    {
        $this->facts = $facts;
    }

    /**
     * @return array
     */
    public function getFacts()
    {
        return $this->facts;
    }

    /**
     * @param string $renderId
     */
    public function setRenderId($renderId)
    {
        $this->_renderId = $renderId;
    }

    /**
     * @return string
     */
    public function getRenderId()
    {
        return $this->_renderId;
    }

}
