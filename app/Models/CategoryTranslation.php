<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    /*
    * the attribute that are mas assinable
    */
    protected $fillable = ['name'];
    public $timestamps = false;

}
