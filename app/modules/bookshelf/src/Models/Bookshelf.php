<?php

declare(strict_types=1);

namespace ShowProject\Bookshelf\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use ShowProject\Books\Models\Book;

class Bookshelf extends Model
{
    use AsSource
        , Filterable
        , Attachable
        , HasFactory
        , SoftDeletes
    ;

    /**
     * @return HasMany
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return strtr('$row - $col', [
                '$row' => $this->row,
                '$col' => $this->col,
            ]
        );
    }
}
