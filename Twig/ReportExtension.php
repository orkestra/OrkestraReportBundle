<?php

namespace Orkestra\Bundle\ReportBundle\Twig;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use Orkestra\Bundle\ReportBundle\Presentation;

/**
 * Report Extension
 *
 * Defines added functionality for rendering reports in Twig templates
 */
class ReportExtension extends \Twig_Extension
{
    protected $_engine;

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('present_report', array($this, 'presentReport'), array('is_safe' => array('html'))),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'orkestra.report_extension';
    }

    /**
     * Renders the report view using the configured templating engine
     *
     * @param Orkestra\Bundle\ReportBundle\Presentation $presentation
     * @return string
     */
    public function presentReport(Presentation $presentation)
    {
        return $presentation->render();
    }
}
