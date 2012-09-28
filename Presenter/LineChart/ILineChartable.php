<?php

namespace Orkestra\Bundle\ReportBundle\Presenter\LineChart;

/**
 * Defines the contract that a report must follow to support the LineChartPresenter
 */
interface ILineChartable
{
	/**
	 * Gets configuration options used specifically by the LineChartPresenter
	 *
	 * @return Orkestra\Bundle\ReportBundle\Presenter\LineChart\LineChartOptions
	 */
	function getLineChartOptions();
}
