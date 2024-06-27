<?php

declare(strict_types=1);

namespace ShowProject\Bookshelf\Resources;

use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use ShowProject\Bookshelf\Models\Bookshelf;

class BookshelfResource extends Resource
{
    /**
     * @var string
     */
    public static $model = Bookshelf::class;

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('row')
                ->title('Row')
                ->placeholder('Enter row here'),
            Input::make('col')
                ->title('Column')
                ->placeholder('Enter column here'),
        ];
    }

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('row', 'Row'),
            TD::make('col', 'Column'),
            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),
            TD::make('updated_at', 'Update date')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                }),
        ];
    }

    /**
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('row', 'Row'),
            Sight::make('col', 'Column'),
        ];
    }

    /**
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

}
