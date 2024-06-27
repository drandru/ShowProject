<?php

declare(strict_types=1);

namespace ShowProject\Authors\Resources;

use Orchid\Crud\Resource;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use ShowProject\Authors\Models\Author;

class AuthorResource extends Resource
{
    /**
     * @var string
     */
    public static $model = Author::class;

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('name')
                ->title('Name')
                ->placeholder('Enter name here'),
            Input::make('surname')
                ->title('Surname')
                ->placeholder('Enter surname here'),
            DateTimer::make('birthdate')
                ->title('Birthdate')
                ->placeholder('Enter birthdate here'),
            DateTimer::make('deathdate')
                ->title('Date of death')
                ->placeholder('Enter date of death here'),
            Select::make('country')
                ->options([
                    'ru' => 'Russia',
                    'by' => 'Belarus',
                ])
                ->title('Country')
                ->placeholder('Enter country here'),
        ];
    }

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('name', 'Name'),
            TD::make('surname', 'Surname'),
            TD::make('birthdate', 'Birthdate')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),
            TD::make('deathdate', 'Date of death')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),
            TD::make('country', 'Country'),
        ];
    }

    /**
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('name'),
            Sight::make('surname'),
            Sight::make('birthdate'),
            Sight::make('deathdate'),
            Sight::make('country'),
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
