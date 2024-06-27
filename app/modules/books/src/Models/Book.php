<?php

declare(strict_types=1);

namespace ShowProject\Books\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use ShowProject\Authors\Models\Author;
use ShowProject\Bookshelf\Models\Bookshelf;

class Book extends Model
{
    use AsSource
        , Filterable
        , Attachable
        , HasFactory
        , SoftDeletes
    ;

    /**
     * @return BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'author_book');
    }

    /**
     * @return BelongsTo
     */
    public function bookshelf(): BelongsTo
    {
        return $this->belongsTo(Bookshelf::class, 'bookshelf_id');
    }
}
