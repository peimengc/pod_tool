<?php


namespace App\Scopes;


use Illuminate\Database\Eloquent\Builder;

trait DateScopeTrait
{
    public function scopeDate(Builder $builder)
    {
        $field = $this->getDateField();
        $builder->whereDate($field, '>=', request('start-date', $this->defaultStartDate()))
            ->whereDate($field, '<=', request('end-date', $this->defaultEndDate()));
    }

    protected function getDateField()
    {
        return 'created_at';
    }

    public function defaultStartDate()
    {
        return now()->addDays(-6)->toDateString();
    }

    public function defaultEndDate()
    {
        return now()->toDateString();
    }
}
