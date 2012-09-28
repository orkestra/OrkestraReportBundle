<?php

namespace Orkestra\Bundle\ReportBundle\Presenter\BarChart;

/**
 * Defines the contract that a report must follow to support the BarChartPresenter
 */
interface IBarChartable
{
	/**
	 * Gets configuration options used specifically by the BarChartPresenter
	 *
	 * @return Orkestra\Bundle\ReportBundle\Presenter\BarChart\BarChartOptions
	 */
	function getBarChartOptions();
}
