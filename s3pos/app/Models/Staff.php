<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    use HasFactory;
    protected $table = 'staffs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'position',
        'email',
        'avatar',
        'phone',
        'email',
        'password',
        'gender',
        'is_supper',
        'status',
        'address',
        'description',
        'department_id',
        'store_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'gender' => 'integer',
        'is_supper' => 'integer',
        'store_id' => 'integer',
        'department_id' => 'integer',
        'status' => 'integer',
        'password' => 'hashed',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->status = $model->status ?? self::STATUS_UN_ACTIVE;
            $model->code = $model->code ?? generateRandomString();
            $model->gender = $model->gender ?? self::GENDER_OTHER;
            $model->is_supper = $model->is_supper ?? self::NOT_SUPPER;
        });
        self::created(function ($model) {
        });
        self::updated(function ($model) {
        });
        self::deleted(function ($model) {
        });
    }

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_OTHER = 3;

    public static function get_gender($gender = '')
    {
        $types = [
            self::GENDER_MALE => ['Nam', 'success', COLOR_SUCCESS],
            self::GENDER_FEMALE => ['Nữ', 'warning', COLOR_WARNING],
            self::GENDER_OTHER => ['Khác', 'secondary', COLOR_SECONDARY],
        ];
        return $gender == '' ? $types : $types["$gender"];
    }

    const IS_SUPPER = 1;
    const NOT_SUPPER = 2;

    const STATUS_UN_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_SUSPEND = 3;

    public static function get_status($status = '')
    {
        $types = [
            self::STATUS_UN_ACTIVE => ['Chưa kích hoạt', 'secondary', COLOR_SECONDARY],
            self::STATUS_ACTIVE => ['Đang kích hoạt', 'success', COLOR_SUCCESS],
            self::STATUS_SUSPEND => ['Tạm ngưng', 'warning', COLOR_WARNING],
        ];
        return $status == '' ? $types : $types["$status"];
    }

    public function history()
    {
        return $this->hasMany(StaffHistory::class, 'staff_id', 'id');
    }

    public function scopeOfSupper($query, $is_supper)
    {
        return $query->where('staffs.is_supper', $is_supper);
    }

    public function scopeOfGender($query, $gender)
    {
        return $query->where('staffs.gender', $gender);
    }

    public function scopeOfEmail($query, $email)
    {
        if (is_array($email)) {
            return $query->whereIn('staffs.email', $email);
        }
        return $query->where('staffs.email', $email);
    }

    public function scopeOfStatus($query, $status)
    {
        if (is_array($status)) {
            return $query->whereIn('staffs.status', $status);
        }
        return $query->where('staffs.status', $status);
    }

    public function scopeStoreId($query, $store_id)
    {
        if (is_array($store_id)) {
            return $query->whereIn('staffs.store_id', $store_id);
        }
        return $query->where('staffs.store_id', $store_id);
    }

    public function scopeDepartmentId($query, $department_id)
    {
        if (is_array($department_id)) {
            return $query->whereIn('staffs.department_id', $department_id);
        }
        return $query->where('staffs.department_id', $department_id);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('staffs.email', 'LIKE', "%$search%")
                ->orWhere('staffs.name', 'LIKE', "%$search%")
                ->orWhere('staffs.code', 'LIKE', "%$search%")
                ->orWhere('staffs.phone', 'LIKE', "%$search%");
        });
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
