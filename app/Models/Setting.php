<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Translatable;
    /*
     * the relation is eager load on evry query
     */
    protected $with = ['translations'];
    protected $translatedAttributes = ['value'];
    /*
     * the attribute that are mas assinable
     */
    protected $fillable = ['key', 'is_translatable', 'plain_value'];
    /*
     * the attribute that shuld be cast to native type
     */
    protected $casts = [
        'is_translatable' => 'boolean',
    ];
    /*
     * set the given setting
     * array setting
     */
    public static function setMany($settings){
        foreach ($settings as $key => $value){
            self::set($key, $value);
        }
    }

    /*
     * set the given setting
     * string => key
     * mixed => value
     * return void
     */
    public static function set($key, $value){
        if ($key ==='translatable'){
            return static::setTranslatableSettings($value);
        }
        if (is_array($value)){
            $value = json_encode($value);
        }
        static::updateOrCreate(['key' => $key], ['plain_value' => $value]);
    }
    /*
     * set atranslatable setting
     * array settings
     * return void
     */
    public static function setTranslatableSettings($settings = []){
        foreach ($settings as $key => $value){
            static::updateOrCreate(['key' => $key],
                ['is_translatable' => true,
                    'value' => $value,
                    ]);
        }

    }

}
