<?php

namespace Orkestra\Bundle\ReportBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormTypeInterface,
    Symfony\Component\Form\FormBuilderInterface;

/**
 * Type designed for use with a collection of filters.
 *
 * This Type is used internally by a Presentation.
 */
class FilterFormType extends AbstractType
{
    /**
     * @var array
     */
    protected $_filters;

    /**
     * Constructor
     *
     * @param array $filters
     */
    public function __construct(array $filters)
    {
        $this->_filters = $filters;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($this->_filters as $filter) {
            $filter->buildForm($builder);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'orkestra_report_filter';
    }
}
