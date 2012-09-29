<?php

namespace Orkestra\Bundle\ReportBundle\Presenter\PieChart;

/**
 * Defines the contract that a report must follow to support the PieChartPresenter
 */
interface PieChartable
{
	/**
	 * Gets configuration options used specifically by the PieChartPresenter
	 *
	 * @return \Orkestra\Bundle\ReportBundle\Presenter\PieChart\PieChartOptions
	 */
	function getPieChartOptions();
}
