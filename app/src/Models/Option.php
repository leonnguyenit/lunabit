<?php

namespace Luna\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Option Model
 * Table: options
 * @author leonnguyenit
 */
class Option extends Model
{
    public $timestamps = false;

    /**
     * Get Module Config
     */
    public static function moduleConfig($module_name)
    {
        $module_config = Option::where('name', '_mod_' . $module_name)->first();
        return isset($module_config) ? unserialize($module_config->toArray()['value']) : [];
    }
}
