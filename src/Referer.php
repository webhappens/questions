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

    public static function firstOrCreateFromString($uri)
    {
        if ( ! self::isUrl($uri)) {
            return self::firstOrCreate(['uri' => $uri]);
        }

        $normalizer = new UrlNormalizer($uri, true, true);
        $url = Url::fromString($normalizer->normalize());
        $query = $url->getAllQueryParameters();

        $attributes = [
            'scheme' => $url->getScheme(),
            'host' => $url->getHost(),
            'port' => $url->getPort(),
            'path' => $url->getPath(),
            'query' =>  $query ? json_encode($query) : null,
            'fragment' => $url->getFragment(),
        ];

        if ($first = self::where($attributes)->first()) {
            return $first;
        }

        return self::create(array_merge($attributes, compact('query')));
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function __toString()
    {
        if ($this->uri) {
            return $this->uri;
        }

        $url = Url::create()
            ->withScheme($this->scheme)
            ->withHost($this->host)
            ->withPort($this->port)
            ->withPath($this->path);

        if ($this->fragment) {
            $url = $url->withFragment($this->fragment);
        }

        $queryParameters = $this->query ?: [];

        foreach ($queryParameters as $key => $value) {
            $url = $url->withQueryParameter($key, $value);
        }

        return (string) $url;
    }

    public function getQueryAttribute($value)
    {
        return json_decode($value, true) ?: [];
    }

    public function setQueryAttribute($value)
    {
        $this->attributes['query'] = $value ? json_encode($value) : null;
    }

    protected static function isUrl($value)
    {
        $url = Url::fromString($value);

        return ($url->getScheme() && $url->getHost());
    }
}
