<?php

namespace App\Services;

use Illuminate\Contracts\Database\Eloquent\Builder;

class DataTableService
{
    public array $columns = [];

    public function __construct(array $columns)
    {
        foreach ($columns as $column) {
            $this->addColumn($column);
        }
    }

    public function addColumn(array $options = []): void
    {
        if (!isset($options['name'])) throw new \Exception('Column name is required');

        $this->columns[] = [
            'id' => count($this->columns),
            'name' => $options['name'],
            'data' => $options['data'] ?? $options['name'],
            'type' => $options['type'] ?? 'text',
            'values' => $options['values'] ?? [],
            'searchable' => $options['searchable'] ?? true,
        ];
    }

    public function getColumns($json = false): array
    {
        if ($json) {
            return collect($this->columns)->map(fn ($item) => collect($item)->only('data'))->toArray();
        }
        return $this->columns;
    }

    public function buildSearchInputs()
    {
        return view('services.datatable.search-fields', ['datatable' => $this]);
    }

    public function drawTable()
    {
        return view('services.datatable.table', ['datatable' => $this]);
    }
}
