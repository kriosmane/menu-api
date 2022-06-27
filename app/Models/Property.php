<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Xml(name="Property"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", example="example"),
 * )
 *
 * Class Property
 */
class Property extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'item_id'];

    public function item()
    {
        return $this->belongsTo(\App\Models\Item::class);
    }
}
