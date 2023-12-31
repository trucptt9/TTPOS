<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Table extends Model
{
    use HasFactory;
    protected $table = 'tables';

    protected $fillable = [
        'area_id',
        'store_id',
        'code',
        'name',
        'status',
        'seat',
        'order_id',
        'booking_id'
    ];

    protected $hidden = [];

    protected $casts = [
        'area_id' => 'integer',
        'order_id' => 'integer',
        'seat' => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->status = $model->status ?? self::STATUS_ACTIVE;
            $model->code = $model->code ?? generateRandomString();
            $model->seat = $model->seat ?? 1;
        });
        self::created(function ($model) {
            Cache::forget('sale-table');
            save_log_action("Tạo mới bàn #$model->name");
        });
        self::updated(function ($model) {
            Cache::forget('sale-table');
            save_log_action("Cập nhật thông tin bàn #$model->name");
        });
        self::deleted(function ($model) {
            Cache::forget('sale-table');
            save_log_action("Xóa bàn #$model->name");
        });
    }

    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCKED = 'blocked';

    const STATUS_ORDER_ACTIVE = 'active';
    const STATUS_ORDER_UN_ACTIVE = 'un_active';
    public static function get_status($status = '')
    {
        $types = [
            self::STATUS_ACTIVE => ['Đang kích hoạt', 'success', COLOR_SUCCESS],
            self::STATUS_BLOCKED => ['Tạm ngưng', 'danger', COLOR_DANGER],
        ];
        return $status == '' ? $types : $types["$status"];
    }

    public function scopeOfCode($query, $code)
    {
        return $query->where('tables.code', $code);
    }

    public function scopeOfStatus($query, $status)
    {
        return $query->where('tables.status', $status);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('tables.code', 'LIKE', "%$search%")
                ->orWhere('tables.name', 'LIKE', "%$search%");
        });
    }

    public function scopeStoreId($query, $store_id)
    {
        if (is_array($store_id)) {
            return $query->whereIn('tables.store_id', $store_id);
        }
        return $query->where('tables.store_id', $store_id);
    }

    public function scopeAreaId($query, $area_id)
    {
        if (is_array($area_id)) {
            return $query->whereIn('tables.area_id', $area_id);
        }
        return $query->where('tables.area_id', $area_id);
    }

    public function scopeOrderId($query, $order_id)
    {
        return $query->where('tables.order_id', $order_id);
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
    public function booking()
    {
        return $this->hasOne(Booking::class, 'id', 'booking_id');
    }
}
