<?php

namespace Modules\Campaigns\Entities;


use EloquentFilter\ModelFilter;
use Illuminate\Support\Facades\DB;

class ArticleFilter extends ModelFilter
{


    public function orderTitle($value)
    {
        return $this->orderBy(DB::raw("\"title\""), $value);
    }

    public function title($value)
    {
        return $this->whereLike('title', $value);

    }

    public function orderUrl($value)
    {
        return $this->orderBy(DB::raw("\"url\""), $value);
    }

    public function url($value)
    {
        return $this->whereLike('url', $value);

    }

    public function orderVisits($asc)
    {
        return $asc === 'ASC' ? $this->orderByRaw('count(visit_article_id) ASC') : $this->orderByRaw('count(visit_article_id) DESC');
    }

    public function minVisits($value)
    {
        return $this->havingRaw('count(visit_article_id) >= ?', [$value]);
    }

    public function maxVisits($value)
    {
        return $this->havingRaw('count(visit_article_id) <= ?', [$value]);
    }

    public function orderAmountSum($asc)
    {
        return $asc === 'ASC' ? $this->orderByRaw('sum(amount) ASC NULLS FIRST') : $this->orderByRaw('sum(amount) DESC NULLS LAST');
    }

    public function minAmountSum($value)
    {
        return $this->havingRaw('sum(amount) >= ?', [$value]);
    }

    public function maxAmountSum($value)
    {
        return $this->havingRaw('sum(amount) <= ?', [$value]);
    }

    public function orderNewUsers($asc)
    {
        return $asc === 'ASC' ? $this->orderByRaw('sum(first_donation) ASC') : $this->orderByRaw('sum(first_donation) DESC');
    }

    public function minNewUsers($value)
    {
        return $this->havingRaw('sum(first_donation) >= ?', [$value]);
    }

    public function maxNewUsers($value)
    {
        return $this->havingRaw('sum(first_donation) <= ?', [$value]);
    }


}