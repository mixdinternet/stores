@extends('mixdinternet/admix::index')

@section('title')
    Listagem de {{ strtolower(config('mstores.name', 'Lojas')) }}
@endsection

@section('btn-insert')
    @if((!checkRule('admin.stores.create')) && (!$trash))
        @include('mixdinternet/admix::partials.actions.btn.insert', ['route' => route('admin.stores.create')])
    @endif
    @if((!checkRule('admin.stores.trash')) && (!$trash))
        @include('mixdinternet/admix::partials.actions.btn.trash', ['route' => route('admin.stores.trash')])
    @endif
    @if($trash)
        @include('mixdinternet/admix::partials.actions.btn.list', ['route' => route('admin.stores.index')])
    @endif
@endsection

@section('btn-delete-all')
    @if((!checkRule('admin.stores.destroy')) && (!$trash))
        @include('mixdinternet/admix::partials.actions.btn.delete-all', ['route' => route('admin.stores.destroy')])
    @endif
@endsection

@section('search')
    {!! Form::model($search, ['route' => ($trash) ? 'admin.stores.trash' : 'admin.stores.index', 'method' => 'get', 'id' => 'form-search'
        , 'class' => '']) !!}
    <div class="row">
        <div class="col-md-3">
            {!! BootForm::select('status', 'Status', ['' => '-', 'active' => 'Ativo', 'inactive' => 'Inativo'], null
                , ['class' => 'jq-select2']) !!}
        </div>
        <div class="col-md-3">
            {!! BootForm::text('name', 'Nome') !!}
        </div>
        <div class="col-md-3">
            {!! BootForm::text('zipcode', 'CEP', null, ['class' => 'mask-zipcode']) !!}
        </div>
        <div class="col-md-3">
            {!! BootForm::text('address', 'Endereço') !!}
        </div>
    </div>

    @if(count(config('mstores.types')) > 1)
        <div class="row">
            <div class="col-md-3">
                {!! BootForm::select('type', 'Tipo', ['' => '-'] + config('mstores.types'), null
                    , ['class' => 'jq-select2']) !!}
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <a href="{{ route(($trash) ? 'admin.stores.trash' : 'admin.stores.index') }}"
                   class="btn btn-default btn-flat">
                    <i class="fa fa-list"></i>
                    <i class="fs-normal hidden-xs">Mostrar tudo</i>
                </a>
                <button class="btn btn-success btn-flat">
                    <i class="fa fa-search"></i>
                    <i class="fs-normal hidden-xs">Buscar</i>
                </button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('table')
    @if (count($stores) > 0)
        <table class="table table-striped table-hover table-action jq-table-rocket">
            <thead>
            <tr>
                @if((!checkRule('admin.stores.destroy')) && (!$trash))
                    <th>
                        <div class="checkbox checkbox-flat">
                            <input type="checkbox" id="checkbox-all">
                            <label for="checkbox-all">
                            </label>
                        </div>
                    </th>
                @endif
                <th>{!! columnSort('#', ['field' => 'id', 'sort' => 'asc']) !!}</th>
                <th>{!! columnSort('Nome', ['field' => 'name', 'sort' => 'asc']) !!}</th>
                <th>{!! columnSort('Estado', ['field' => 'state', 'sort' => 'asc']) !!}</th>
                <th>{!! columnSort('Cidade', ['field' => 'city', 'sort' => 'asc']) !!}</th>
                <th>{!! columnSort('Status', ['field' => 'status', 'sort' => 'asc']) !!}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($stores as $store)
                <tr>
                    @if((!checkRule('admin.stores.destroy')) && (!$trash))
                        <td>
                            @include('mixdinternet/admix::partials.actions.checkbox', ['row' => $store])
                        </td>
                    @endif
                    <td>{{ $store->id }}</td>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->state }}</td>
                    <td>{{ $store->city }}</td>
                    <td>@include('mixdinternet/admix::partials.label.status', ['status' => $store->status])</td>
                    <td>
                        @if((!checkRule('admin.stores.edit')) && (!$trash))
                            @include('mixdinternet/admix::partials.actions.btn.edit', ['route' => route('admin.stores.edit', $store->id)])
                        @endif
                        @if((!checkRule('admin.stores.destroy')) && (!$trash))
                            @include('mixdinternet/admix::partials.actions.btn.delete', ['route' => route('admin.stores.destroy'), 'id' => $store->id])
                        @endif
                        @if($trash)
                            @include('mixdinternet/admix::partials.actions.btn.restore', ['route' => route('admin.stores.restore', ['stores' => $store->id]), 'id' => $store->id])
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        @include('mixdinternet/admix::partials.nothing-found')
    @endif
@endsection

@section('pagination')
    {!! $stores->appends(request()->except(['page']))->render() !!}
@endsection

@section('pagination-showing')
    @include('mixdinternet/admix::partials.pagination-showing', ['model' => $stores])
@endsection