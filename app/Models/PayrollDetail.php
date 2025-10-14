<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollDetail extends Model
{

    protected $fillable = [
        'user_id', 'salary_type', 'basic_salary', 'hourly_rate', 'allowances',
        'deductions', 'total_hours', 'final_salary', 'joining_date','payroll_type',
        'payment_mode', 'is_paid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function advances()
    {
        return $this->hasMany(PayrollAdvance::class, 'user_id', 'user_id');
    }

    public function getFinalSalaryAttribute($value)
    {
        if ($this->salary_type === 'hourly') {
            $base = $this->hourly_rate * $this->total_hours;
        } else {
            $base = $this->basic_salary;
        }

        $advance = $this->advances->where('is_deducted', false)->sum('amount');
        return ($base + $this->allowances - $this->deductions - $advance);
    }
}
