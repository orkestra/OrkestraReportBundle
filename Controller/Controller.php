<?php

namespace Orkestra\Bundle\ReportBundle\Controller;

use Orkestra\Bundle\ApplicationBundle\Controller\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Creates a Presentation given a Presenter and Report
     *
     * @param \Orkestra\Bundle\ReportBundle\PresenterInterface|string $presenter If a string, an attempt to lookup the presenter will be done
     * @param \Orkestra\Bundle\ReportBundle\ReportInterface|string $report If a string, an attempt to lookup the report will be done
     *
     * @return \Orkestra\Bundle\ReportBundle\Presentation
     */
    public function createPresentation($presenter, $report)
    {
        $factory = $this->get('orkestra.report_factory');

        if (!is_object($presenter)) {
            $presenter = $factory->getPresenter($presenter);
        }

        if (!is_object($report)) {
            $report = $factory->getReport($report);
        }

        return $factory->createPresentation($presenter, $report);
    }
}
