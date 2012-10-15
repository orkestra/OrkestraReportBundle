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
     * @var \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
     */
    protected $engine;

    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    /**
     * @var \Orkestra\Bundle\ReportBundle\ReportFactory
     */
    protected $reportFactory;

    /**
     * @var \Orkestra\Bundle\ReportBundle\PresenterInterface
     */
    protected $presenter;

    /**
     * @var \Orkestra\Bundle\ReportBundle\ReportInterface
     */
    protected $report;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $snapshots;

    /**
     * @var \Symfony\Component\Form\Form
     */
    protected $form;

    /**
     * @var array
     */
    protected $filters;

    /**
     * Constructor
     *
     * @param \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $engine
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param \Symfony\Component\Form\FormFactory $formFactory
     * @param \Orkestra\Bundle\ReportBundle\ReportFactory $reportFactory
     * @param \Orkestra\Bundle\ReportBundle\PresenterInterface $presenter
     * @param \Orkestra\Bundle\ReportBundle\ReportInterface $report
     * @param \Symfony\Component\HttpFoundation\Request $request Optional Request to bind the Presentation to
     *
     * @throws \RuntimeException
     */
    public function __construct(
        EngineInterface $engine,
        QueryBuilder $queryBuilder,
        FormFactory $formFactory,
        ReportFactory $reportFactory,
        PresenterInterface $presenter,
        ReportInterface $report,
        Request $request = null
    ) {
    	if (!$presenter->supports($report)) {
    		throw new \RuntimeException(sprintf('The report "%s" does not support the functionality required by the presenter "%s"', $report->getName(), $presenter->getName()));
    	}

        $this->engine = $engine;
        $this->queryBuilder = $queryBuilder;
        $this->formFactory = $formFactory;
        $this->reportFactory = $reportFactory;
        $this->presenter = $presenter;
        $this->report = $report;
        $this->filters = $presenter->getFilters();

        if ($request) {
            $this->bindRequest($request);
        }
    }

    /**
     * Gets the associated presenter
     *
     * @return \Orkestra\Bundle\ReportBundle\PresenterInterface
     */
    public function getPresenter()
    {
    	return $this->presenter;
    }

    /**
     * Gets the associated report
     *
     * @return \Orkestra\Bundle\ReportBundle\ReportInterface
     */
    public function getReport()
    {
    	return $this->report;
    }

    /**
     * Returns true if the Presentation has been bound to a Request
     *
     * @return boolean
     */
    public function isBound()
    {
        return empty($this->request) ? false : true;
    }

    /**
     * Binds the Presentation to a Request
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function bindRequest(Request $request)
    {
        $this->request = $request;

        $this->getForm()->bind($request);

        foreach ($this->filters as $filter) {
            /** @var \Orkestra\Bundle\ReportBundle\FilterInterface $filter */
            $filter->bindRequest($this->request);
        }
    }

    /**
     * Appends a filter to this Presentation
     *
     * TODO: Should this fail silently?
     *
     * @param \Orkestra\Bundle\ReportBundle\FilterInterface $filter
     */
    public function appendFilter(FilterInterface $filter)
    {
        if (!$this->isBound()) {
            array_push($this->filters, $filter);
        }
    }

    /**
     * Prepends a filter to this Presentation
     *
     * TODO: Should this fail silently?
     *
     * @param \Orkestra\Bundle\ReportBundle\FilterInterface $filter
     */
    public function prependFilter(FilterInterface $filter)
    {
        if (!$this->isBound()) {
            array_unshift($this->filters, $filter);
        }
    }

    /**
     * Renders the Presentation using the injected templating Engine
     *
     * @return string
     */
    public function render()
    {
        return $this->engine->render($this->presenter->getTemplate(), array('presentation' => $this));
    }

    /**
     * Gets the Form associated with this Presentation.
     *
     * If the Form does not yet exist, it will be created at the time of this method call
     *
     * @return \Symfony\Component\Form\Form
     */
    public function getForm()
    {
        if (!$this->form) {
            $this->form = $this->formFactory->create(new FilterFormType($this->presenter->getFilters()));
        }

        return $this->form;
    }

    /**
     * Gets the associated Snapshots after all filters have been applied.
     *
     * If the Snapshots have not yet been fetched, they will be at the time of this method call
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSnapshots()
    {
        if (!$this->snapshots) {
            $qb = $this->queryBuilder;
            $qb->select('s')
               ->from('Orkestra\Bundle\ReportBundle\Entity\Snapshot', 's')
               ->where('s.report = :report');
            $qb->setParameter('report', $this->report->getName());

            foreach ($this->filters as $filter) {
                /** @var \Orkestra\Bundle\ReportBundle\FilterInterface $filter */
                $filter->apply($qb);
            }

            $query = $qb->getQuery();

            $this->snapshots = $query->getResult();
        }

        return $this->snapshots;
    }

    /**
     * Gets the name of the associated report
     *
     * @return string
     */
    public function getName()
    {
        return $this->report->getName();
    }

    /**
     * Gets the name of the associated template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->presenter->getTemplate();
    }

    /**
     * Gets an array of facts from the associated report
     *
     * @return array
     */
    public function getFacts()
    {
        return $this->report->getFacts();
    }

    /**
     * Gets a pretty label for a fact from the associated report
     *
     * @param string $fact
     *
     * @return string
     */
    public function getLabel($fact)
    {
    	return $this->report->getLabel($fact);
    }
}
