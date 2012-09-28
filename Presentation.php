<?php

namespace Orkestra\Bundle\ReportBundle;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface,
    Symfony\Component\Form\FormFactory,
    Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\QueryBuilder;

use Orkestra\Bundle\ReportBundle\Form\FilterFormType;

/**
 * Represents a compiled report, ready for rendering to the client
 */
class Presentation
{
    /**
     * @var Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
     */
    protected $_engine;

    /**
     * @var Doctrine\ORM\QueryBuilder
     */
    protected $_queryBuilder;

    /**
     * @var Symfony\Component\Form\FormFactory
     */
    protected $_formFactory;

    /**
     * @var Orkestra\Bundle\ReportBundle\ReportFactory
     */
    protected $_reportFactory;

    /**
     * @var Orkestra\Bundle\ReportBundle\IPresenter
     */
    protected $_presenter;

    /**
     * @var Orkestra\Bundle\ReportBundle\IReport
     */
    protected $_report;

    /**
     * @var Symfony\Component\HttpFoundation\Request
     */
    protected $_request;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     */
    protected $_snapshots;

    /**
     * @var Symfony\Component\Form\Form
     */
    protected $_form;

    /**
     * Constructor
     *
     * @param Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $engine
     * @param Doctrine\ORM\QueryBuilder $queryBuilder
     * @param Symfony\Component\Form\FormFactory $formFactory
     * @param Orkestra\Bundle\ReportBundle\ReportFactory $reportFactory
     * @param Orkestra\Bundle\ReportBundle\IPresenter $presenter
     * @param Orkestra\Bundle\ReportBundle\IReport $report
     * @param Symfony\Component\HttpFoundation\Request $request Optional Request to bind the Presentation to
     */
    public function __construct(EngineInterface $engine, QueryBuilder $queryBuilder, FormFactory $formFactory, ReportFactory $reportFactory, PresenterInterface $presenter, ReportInterface $report, Request $request = null)
    {
    	if (!$presenter->supports($report)) {
    		throw new \RuntimeException(sprintf('The report "%s" does not support the functionality required by the presenter "%s"', $report->getName(), $presenter->getName()));
    	}

        $this->_engine = $engine;
        $this->_queryBuilder = $queryBuilder;
        $this->_formFactory = $formFactory;
        $this->_reportFactory = $reportFactory;
        $this->_presenter = $presenter;
        $this->_report = $report;

        if ($request) {
            $this->bindRequest($request);
        }
    }

    /**
     * Gets the associated presenter
     *
     * @return Orkestra\Bundle\ReportBundle\IPresenter
     */
    public function getPresenter()
    {
    	return $this->_presenter;
    }

    /**
     * Gets the associated report
     *
     * @return Orkestra\Bundle\ReportBundle\IReport
     */
    public function getReport()
    {
    	return $this->_report;
    }

    /**
     * Returns true if the Presentation has been bound to a Request
     *
     * @return boolean
     */
    public function isBound()
    {
        return empty($this->_request) ? false : true;
    }

    /**
     * Binds the Presentation to a Request
     *
     * @param Symfony\Component\HttpFoundation\Request $request
     */
    public function bindRequest(Request $request)
    {
        $this->_request = $request;

        $this->getForm()->bindRequest($request);

        foreach ($this->_presenter->getFilters() as $filter) {
            $filter->bindRequest($this->_request);
        }
    }

    /**
     * Renders the Presentation using the injected templating Engine
     *
     * @return string
     */
    public function render()
    {
        return $this->_engine->render($this->_presenter->getTemplate(), array('presentation' => $this));
    }

    /**
     * Gets the Form associated with this Presentation.
     *
     * If the Form does not yet exist, it will be created at the time of this method call
     *
     * @return Symfony\Component\Form\Form
     */
    public function getForm()
    {
        if (!$this->_form) {
            $this->_form = $this->_formFactory->create(new FilterFormType($this->_presenter->getFilters()));
        }

        return $this->_form;
    }

    /**
     * Gets the associated Snapshots after all filters have been applied.
     *
     * If the Snapshots have not yet been fetched, they will be at the time of this method call
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getSnapshots()
    {
        if (!$this->_snapshots) {
            $qb = $this->_queryBuilder;
            $qb->select('s')
               ->from('Orkestra\Bundle\ReportBundle\Entity\Snapshot', 's')
               ->where('s.report = :report');
            $qb->setParameter('report', $this->_report->getName());

            foreach ($this->_presenter->getFilters() as $filter) {
                $filter->apply($qb);
            }

            $query = $qb->getQuery();

            $this->_snapshots = $query->getResult();
        }

        return $this->_snapshots;
    }

    /**
     * Gets the name of the associated report
     *
     * @return string
     */
    public function getName()
    {
        return $this->_report->getName();
    }

    /**
     * Gets the name of the associated template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->_presenter->getTemplate();
    }

    /**
     * Gets an array of facts from the associated report
     *
     * @return array
     */
    public function getFacts()
    {
        return $this->_report->getFacts();
    }

    /**
     * Gets a pretty label for a fact from the associated report
     *
     * @return string
     */
    public function getLabel($fact)
    {
    	return $this->_report->getLabel($fact);
    }
}
