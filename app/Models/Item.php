<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Xml(name="Item"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", example="Pizza"),
 * @OA\Property(property="description", type="string", example="description"),
 * @OA\Property(property="properties", type="array", @OA\Items(ref="#/components/schemas/Property"))
 * )
 *
 * Class Item
 */
class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function properties()
    {
        return $this->hasMany(\App\Models\Property::class);
    }
}
