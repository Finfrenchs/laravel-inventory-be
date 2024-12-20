<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'name', 'phone', 'address', 'description', 'slug', 'email', 'contact_person',];

    public function products()
    {
        return $this->hasManyThrough(Product::class, WarehouseStock::class, 'warehouse_id', 'id', 'id', 'product_id');
    }
}
