<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable =[
        "name", "code", "type", "slug", "barcode_symbology", "brand_id", "category_id", "unit_id", "purchase_unit_id", "sale_unit_id", "cost", "price", "wholesale_price", "qty", "alert_quantity", "daily_sale_objective", "promotion", "promotion_price", "starting_date", "last_date", "tax_id", "tax_method", "image", "file", "is_embeded", "is_batch", "is_variant", "is_diffPrice", "is_imei", "featured", "product_list", "variant_list", "qty_list", "price_list", "product_details", "short_description", "specification", "related_products", "variant_option", "variant_value", "is_active", "is_online", "in_stock", "track_inventory", "is_sync_disable", "woocommerce_product_id","woocommerce_media_id","tags","meta_title","meta_description","store_id"
    ];

    public function category()
    {
    	return $this->belongsTo('App\Models\Category');
    }

    public function brand()
    {
    	return $this->belongsTo('App\Models\Brand');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit');
    }

    public function variant()
    {
        return $this->belongsToMany('App\Models\Variant', 'product_variants')->withPivot('id', 'item_code', 'additional_cost', 'additional_price');
    }

    public function scopeActiveStandard($query)
    {
        return $query->where([
            ['is_active', true],
            ['type', 'standard']
        ]);
    }

    public function scopeActiveFeatured($query)
    {
        return $query->where([
            ['is_active', true],
            ['featured', 1]
        ]);
    }

    protected static function booted()
    {
        static::addGlobalScope('createdByAuthUser', function ($query) {
            $query->createdByAuthUser();
        });
    }

    public function scopeCreatedByAuthUser($query)
    {
        return $query->when(auth()->check() && auth()->user()->role_id !== 1, function ($q) {
            $q->whereHas('userProducts', function ($qq) {
                $qq->where('user_id', auth()->id());
            });
        });
    }



    // Mối quan hệ với Store
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function userProducts()
    {
        return $this->hasMany(UserProduct::class);
    }
}
