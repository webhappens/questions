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

        return self::firstOrCreate([
            'scheme' => $url->getScheme(),
            'host' => $url->getHost(),
            'port' => $url->getPort(),
            'path' => $url->getPath(),
            'query' => json_encode($url->getAllQueryParameters()),
            'fragment' => $url->getFragment(),
        ]);
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
            ->withPath($this->path)
            ->withFragment($this->fragment);

        foreach (json_decode($this->query) as $key => $value) {
            $url = $url->withQueryParameter($key, $value);
        }

        return (string) $url;
    }

    protected static function isUrl($value)
    {
        $url = Url::fromString($value);

        return ($url->getScheme() && $url->getHost());
    }
}
