<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments';

    protected $fillable = [
        'brand_id',
        'code',
        'name',
        'status',
        'description'
    ];

    protected $hidden = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'status' => 'boolean',
        'brand_id' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->status = $model->status ?? true;
            $model->code = $model->code ?? generateRandomString();
        });
        self::created(function ($model) {
        });
        self::updated(function ($model) {
        });
        self::deleted(function ($model) {
        });
    }

    const STATUS_ACTIVE = 1;
    const STATUS_SUSPEND = 2;

    public static function get_status($status = '')
    {
        $types = [
            self::STATUS_ACTIVE => ['Đang hoạt động', 'success', COLOR_SUCCESS],
            self::STATUS_SUSPEND => ['Tạm ngưng', 'light', COLOR_LIGHT],
        ];
        return $status == '' ? $types : $types["$status"];
    }

    public function staffs()
    {
        return $this->hasMany(Staff::class, 'department_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
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

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('departments.code', 'LIKE', "%$search%")
                ->orWhere('departments.name', 'LIKE', "%$search%");
        });
    }
}
