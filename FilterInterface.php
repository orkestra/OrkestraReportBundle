<?php

namespace Orkestra\Bundle\ReportBundle;

use Doctrine\ORM\QueryBuilder;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Form\FormBuilder;

/**
 * Defines the contract all Filters must follow
 */
interface FilterInterface
{
    /**
     * Apply the current state of the filter to the given QueryBuilder instance
     *
     * @param \Doctrine\ORM\QueryBuilder $qb
     *
     * @return void
     */
    function apply(QueryBuilder $qb);

    /**
     * Binds the given request to the filter
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    function bindRequest(Request $request);

    /**
     * Allows the filter to add form elements to the report's filter form
     *
     * @param \Symfony\Component\Form\FormBuilder $builder
     *
     * @return void
     */
    function buildForm(FormBuilder $builder);
}
