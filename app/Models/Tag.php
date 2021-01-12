<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Translatable;

    /*
   * the relation is eager load on evry query
   */

    protected $with = ['translations'];
    /*
     * the attribute that are mas assinable
     */
    protected $translatedAttributes = ['name'];

    protected $fillable = ['slug'];


}
