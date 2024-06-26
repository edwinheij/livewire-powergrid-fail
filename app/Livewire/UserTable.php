<?php

namespace App\Livewire;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class UserTable extends PowerGridComponent
{
    public function datasource(): ?Collection
    {
        return collect([
            ['id' => 1, 'name' => 'Name 1', 'price' => 1.58, 'created_at' => now(), 'actual' => 1, 'actual2' => 1, 'relation' => ['actual' => 1, 'actual2' => 1]],
            ['id' => 2, 'name' => 'Name 2', 'price' => 1.68, 'created_at' => now(), 'actual' => 1, 'actual2' => 1, 'relation' => ['actual' => 1, 'actual2' => 1]],
            ['id' => 3, 'name' => 'Name 3', 'price' => 1.78, 'created_at' => now(), 'actual' => 1, 'actual2' => 1, 'relation' => ['actual' => 1, 'actual2' => 1]],
            ['id' => 4, 'name' => 'Name 4', 'price' => 1.88, 'created_at' => now(), 'actual' => 0, 'actual2' => 0, 'relation' => ['actual' => 0, 'actual2' => 0]],
            ['id' => 5, 'name' => 'Name 5', 'price' => 1.98, 'created_at' => now(), 'actual' => 0, 'actual2' => 0, 'relation' => ['actual' => 0, 'actual2' => 0]],
        ]);
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('price')
            ->addColumn('actual')
            ->addColumn('actual2')
            ->addColumn('relation.actual')
            ->addColumn('relation.actual2')
            ->addColumn('created_at_formatted', function ($entry) {
                return Carbon::parse($entry->created_at)->format('d/m/Y');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Name', 'name')
                ->searchable()
                ->sortable(),

            Column::make('Price', 'price')
                ->searchable()
                ->sortable(),

            Column::make('Actual', 'actual'),
            Column::make('Actual2', 'actual2'),
            Column::make('Relation Actual', 'relation.actual'),
            Column::make('Relation Actual2', 'relation.actual2'),

            Column::make('Created', 'created_at_formatted'),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name'),
            Filter::inputText('price'),
            Filter::enumSelect('actual', 'actual')
                ->dataSource(\App\Support\Enums\YesNo::cases())
                ->optionLabel('actual'),
            Filter::enumSelect('actual2', 'actual2')
                ->dataSource(\App\Support\Enums\YesNo::cases())
                ->optionLabel('actual2'),
            Filter::enumSelect('relation.actual', 'relation.actual')
                ->dataSource(\App\Support\Enums\YesNo::cases())
                ->optionLabel('relation.actual'),
            Filter::enumSelect('relation.actual2', 'relation.actual2')
                ->dataSource(\App\Support\Enums\YesNo::cases())
                ->optionLabel('relation.actual2'),
        ];
    }
}
