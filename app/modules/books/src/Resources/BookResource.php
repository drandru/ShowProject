<?php

declare(strict_types=1);

namespace ShowProject\Books\Resources;

use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use ShowProject\Authors\Models\Author;
use ShowProject\Books\Models\Book;
use ShowProject\Bookshelf\Models\Bookshelf;
use Orchid\Screen\Field;
use Illuminate\Contracts\Container\BindingResolutionException;

class BookResource extends Resource
{
    /**
     * @var string
     */
    public static $model = Book::class;

    /**
     * @return array|Field[]
     * @throws BindingResolutionException
     */
    public function fields(): array
    {
        return [
            Input::make('title')
                ->title('Title')
                ->placeholder('Enter name here'),
            DateTimer::make('publication_date')
                ->title('Publication date')
                ->placeholder('Enter publication date here'),
            Select::make('authors.')
                ->fromModel(Author::class, 'name')
                ->multiple()
                ->title('Choose author'),
            Select::make('genre')
                ->options([
                    'fantasy' => 'Fantasy',
                    'thriller' => 'Thriller',
                    'novel' => 'Novel',
                ])
                ->title('Genre')
                ->placeholder('Enter genre here'),
            Relation::make('bookshelf_id')
                ->fromModel(Bookshelf::class, 'id')
                ->title('Choose bookshelf'),
            TextArea::make('text')
                ->title('Text')
                ->placeholder('Enter text here'),
        ];
    }

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('title', 'Title'),
            TD::make('publication_date', 'Publication date'),
            TD::make('genre', 'Genre'),
            TD::make('authors', 'Author')
                ->render(function (Book $book) {
                    return $book->authors()->pluck('name')->join(', ');
            }),
            TD::make('bookshelf_id', 'Bookshelf')
                ->render(function ($model) {
                    return $model->bookshelf->title();
                }),
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
            Sight::make('title', 'Title'),
            Sight::make('authors', 'Authors')->render(function (Book $book) {
                return $book->authors()->pluck('name')->join(', ');
            }),
            Sight::make('publication_date', 'Publication date'),
            Sight::make('genre', 'Genre'),
            Sight::make('text', 'text'),
        ];
    }

    /**
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

    /**
     * @param ResourceRequest $request
     * @param Model $model
     * @return void
     */
    public function save(ResourceRequest $request, Model $model): void
    {
        $authors = $request->get('authors', []);
        $request->request->remove('authors');
        parent::save($request, $model);
        $model->authors()->sync($authors);
    }
}
