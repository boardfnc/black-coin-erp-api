<?php

namespace App\Models\History;

use App\Models\User\BcMngr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcCaStats extends Model
{
    use HasFactory;

    protected $table = 'bc_ca_stats';

    protected $primaryKey = 'ca_stats_id';

    protected $guarded = [

    ];

    public function bcMngr()
    {
        return $this->belongsTo( BcMngr::class, 'mngr_id' );
    }

    public function scopeSearchBy($query, $keyword, $where)
    {
        if($where == 'stats_de_start')
        {
            return $query->where('stats_de', '>=', $keyword);
        }
        if($where == 'stats_de_end')
        {
            return $query->where('stats_de', '<=', $keyword);
        }
        if($where == 'prtnr_nm')
        {
            return $query->whereHas('bcMngr', function($q) use ($where, $keyword) {
                $q->where($where, 'like', '%'.$keyword.'%');
            });
        }
        if($where == 'code')
        {
            return $query->whereHas('bcMngr', function($q) use ($where, $keyword) {
                $q->where($where, 'like', '%'.$keyword.'%');
            });
        }

        return $query->where($where, 'like', '%'.$keyword.'%');
    }
}
