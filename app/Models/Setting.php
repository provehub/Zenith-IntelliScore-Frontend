<?php

/**
 * Setting Model
 *
 *  Manage the Web Settings
 *
 * @package Zenith IntelliScore
 * @author Team Zenith IntelliScore
 * @version 1.0.0
 */

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    const SITE_NAME = "site_name", SITE_EMAIL = "site_email";

    protected $fillable = ['field', 'value'];

    public static function getValue($name, $add = false)
    {
        $result = Cache::remember('prove_settings', 30, function () use ($name) {
            return self::all()->pluck('value', 'field');
        });

        if (isset($result[$name])) {
            return $result[$name];
        } else {
            if ($add == true) {
                self::create([$name => 'null']);
            }
            return "";
        }
    }

    public static function updateValue($field, $value)
    {
        $setting = self::where('field', $field)->first();
        if ($setting == null) {
            $setting = new self();
            $setting->field = $field;
        }
        $setting->value = $value;
        if ($setting->save()) {
            Cache::forget('prove_settings');
            return $setting->only(['field', 'value']);
        } else {
            return false;
        }
    }
}
