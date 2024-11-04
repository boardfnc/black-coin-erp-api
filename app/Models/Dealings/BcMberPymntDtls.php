<?php

namespace App\Models\Dealings;

use App\Models\History\BcCaCoinHis;
use App\Models\History\BcMberCoinHis;
use App\Models\User\BcMber;
use App\Models\User\BcMngr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcMberPymntDtls extends Model
{
    use HasFactory;

    protected $table = 'bc_mber_pymnt_dtls';

    protected $primaryKey = 'mber_pymnt_dtls_id';

    protected $guarded = [

    ];

    const UPDATED_AT = null;

    public function bcMber()
    {
        return $this->belongsTo( BcMber::class, 'mber_id' );
    }

    public function bcMngr()
    {
        return $this->belongsTo( BcMngr::class, 'mngr_id' );
    }

    public function bcCaCoinHis()
    {
        return $this->hasMany( BcCaCoinHis::class, 'mber_pymnt_dtls_id' );
    }

    public function bcMberCoinHis()
    {
        return $this->hasMany( BcMberCoinHis::class, 'mber_pymnt_dtls_id' );
    }
}
