<?php

namespace Asciisd\Zoho\Traits;

use Exception;
use Illuminate\Support\Str;
use Asciisd\Zoho\ZohoManager;
use com\zoho\crm\api\record\Record;
use Asciisd\Zoho\Models\Zoho as ZohoModel;
use Asciisd\Zoho\Exceptions\InvalidZohoable;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property ZohoModel zoho
 */
trait Zohoable
{
    public function zoho(): MorphOne
    {
        return $this->morphOne(ZohoModel::class, 'zohoable');
    }

    /**
     * Retrieve the Zoho ID for current model item.
     *
     * @return string|null
     */
    public function zohoId(): ?string
    {
        return $this->zoho?->zoho_id;
    }

    /**
     * Determine if the entity has a Zoho ID.
     *
     * @return bool
     */
    public function hasZohoId(): bool
    {
        return ! is_null($this->zohoId());
    }

    /**
     * create or update the current model with zoho id
     *
     * @param  null  $id
     *
     * @return mixed
     * @throws Exception
     */
    public function createOrUpdateZohoId($id = null): mixed
    {
        try {
            return $this->createZohoId($id);
        } catch (InvalidZohoable $e) {
            try {
                return $this->updateZohoId($id);
            } catch (InvalidZohoable $e) {
                throw new Exception('something went wrong!');
            }
        }
    }

    /**
     * Update current zoho id for this model
     *
     * @param  null  $id
     *
     * @return mixed
     * @throws InvalidZohoable
     */
    public function updateZohoId($id = null): mixed
    {
        if ( ! $this->hasZohoId()) {
            throw InvalidZohoable::nonZohoable($this);
        }

        if ( ! $id) {
            if ( ! is_bool($result = $this->findByCriteria())) {
                $id = $result->getId();
            }
        }

        $this->zoho()->update(['zoho_id' => $id]);

        return $this->load('zoho');
    }

    /**
     * create zoho id from $id or search on zoho by criteria
     *
     * @param  null  $id
     *
     * @return mixed
     * @throws InvalidZohoable
     */
    public function createZohoId($id = null): mixed
    {
        if ($this->hasZohoId()) {
            throw InvalidZohoable::exists($this);
        }

        if ( ! $id) {
            if ( ! is_bool($result = $this->findByCriteria())) {
                $id = $result->getId();
            }
        }

        $this->zoho()->create(['zoho_id' => $id]);

        return $this->load('zoho');
    }

    /**
     * delete zoho id from this model
     *
     * @return mixed
     * @throws InvalidZohoable
     */
    public function deleteZohoId(): mixed
    {
        if ( ! $this->hasZohoId()) {
            throw InvalidZohoable::nonZohoable($this);
        }

        $this->zoho()->delete();

        return $this->load('zoho');
    }

    protected function findByCriteria()
    {
        if ($this->searchCriteria() == '') {
            return null;
        }

        return last(
            $this->zoho_module->searchRecordsByCriteria(
                $this->searchCriteria()
            )
        );
    }

    /**
     * Create a Zoho record for the given model.
     *
     * @param  array  $options
     *
     * @return object
     * @throws InvalidZohoable
     */
    public function createAsZohoable(array $options = []): object
    {
        if ($this->zohoId()) {
            throw InvalidZohoable::exists($this);
        }

        $options = array_merge($this->zohoMandatoryFields(), $options);

        // Here we will create the Record instance on Zoho and store the ID of the
        // record from Zoho. This ID will correspond with the Zoho record instance
        // and allow us to retrieve records from Zoho later when we need to work.
        $records = $this->zoho_module->create($options);

        $this->createZohoId($records->getDetails()['id']);


        return $records->getDetails()['id'];
    }

    /**
     * Update Zoho record for the given model.
     *
     * @param  array  $options
     *
     * @return Record
     * @throws InvalidZohoable
     */
    public function updateZohoable(array $options = []): Record
    {
        if ( ! $this->hasZohoId()) {
            throw InvalidZohoable::nonZohoable($this);
        }

        $options = array_merge($this->zohoMandatoryFields(), $options);

        // Here we will create the Record instance on Zoho and store the ID of the
        // record from Zoho. This ID will correspond with the Zoho record instance
        // and allow us to retrieve records from Zoho later when we need to work.
        $record = $this->asZohoObject();

        foreach ($options as $key => $value) {
            $record->addKeyValue($key, $value);
        }

        $isUpdated = $this->zoho_module->update($record);

        if ($isUpdated) {
            $this->createOrUpdateZohoId($record->getId());
        }

        return $record;
    }

    /**
     * Find and delete zoho record and remove zoho_id from model
     *
     * @return mixed
     * @throws InvalidZohoable
     */
    public function deleteZohoable(): mixed
    {
        $this->zoho_module->deleteRecord($this->asZohoObject()->getId());

        return $this->deleteZohoId();
    }

    /**
     * Get the zoho module name associated with the model.
     *
     * @return string
     */
    public function getZohoModuleName(): string
    {
        return $this->zoho_module_name ?? Str::snake(Str::pluralStudly(class_basename($this)));
    }

    /**
     * Get the Zoho Module for this model
     *
     * @return ZohoManager
     */
    public function getZohoModule(): ZohoManager
    {
        return ZohoManager::useModule($this->getZohoModuleName());
    }

    /**
     * get zoho object by the module id
     */
    public function asZohoObject(): Record
    {
        return $this->findByZohoId($this->zohoId());
    }

    public function findByZohoEmail($email)
    {
        return last($this->zoho_module->searchRecordsByEmail($email));
    }

    /**
     * find record by its ID
     *
     * @param $id
     *
     * @return Record
     */
    public function findByZohoId($id): Record
    {
        return $this->zoho_module->getRecord($id);
    }

    /**
     * Determine if the entity has a Zoho ID and throw an exception if not.
     *
     * @return void
     * @throws InvalidZohoable
     */
    protected function assertZohoableExists(): void
    {
        if ( ! $this->zohoId()) {
            throw InvalidZohoable::nonZohoable($this);
        }
    }
}
