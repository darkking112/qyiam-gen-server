<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    //
    protected $primaryKey = "sheetID";
    protected $fillable = [
        'sheetID',
        'studentID',
        'prayerOnTime',
        'voluntaryPrayers',
        'morningSupplications',
        'eveningSupplications',
        'quranDailyPortion',
        'listeningToParents',
        'organizingPersonalBelongings',
        'siwak',
        'helpingInHouse',
        'sleepingEarly',
        'lessonsReviewing',
        'readingSurahAlKahaf',
        'attendingFridayEarly',
        'connectingWithRelatives',
        'dailyExercise',
        'healthyFood',
        'insertedBy',
        'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'studentID','studentID');
    }
}
