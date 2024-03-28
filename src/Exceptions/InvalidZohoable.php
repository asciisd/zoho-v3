<?php

namespace Asciisd\Zoho\Exceptions;

use Illuminate\Database\Eloquent\Model;

class InvalidZohoable extends \Exception
{
    /**
     * Create a new InvalidTapCustomer instance.
     *
     * @param  Model  $owner
     *
     * @return static
     */
    public static function nonZohoable(Model $owner): static
    {
        return new static(class_basename($owner).' is not a Zohoable. See the createAsZohoable method.');
    }

    /**
     * Create a new InvalidTapCustomer instance.
     *
     * @param  Model  $owner
     *
     * @return static
     */
    public static function exists(Model $owner): static
    {
        return new static(class_basename($owner)." is already a Zohoable with ID {$owner->zohoId()}");
    }
}
