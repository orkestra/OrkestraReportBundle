<?php

namespace Orkestra\Bundle\ReportBundle;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface,
    Symfony\Component\Form\FormFactory;

use Doctrine\ORM\EntityManager;

/**
 * Responsible for instantiating Presentations
 *
 * The ReportFactory is also responsible for managing the "list" of
 * registered Reports and Presenters
 */
class ReportFactory
{
    /**
     * @var Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
     */
    protected $_engine;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $_entityManager;

    /**
     * @var Symfony\Component\Form\FormFactory
     */
    protected $_formFactory;

    /**
     * @var array
     */
    protected $_presenters = array();

    /**
     * @var array
     */
    protected $_reports = array();

    /**
     * Constructor
     *
     * @param Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $engine
     * @param Doctrine\ORM\EntityManager $entityManager
     * @param Symfony\Component\Form\FormFactory $formFactory
     */
    public function __construct(EngineInterface $engine, EntityManager $entityManager, FormFactory $formFactory)
    {
        $this->_engine = $engine;
        $this->_entityManager = $entityManager;
        $this->_formFactory = $formFactory;
    }

    /**
     * Creates a new Presentation
     *
     * @param Orkestra\Bundle\ReportBundle\IPresenter $presenter
     * @param Orkestra\Bundle\ReportBundle\IReport $report
     */
    public function createPresentation(PresenterInterface $presenter, ReportInterface $report)
    {
        $queryBuilder = $this->_entityManager->createQueryBuilder();

        return new Presentation($this->_engine, $queryBuilder, $this->_formFactory, $this, $presenter, $report);
    }

    /**
     * Registers a Presenter with the factory
     *
     * @param Orkestra\Bundle\ReportBundle\PresenterInterface
     */
    public function addPresenter(PresenterInterface $presenter)
    {
        $this->_presenters[$presenter->getName()] = $presenter;
    }

    /**
     * Gets a registered Presenter
     *
     * @param string $alias The alias of the Presenter
     *
     * @return Orkestra\Bundle\ReportBundle\IPresenter
     * @throws InvalidArgumentException if the supplied alias does not exist
     */
    public function getPresenter($alias)
    {
        if (empty($this->_presenters[$alias])) {
            throw new \InvalidArgumentException(sprintf('No presenter with the alias "%s" exists.', $alias));
        }

        return $this->_presenters[$alias];
    }

    /**
     * Gets all registered Presenters
     *
     * @return array Key is the alias; value is the instance
     */
    public function getPresenters()
    {
        return $this->_presenters;
    }

    /**
     * Registers a Report with the factory
     *
     * @param Orkestra\Bundle\ReportBundle\ReportInterface
     */
    public function addReport(ReportInterface $report)
    {
        $this->_reports[$report->getName()] = $report;
    }

    /**
     * Gets a registered Report
     *
     * @param string $alias The alias of the Report
     *
     * @return Orkestra\Bundle\ReportBundle\IReport
     * @throws InvalidArgumentException if the supplied alias does not exist
     */
    public function getReport($alias)
    {
        if (empty($this->_reports[$alias])) {
            throw new \InvalidArgumentException(sprintf('No report with the alias "%s" exists.', $alias));
        }

        return $this->_reports[$alias];
    }

    /**
     * Gets all registered Reports
     *
     * @return array Key is the alias; value is the instance
     */
    public function getReports()
    {
        return $this->_reports;
    }
}
