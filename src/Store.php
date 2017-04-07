<?php

namespace Mixdinternet\Stores;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Store extends EloquentModel
{
    use SoftDeletes, RevisionableTrait;

    protected $revisionCreationsEnabled = true;

    protected $revisionFormattedFieldNames = [
        'name' => 'nome',
        'description' => 'descrição',
        'location' => 'localização',
        'latlng' => 'latitude/longitude'
    ];

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'status', 'type', 'name', 'zipcode', 'address', 'description', 'city', 'state', 'phone', 'latitude', 'longitude'
    ];

    public function scopeSort($query, $fields = [])
    {
        if (count($fields) <= 0) {
            $fields = [
                'status' => 'asc',
                'name' => 'asc'
            ];
        }

        if (request()->has('field') && request()->has('sort')) {
            $fields = [request()->get('field') => request()->get('sort')];
        }

        foreach ($fields as $field => $order) {
            $query->orderBy($field, $order);
        }
    }

    public function scopeActive($query)
    {
        $query->where('status', 'active')->sort();
    }

    # revision
    public function identifiableName()
    {
        return $this->name;
    }
}
