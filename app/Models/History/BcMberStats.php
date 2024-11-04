<?php

namespace App\Models\History;

use App\Models\User\BcMber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcMberStats extends Model
{
    use HasFactory;

    protected $table = 'bc_mber_stats';

    protected $primaryKey = 'mber_stats_id';

    protected $guarded = [

    ];

    public function bcMber()
    {
        return $this->belongsTo( BcMber::class, 'mber_id' );
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

        return $query->where($where, 'like', '%'.$keyword.'%');
    }
}
