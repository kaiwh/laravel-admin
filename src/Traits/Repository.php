<?php

namespace Kaiwh\Admin\Traits;

trait Repository
{
    protected $model;
    /**
     * Filter eloquent
     *
     */
    abstract protected function filter($query, $filter);
    /**
     * Get list
     *
     */
    public function all($filter = [])
    {
        return $this->model->where(function ($query) use ($filter) {
            $this->filter($query, $filter);
        })->get();
    }
    /**
     * Get list
     *
     */
    public function paginate($filter = [], $perPage = 20)
    {
        return $this->model->where(function ($query) use ($filter) {
            $this->filter($query, $filter);
        })->paginate($perPage);
    }
    /**
     * Get first
     *
     */
    public function first($id)
    {
        return $this->model->where('id', $id)->first();
    }
    /**
     * Get first
     *
     */
    public function firstBy($attribute, $value)
    {
        return $this->model->where($attribute, '=', $value)->first();
    }
    /**
     * Get enabled
     *
     */
    public function enabled($id = null)
    {
        if (is_null($id)) {
            return $this->model->where('status', 1)->get();
        } else {
            return $this->model->where('id', $id)->where('status', 1)->first();
        }
    }

    /**
     * Store
     *
     */
    abstract public function store(array $data);
    /**
     * Update
     *
     */
    abstract public function update();
    /**
     * Destroy
     *
     */
    abstract public function destroy();
    /**
     * Truncate
     *
     */
    abstract public function truncate();

}
