<?php

namespace Afup\Barometre\Filter;

use Afup\Barometre\Form\Type\Select2MultipleFilterType;
use Afup\BarometreBundle\Enums\StatusEnums;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\Form\FormBuilderInterface;

class StatusFilter implements FilterInterface
{
    /**
     * @var StatusEnums
     */
    private $status;

    /**
     * @param StatusEnums $status
     */
    public function __construct(StatusEnums $status)
    {
        $this->status = $status;
    }

    /**
     * Add specific filter for this filter
     *
     * @param FormBuilderInterface $builder
     */
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder->add($this->getName(), new Select2MultipleFilterType(), [
            'label'   => 'filter.status',
            'choices' => $this->status->getChoices(),
        ]);
    }

    /**
     * Build the query with active filters
     *
     * @param QueryBuilder $queryBuilder
     * @param array        $values
     */
    public function buildQuery(QueryBuilder $queryBuilder, array $values = array())
    {
        if (!array_key_exists($this->getName(), $values) || 0 === count($values[$this->getName()])) {
            return;
        }

        $queryBuilder->andWhere($queryBuilder->expr()->in('response.status', $values[$this->getName()]));
    }

    /**
     * The filter name
     *
     * @return string
     */
    public function getName()
    {
        return 'status';
    }
}
