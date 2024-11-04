<?php

namespace App\Models\Dealings;

use App\Models\User\BcMber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcMberDelngDtlsChghst extends Model
{
    use HasFactory;

    protected $table = 'bc_mber_delng_dtls_chghst';

    protected $primaryKey = 'mber_delng_dtls_chghst_id';

    protected $guarded = [

    ];

    const UPDATED_AT = null;

    public function bcMber()
    {
        return $this->belongsTo( BcMber::class, 'mber_id' );
    }

    public function bcMberDelngDtls()
    {
        return $this->belongsTo( BcMberDelngDtls::class, 'mber_delng_dtls_id' );
    }
}
