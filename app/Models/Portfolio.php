<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portfolio extends Model
{
    protected $fillable = [
        'category',
        'image',
        'name',
        'client_name',
        'project_date',
        'project_url',
        'description',
        'detail_title',
        'detail_description'
    ];

    protected $casts = [
        'project_date' => 'date',
    ];

    public function portfolioDetails(): HasMany
    {
        return $this->hasMany(PortfolioDetail::class, 'portfolio_id', 'id');
    }
}
