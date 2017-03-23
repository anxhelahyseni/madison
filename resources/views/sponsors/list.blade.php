@extends('layouts.app')

@section('pageTitle', trans('messages.sponsor.list'))

@section('content')
    <div class="page-header">
        <h1>{{ trans('messages.sponsor.list') }}</h1>
        @include('components.breadcrumbs.account')
    </div>

    @include('components.errors')

    <div class="row">
        <div class="col-md-9">
            <table class="table">
                <thead>
                    <tr>
                        <th>@lang('messages.sponsor.name')</th>
                        <th>@lang('messages.created')</th>
                        <th>@lang('messages.sponsor.status')</th>
                        <th>@lang('messages.sponsor.members')</th>
                        <th>@lang('messages.document.list')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sponsors as $sponsor)
                        <tr>
                            <td>
                                <a href="{{ route('sponsors.documents.index', $sponsor) }}">
                                    {{ $sponsor->name }}
                                </a>
                            </td>
                            <td>
                                @include('components/date', [ 'datetime' => $sponsor->created_at, ])
                            </td>
                            <td>
                                {{ trans('messages.sponsor.statuses.'.$sponsor->status) }}
                            </td>
                            <td>{{ $sponsor->members()->count() }}</td>
                            <td>{{ $sponsor->docs()->count() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4><small>@lang('messages.sponsor.create_another_header')</small></h4>
                    <p><small>@lang('messages.sponsor.create_another_body')</small></p>
                    {{ Html::linkRoute('sponsors.create', trans('messages.sponsor.create_another'), [], ['class' => 'btn btn-default btn-xs'])}}
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        @include('components.pagination', ['collection' => $sponsors])
    </div>
@endsection
