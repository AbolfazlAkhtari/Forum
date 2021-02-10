<?php


namespace App;


use App\Models\Activity;
use App\Models\Thread;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) return;

        foreach (static::getEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }
    // when you create a static function named (boot + trait name) in a trait,
    // it's works just like the boot method for every model that is using this trait

    protected static function getEvents()
    {
        return ['created'];
    }

    protected function getActivityType($event): string
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$type}_$event";
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'type' => $this->getActivityType($event),
            'user_id' => auth()->user()->id,
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
