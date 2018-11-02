<?php

namespace WebHappens\Questions;

use Spatie\Url\Url;
use WebHappens\Questions\Response;
use URL\Normalizer as UrlNormalizer;
use Illuminate\Database\Eloquent\Model;

class Referer extends Model
{
    public $timestamps = false;

    protected $table = 'referers';

    protected $fillable = ['uri', 'scheme', 'host', 'port', 'path', 'query', 'fragment'];

    public static function makeFromString($uri)
    {
        if ( ! self::isUrl($uri)) {
            return self::make(['uri' => $uri]);
        }

        $url = self::parseUrl($uri);

        return self::make([
            'uri' => (string)$url,
            'scheme' => $url->getScheme(),
            'host' => $url->getHost(),
            'port' => $url->getPort(),
            'path' => $url->getPath(),
            'query' => $url->getAllQueryParameters(),
            'fragment' => $url->getFragment(),
        ]);
    }

    public static function firstOrCreateFromString($uri)
    {
        $model = self::makeFromString($uri);

        if ($first = self::where('uri', $model->uri)->first()) {
            return $first;
        }

        $model->save();

        return $model;
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function getQueryAttribute($value)
    {
        return json_decode($value, true) ?: [];
    }

    public function setQueryAttribute($value)
    {
        $this->attributes['query'] = $value ? json_encode($value) : null;
    }

    public function __toString()
    {
        if (config('questions.hide_app_url_in_referer')) {
            return preg_replace('#^' . config('app.url') . '#', '', $this->uri);
        }

        return $this->uri;
    }

    protected static function parseUrl($url)
    {
        $normalizer = new UrlNormalizer($url, true, true);

        return Url::fromString($normalizer->normalize());
    }

    protected static function isUrl($value)
    {
        $url = Url::fromString($value);

        return ($url->getScheme() && $url->getHost());
    }
}
