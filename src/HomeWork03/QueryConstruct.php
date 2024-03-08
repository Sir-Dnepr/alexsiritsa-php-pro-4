<?php
declare(strict_types=1);

namespace App\HomeWork03;

class QueryConstruct
{
    public function __construct(
        protected array $select,
        protected string $from,
        protected array $where,
    ) {
    }

    public function getQuery(): array
    {
        return ['select' => $this->select, 'from' => $this->from, 'where' => $this->where];
    }

    public function __toString(): string
    {
        $query = 'SELECT ' . implode(',', $this->select);
        $query .= ' FROM ' . $this->from;
        $query .= ' WHERE ';
        $whereConditions = [];

        foreach ($this->where as $where) {
            $whereConditions[] = implode(' ', $where);
        }

        $query .= implode(' AND ', $whereConditions);

        return $query;
    }
}
