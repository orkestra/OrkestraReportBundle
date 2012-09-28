<?php

namespace Orkestra\Bundle\ReportBundle\Presenter;

use Orkestra\Bundle\ReportBundle\PresenterInterface,
    Orkestra\Bundle\ReportBundle\ReportInterface,
    Orkestra\Bundle\ReportBundle\Filter;

use Orkestra\Bundle\ReportBundle\Presenter\BarChart\IBarChartable;

/**
 * Presents the single latest snapshot of a given report in column chart form
 */
class BarChartPresenter implements PresenterInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'chart.bar';
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'OrkestraReportBundle:Report:bar_chart_template.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ReportInterface $report)
    {
    	return $report instanceof IBarChartable;
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
            new Filter\CallbackFilter(function ($qb) {
                $qb->addOrderBy('s.id', 'DESC')
                   ->setMaxResults(1);
            })
        );
    }
}
