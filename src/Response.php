<?php

namespace WebHappens\Questions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Response extends Model
{
    protected $table = 'responses';

    protected $fillable = ['question_id', 'answer_id', 'referer_id', 'context_data', 'message'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function referer()
    {
        return $this->belongsTo(Referer::class);
    }
}
