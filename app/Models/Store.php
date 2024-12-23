<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    // Đặt tên bảng (nếu khác mặc định là 'stores')
    protected $table = 'stores';

    // Cột nào được phép gán giá trị hàng loạt (mass assignable)
    protected $fillable = [
        'name',       // Tên cửa hàng
        'address',    // Địa chỉ cửa hàng
        'code',       // Mã định danh cửa hàng
    ];

    // Quan hệ với người dùng (mỗi cửa hàng có thể có nhiều người dùng)
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Quan hệ với sản phẩm (cửa hàng có nhiều sản phẩm)
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Quan hệ với các đơn hàng (cửa hàng có nhiều đơn hàng)
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
