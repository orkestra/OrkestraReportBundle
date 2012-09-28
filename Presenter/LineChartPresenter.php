<?php

namespace Orkestra\Bundle\ReportBundle\Presenter;

use Orkestra\Bundle\ReportBundle\PresenterInterface,
    Orkestra\Bundle\ReportBundle\ReportInterface,
    Orkestra\Bundle\ReportBundle\Filter;

use Orkestra\Bundle\ReportBundle\Presenter\LineChart\ILineChartable;

/**
 * Presents the single latest snapshot of a given report in line chart form
 */
class LineChartPresenter implements PresenterInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'chart.line';
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'OrkestraReportBundle:Report:line_chart_template.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ReportInterface $report)
    {
    	return $report instanceof ILineChartable;
    }

    /**
     * Gets an array of Filters available for this presenter
     *
     * Filters:
     *   CallbackFilter that forces the retrieval of just the latest snapshot
     *
     * @return array
     */
    public function getFilters()
    {
        return array(

        );
    }
}
