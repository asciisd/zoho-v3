<?php

namespace Asciisd\Zoho\Concerns;

use Asciisd\Zoho\ZohoManager;

trait CriteriaBuilder
{
    protected string $criteria = '';
    protected ZohoManager $module;
    protected array $operators = ['equals', 'starts_with'];
    protected int $page = 1;
    protected int $perPage = 200;

    /**
     * add criteria to the search
     *
     * @param $field
     * @param $value
     * @param  string  $operator
     *
     * @return CriteriaBuilder
     */
    public function where($field, $value, string $operator = 'equals'): static
    {
        $builder = new static();

        $builder->criteria = static::queryBuilder($field, $operator, $value);

        return $builder;
    }

    private static function queryBuilder(...$args): string
    {
        return "($args[0]:$args[1]:$args[2])";
    }

    public function startsWith($field, $value, $operator = 'starts_with'): static
    {
        $this->criteria .= ' and '.$this->queryBuilder($field, $operator, $value);

        return $this;
    }

    public function andWhere($field, $value, $operator = 'equals'): static
    {
        $this->criteria .= ' and '.$this->queryBuilder($field, $operator, $value);

        return $this;
    }

    public function orWhere($field, $value, $operator = 'equals'): static
    {
        $this->criteria .= ' or '.$this->queryBuilder($field, $operator, $value);

        return $this;
    }

    public function toString(): string
    {
        return $this->getCriteria() ?? '';
    }

    public function getCriteria(): string
    {
        return $this->criteria;
    }

    public function page($page): static
    {
        $this->page = $page;

        return $this;
    }

    public function perPage($per_page): static
    {
        $this->perPage = $per_page;

        return $this;
    }

    public function get(): array
    {
        return $this->searchRecordsByCriteria($this->getCriteria())[0];
    }

    public function search(): array
    {
        return $this->get();
    }
}
