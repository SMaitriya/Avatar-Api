<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SvgElement extends Model
{
    protected $table = 'svg_elements';

    protected $primaryKey = 'id_svg';

    public $timestamps = false;

    protected $fillable = [
        'element_type',
        'element_name',
        'svg_content',
    ];
}
