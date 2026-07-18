<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\Category\Database\Factories\CategoryFactory;

#[Fillable(['title', 'slug'])]
class Category extends Model
{
    use SoftDeletes;
}
