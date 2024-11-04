<?php

namespace App\Models\History;

use App\Models\Dealings\BcCaDelngDtls;
use App\Models\Dealings\BcMberDelngDtls;
use App\Models\Dealings\BcMberPymntDtls;
use App\Models\Dealings\BcMberRtrvlDtls;
use App\Models\User\BcMngr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcCaCoinHis extends Model
{
    use HasFactory;

    protected $table = 'bc_ca_coin_his';

    protected $primaryKey = 'ca_coin_his_id';

    protected $guarded = [

    ];

    const UPDATED_AT = null;

    public function bcMngr()
    {
        return $this->belongsTo( BcMngr::class, 'mngr_id' );
    }

    public function bcMberDelngDtls()
    {
        return $this->belongsTo( BcMberDelngDtls::class, 'mber_delng_dtls_id' );
    }

    public function bcCaDelngDtls()
    {
        return $this->belongsTo( BcCaDelngDtls::class, 'ca_delng_dtls_id' );
    }

    public function bcMberRtrvlDtls()
    {
        return $this->belongsTo( BcMberRtrvlDtls::class, 'mber_rirvl_dtls_id' );
    }

    public function bcMberPymntDtls()
    {
        return $this->belongsTo( BcMberPymntDtls::class, 'mber_pymnt_dtls_id' );
    }
}
