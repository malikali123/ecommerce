<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    /*
   * the relation is eager load on evry query
   */
    protected $with = ['translations'];
    protected $translatedAttributes = ['name'];
    /*
     * the attribute that are mas assinable
     */
    protected $fillable = ['parent_id', 'slug', 'is_active'];
    /*
    * the attribute that should be hidden for serelizations
     * @var array
    */
    protected $hidden = ['translations'];

    /*
       * the attribute that shuld be cast to native type
       */
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
