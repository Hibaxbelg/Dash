<?php

namespace App\Services;

use Illuminate\Contracts\Database\Eloquent\Builder;

class DataTableService
{
    public array $columns = [];

    static function makeSearchableBuilder(Builder $query, array $columns): Builder
    {
        foreach ($columns as $column) {
            $column_name = $column['data'];
            $column_search = $column['search']['value'];
            // $column_order = $column['orderable'];
            // $column_searchable = $column['searchable'];
            if ($column_search != '') {
                $query = $query->where($column_name, 'like', '%' . $column_search . '%');
            }
        }
        return $query;
    }

    public function addColumn(String $name, array $options = []): void
    {
        $this->columns[] = [
            'id' => count($this->columns),
            'name' => $name,
            'data' => $options['data'] ?? $name,
            'type' => $options['type'] ?? 'text',
            'values' => $options['values'] ?? [],
            'searchable' => $options['searchable'] ?? true,
        ];
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getSearcheableColumns(): array
    {
        return array_filter($this->columns, function ($column) {
            return $column['searchable'];
        });
    }

    public function getSearchFields()
    {
        return view('services.datatable.search-fields', ['datatable' => $this]);
    }
}
