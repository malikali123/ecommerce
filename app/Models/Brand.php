<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use Translatable;

    /*
   * the relation is eager load on evry query
   */

    protected $with = ['translations'];
    /*
     * the attribute that are mas assinable
     */

    protected $fillable = ['is_active','photo'];

    /*
       * the attribute that shuld be cast to native type
       */

    protected $casts = [
        'is_active' => 'boolean',
    ];


    /*
       * the attribute that translatable
       */

    protected $translatedAttributes = ['name'];

    public function getActive(){
        return $this -> is_active == 0 ? 'غير مفعل' : 'مفعل';
    }

    public  function getPhotoAttribute($val){
        return ($val !== null) ? asset('assets/images/brands/' . $val) : "";

    }
    public function scopeActive($query){
        return $query -> where ('is_active', 1);

    }


}
