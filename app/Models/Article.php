<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * Get the category
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}
