<?php

namespace Mixdinternet\Stores\Http\Controllers;

use App\Http\Controllers\Controller;
use Mixdinternet\Stores\Store;

class ApiController extends Controller
{
    public function index($type = null)
    {
        $content = 'var stores = ' . cache()->remember('api.stores.index-' . $type, 0, function () use ($type) {
                $query = Store::active()->select('type', 'name', 'zipcode', 'address', 'phone', 'latitude', 'longitude', 'description', 'state', 'city');
                if ($type) {
                    $query->where('type', $type);
                }

                return $query->get();
            });

        return response($content)
            ->header('Content-Type', 'application/json');
    }
}
