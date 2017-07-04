<?php
/**
 * Created by PhpStorm.
 * User: Levi
 * Date: 2017/7/4
 * Time: 15:09
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Test extends Model
{

    protected $table='test';

    /**
     * 不可被批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];
}