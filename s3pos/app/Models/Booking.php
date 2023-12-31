<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';

    protected $fillable = [
        'store_id',
        'table_id',
        'customer_id',
        'code',
        'name',
        'phone',
        'note',
        'date_start',
        'status',
        'items'
    ];

    protected $hidden = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'store_id' => 'integer',
        'table_id' => 'integer',
        'customer_id' => 'integer',
        'date_start' => 'datetime:Y-m-d H:i:s',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->status = $model->status ?? self::STATUS_TMP;
            $model->code = $model->code ?? generateRandomString();
            $model->date_start = $model->date_start = now();
        });
        self::created(function ($model) {
            save_log_action("Booking vừa mới được tạo #$model->code");
        });
        self::updated(function ($model) {
            save_log_action("Cập nhật thông tin booking #$model->code");
        });
        self::deleted(function ($model) {
            save_log_action("Xóa booking #$model->code");
        });
    }

    const STATUS_TMP = 'tmp';
    const STATUS_FINISH = 'finish';
    const STATUS_DESTROY = 'destroy';

    public static function get_status($status = '')
    {
        $types = [
            self::STATUS_TMP => ['Chưa xác nhận', 'secondary', COLOR_SECONDARY],
            self::STATUS_FINISH => ['Đã xác nhận', 'success', COLOR_SUCCESS],
            self::STATUS_DESTROY => ['Đã hủy', 'danger', COLOR_DANGER],
        ];
        return $status == '' ? $types : $types["$status"];
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function scopeOfCode($query, $code)
    {
        return $query->where('bookings.code', $code);
    }

    public function scopeOfStatus($query, $status)
    {
        if (is_array($status)) {
            return $query->whereIn('bookings.status', $status);
        }
        return $query->where('bookings.status', $status);
    }

    public function scopeStoreId($query, $store_id)
    {
        if (is_array($store_id)) {
            return $query->whereIn('bookings.store_id', $store_id);
        }
        return $query->where('bookings.store_id', $store_id);
    }

    public function scopeTableId($query, $table_id)
    {
        if (is_array($table_id)) {
            return $query->whereIn('bookings.table_id', $table_id);
        }
        return $query->where('bookings.table_id', $table_id);
    }

    public function scopeCustomerId($query, $customer_id)
    {
        if (is_array($customer_id)) {
            return $query->whereIn('bookings.customer_id', $customer_id);
        }
        return $query->where('bookings.customer_id', $customer_id);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('bookings.code', 'LIKE', "%$search%")
                ->orWhere('bookings.name', 'LIKE', "%$search%")
                ->orWhere('bookings.phone', 'LIKE', "%$search%");
        });
    }

    public function scopeExpired($query)
    {
        return $query->where('bookings.date_start', '<=', now())->where('status', Booking::STATUS_TMP);
    }
}
