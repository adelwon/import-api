<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @property integer $id
 * @property string $type
 * @property string $description
 * @property int $region_description
 * @property bool $area_description
 * @property string $index
 * @method static Builder|Settlement newModelQuery()
 * @method static Builder|Settlement newQuery()
 * @method static Builder|Settlement query()
 **/
class Settlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type',
        'description',
        'region_description',
        'area_description',
        'index'
    ];
}
