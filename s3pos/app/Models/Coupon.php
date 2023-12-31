<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';

    protected $fillable = [
        'store_id',
        'code',
        'name',
        'start',
        'end',
        'value',
        'type_value',
        'status',
        'usage',
    ];

    protected $hidden = [];

    protected $casts = [
        'store_id' => 'integer',
        'value' => 'integer',
        'start' => 'date:Y-m-d',
        'end' => 'date:Y-m-d',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->status = $model->status ?? self::STATUS_BLOCKED;
            $model->code = $model->code ?? generateRandomString();
            $model->value = $model->value ?? 0;
            $model->type_value = $model->type_value ?? self::TYPE_PERCENT;
            $model->quantity = $model->quantity ?? 1;
        });
        self::created(function ($model) {
            save_log_action("Tạo mới phiếu mua hàng #$model->code");
        });
        self::updated(function ($model) {
            save_log_action("Cập nhật thông tin phiếu mua hàng #$model->name");
        });
        self::deleted(function ($model) {
            save_log_action("Xóa phiếu mua hàng #$model->name");
        });
    }

    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCKED = 'blocked';

    public static function get_status($status = '')
    {
        $types = [
            self::STATUS_ACTIVE => ['Chưa sử dụng', 'success', COLOR_SUCCESS],
            self::STATUS_BLOCKED => ['Đã sử dụng', 'danger', COLOR_DANGER],
        ];
        return $status == '' ? $types : $types["$status"];
    }

    const TYPE_VND = 'vnd';
    const TYPE_PERCENT = 'percent';

    public static function get_type($type = '')
    {
        $types = [
            self::TYPE_VND => ['VND', 'secondary', COLOR_SECONDARY],
            self::TYPE_PERCENT => ['%', 'success', COLOR_SUCCESS],
        ];
        return $type == '' ? $types : $types["$type"];
    }

    public function scopeOfCode($query, $code)
    {
        return $query->where('coupons.code', $code);
    }

    public function scopeOfStatus($query, $status)
    {
        return $query->where('coupons.usage', $status);
    }

    public function scopeStoreId($query, $store_id)
    {
        return $query->where('coupons.store_id', $store_id);
    }

    public function scopeExpired($query)
    {
        return $query->where('coupons.end', '<=', now());
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}