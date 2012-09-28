<?php

namespace Orkestra\Bundle\ReportBundle\Filter;

use Doctrine\ORM\QueryBuilder;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Form\FormBuilder;

use Orkestra\Bundle\ReportBundle\FilterInterface;

/**
 * A simple Filter that allows a callback to modify the QueryBuilder
 */
class CallbackFilter implements FilterInterface
{
    /**
     * @var callable
     */
    protected $_callback;

    /**
     * Constructor
     *
     * @param callable $callback
     */
    public function __construct($callback)
    {
        $this->_callback = $callback;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(QueryBuilder $qb)
    {
        call_user_func($this->_callback, $qb);
    }

    /**
     * {@inheritdoc}
     */
    public function bindRequest(Request $request)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $form)
    {
    }
}
