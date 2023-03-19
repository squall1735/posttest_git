<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'posttest.news';

    protected $fillable = [
        'header',
        'preview_picture',
        'detail',
        'category_id',
        'start_date',
        'end_date',
        'is_draft',
        'is_enabled'
    ];
    public $timestamps = false;

    public function categories()
    {
        return $this->belongsTo('App\Models\categories', 'category_id', 'id');
    }
}
