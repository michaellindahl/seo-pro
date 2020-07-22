<?php

namespace Statamic\SeoPro;

use Statamic\Facades\File;
use Statamic\Facades\YAML;
use Illuminate\Support\Collection;

class SiteDefaults extends Collection
{
    /**
     * Load site defaults collection.
     *
     * @param array|Collection|null $items
     */
    public function __construct($items = null)
    {
        if (! is_null($items)) {
            $items = collect($items)->all();
        }

        $this->items = $items ?? $this->getDefaults();
    }

    /**
     * Load site defaults collection.
     *
     * @param array|Collection|null $items
     * @return static
     */
    public static function load($items = null)
    {
        return new static($items);
    }

    /**
     * Save site defaults collection to yaml.
     */
    public function save()
    {
        File::put($this->path(), YAML::dump($this->items));
    }

    /**
     * Get site defaults from yaml.
     *
     * @return array
     */
    protected function getDefaults()
    {
        return collect(YAML::file(__DIR__.'/../content/seo.yaml')->parse())
            ->merge(YAML::file($this->path())->parse())
            ->all();
    }

    /**
     * Get site defaults yaml path.
     *
     * @return string
     */
    protected function path()
    {
        return base_path('content/seo.yaml');
    }
}
