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

//    public static function create(array $except)
//    {
//    }

    public function scopeParent($query){
        return $query -> whereNull('parent_id');
    }
    public function scopeChild($query){
        return $query -> whereNotNull('parent_id');
    }
    public function getActive(){
          return $this -> is_active == 0 ? 'غير مفعل' : 'مفعل';
    }
    public function _parent(){
        return $this->belongsTo(self::class,'parent_id');
    }
}
