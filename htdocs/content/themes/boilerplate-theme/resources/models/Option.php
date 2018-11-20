<?php

namespace Theme\Models;

use Illuminate\Database\Eloquent\Model;
use Theme\Models\Helpers\Helpers;

class Option extends Model{
    protected $table      = 'options';
    protected $primaryKey = 'option_id';
    public $timestamps    = false;

    public static function getValue ($key = '') {
        $value = '';

        if($key) {
            $value = self::where('option_name', '=', $key)->value('option_value');
        }

        if(Helpers::isSerialized($value)) {
            $value = unserialize($value);
        }

        return $value;
    }
}
