<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model (optional).
     * I always like to define the table name even though Laravel can correspond to correct table
     * automatically if the table name is snake case plural of model class name convention
     * @var string
     */
    protected $table = 'authors';
    protected $fillable = ['name'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}
