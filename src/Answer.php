<?php

namespace WebHappens\Questions;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public $timestamps = false;

    protected $table = 'answers';

    private static $sentiments = [
        1 => 'Negative',
        2 => 'Positive',
        3 => 'Super-positive',
    ];

    public static function sentiments()
    {
        return self::$sentiments;
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function sentiment()
    {
        return array_get(self::$sentiments, $this->sentiment_id);
    }
}
