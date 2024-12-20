<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'alert_stock',
        'status',
        'item_code',
        'image',
        'category_id',
        'brand_id',
        'unit_id',
        'company_id',
        'warehouse_id',
    ];

    protected $casts = [
        'id' => 'integer',
        //'price' => 'float', // jika Anda ingin harga sebagai float
        'price' => 'integer',
        'stock' => 'integer',
        'alert_stock' => 'integer',
        'category_id' => 'integer',
        'brand_id' => 'integer',
        'unit_id' => 'integer',
        'company_id' => 'integer',
        'warehouse_id' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function warehouseStock()
    {
        return $this->hasMany(WarehouseStock::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
