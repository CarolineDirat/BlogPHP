<?php

namespace App\Application;

trait Hydrator
{
    /**
     * hydrate.
     *
     * hydrate class's properties with array data
     */
    public function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (is_callable([$this, $method])) {
                $this->{$method}($value);
            }
        }
    }
}
