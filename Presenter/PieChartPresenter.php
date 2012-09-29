<?php

namespace Orkestra\Bundle\ReportBundle\Presenter;

use Orkestra\Bundle\ReportBundle\PresenterInterface,
Orkestra\Bundle\ReportBundle\ReportInterface,
Orkestra\Bundle\ReportBundle\Filter;

use Orkestra\Bundle\ReportBundle\Presenter\PieChart\PieChartable;

/**
 * Presents the single latest snapshot of a given report in Pie Chart form
 */
class PieChartPresenter implements PresenterInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'chart.pie';
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'OrkestraReportBundle:Report:pie_chart_template.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ReportInterface $report)
    {
        return $report instanceof PieChartable;
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
