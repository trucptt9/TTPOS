<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments';

    protected $fillable = [
        'store_id',
        'code',
        'name',
        'status',
        'description'
    ];

    protected $hidden = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'store_id' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->status = $model->status ?? self::STATUS_ACTIVE;
            $model->code = $model->code ?? generateRandomString();
        });
        self::created(function ($model) {
            save_log_action("Tạo mới phòng ban #$model->name");
        });
        self::updated(function ($model) {
            save_log_action("Cập nhật thông tin phòng ban #$model->name");
        });
        self::deleted(function ($model) {
            save_log_action("Xóa phòng ban #$model->name");
        });
    }

    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCKED = 'blocked';

    public static function get_status($status = '')
    {
        $types = [
            self::STATUS_ACTIVE => ['Đang kích hoạt', 'success', COLOR_SUCCESS],
            self::STATUS_BLOCKED => ['Tạm ngưng', 'danger', COLOR_DANGER],
        ];
        return $status == '' ? $types : $types["$status"];
    }

    public function staffs()
    {
        return $this->hasMany(Staff::class, 'department_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function scopeOfCode($query, $code)
    {
        return $query->where('departments.code', $code);
    }

    public function scopeOfStatus($query, $status)
    {
        if (is_array($status)) {
            return $query->whereIn('departments.status', $status);
        }
        return $query->where('departments.status', $status);
    }

    public function scopeStoreId($query, $store_id)
    {
        return $query->where('departments.store_id', $store_id);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('departments.code', 'LIKE', "%$search%")
                ->orWhere('departments.name', 'LIKE', "%$search%");
        });
    }
}
