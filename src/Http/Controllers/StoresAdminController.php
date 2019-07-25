<?php

namespace Mixdinternet\Stores\Http\Controllers;

use Mixdinternet\Stores\Store;
use Illuminate\Http\Request;
use Caffeinated\Flash\Facades\Flash;
use Mixdinternet\Stores\Http\Requests\CreateEditStoresRequest;
use Mixdinternet\Admix\Http\Controllers\AdmixController;

class StoresAdminController extends AdmixController
{
    public function index(Request $request)
    {
        session()->put('backUrl', request()->fullUrl());

        $trash = ($request->segment(3) == 'trash') ? true : false;

        $query = Store::sort();
        ($trash) ? $query->onlyTrashed() : '';

        $search = [];
        $search['name'] = $request->input('name', '');
        $search['status'] = $request->input('status', '');
        $search['zipcode'] = $request->input('zipcode', '');
        $search['address'] = $request->input('address', '');
        $search['type'] = $request->input('type', '');
        $search['city'] = $request->input('city', '');
        $search['state'] = $request->input('state', '');

        ($search['address']) ? $query->where('address', 'LIKE', '%' . $search['address'] . '%') : '';
        ($search['name']) ? $query->where('name', 'LIKE', '%' . $search['name'] . '%') : '';
        ($search['status']) ? $query->where('status', $search['status']) : '';
        ($search['zipcode']) ? $query->where('zipcode', $search['zipcode']) : '';
        ($search['type']) ? $query->where('type', $search['type']) : '';
        ($search['city']) ? $query->where('city', 'LIKE', '%' . $search['city'] . '%') : '';
        ($search['state']) ? $query->where('state', 'LIKE', '%' . $search['state'] . '%') : '';


        $stores = $query->paginate(50);

        $view['search'] = $search;
        $view['stores'] = $stores;
        $view['trash'] = $trash;

        return view('mixdinternet/stores::admin.index', $view);
    }

    public function create(Store $store)
    {
        $view['store'] = $store;
        return view('mixdinternet/stores::admin.form', $view);
    }

    public function store(CreateEditStoresRequest $request)
    {
        if (Store::create($request->all())) {
            Flash::success('Item inserido com sucesso.');
        } else {
            Flash::error('Falha no cadastro.');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admin.stores.index');
    }

    public function edit(Store $store)
    {
        $view['store'] = $store;
        return view('mixdinternet/stores::admin.form', $view);
    }

    public function update(Store $store, CreateEditStoresRequest $request)
    {
        if ($store->update($request->all())) {
            Flash::success('Item atualizado com sucesso.');
        } else {
            Flash::error('Falha na atualização.');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admin.stores.index');
    }

    public function destroy(Request $request)
    {
        if (Store::destroy($request->input('id'))) {
            Flash::success('Item removido com sucesso.');
        } else {
            Flash::error('Falha na remoção.');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admin.stores.index');
    }

    public function restore($id)
    {
        $store = Store::onlyTrashed()->find($id);

        if (!$store) {
            abort(404);
        }

        if ($store->restore()) {
            Flash::success('Item restaurado com sucesso.');
        } else {
            Flash::error('Falha na restauração.');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admin.stores.trash');
    }
}