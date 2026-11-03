<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\SemiBlockchainLedger;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use LogsActivity, SemiBlockchainLedger;

    protected $table = 'kelas';
    public $timestamps = false;
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}

