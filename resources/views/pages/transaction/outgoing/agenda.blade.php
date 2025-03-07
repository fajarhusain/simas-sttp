@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="[__('menu.agenda.menu'), __('menu.agenda.outgoing_letter')]">
    </x-breadcrumb>

    <div class="card mb-5 shadow-sm">
        <div class="card-header" style="background-color: #f9f6b8; color: #333; border: none;">
            <form action="{{ url()->current() }}">
                <input type="hidden" name="search" value="{{ $search ?? '' }}">
                <div class="row">
                    <div class="col">
                        <x-input-form name="since" :label="__('menu.agenda.start_date')" type="date"
                                      :value="$since ? date('Y-m-d', strtotime($since)) : ''"/>
                    </div>
                    <div class="col">
                        <x-input-form name="until" :label="__('menu.agenda.end_date')" type="date"
                                      :value="$until ? date('Y-m-d', strtotime($until)) : ''"/>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="filter" class="form-label">{{ __('menu.agenda.filter_by') }}</label>
                            <select class="form-select" id="filter" name="filter">
                                <option
                                    value="letter_date" @selected(old('filter', $filter) == 'letter_date')>{{ __('model.letter.letter_date') }}</option>
                                <option
                                    value="created_at" @selected(old('filter', $filter) == 'created_at')>{{ __('model.general.created_at') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label">{{ __('menu.general.action') }}</label>
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary" type="submit">{{ __('menu.general.filter') }}</button>
                                    <a href="{{ route('agenda.outgoing.print') . '?' . $query }}" target="_blank" class="btn btn-primary">
                                        {{ __('menu.general.print') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-striped table-bordered">
                <thead class="thead-light" style="background-color: #f9f6b8;">
                <tr>
                    <th>{{ __('model.letter.agenda_number') }}</th>
                    <th>{{ __('model.letter.reference_number') }}</th>
                    <th>{{ __('model.letter.to') }}</th>
                    <th>{{ __('model.letter.letter_date') }}</th>
                </tr>
                </thead>
                @if($data)
                    <tbody>
                    @foreach($data as $agenda)
                        <tr class="hover-effect">
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                <strong>{{ $agenda->agenda_number }}</strong></td>
                            <td>
                                <a href="{{ route('transaction.outgoing.show', $agenda) }}" class="text-dark">{{ $agenda->reference_number }}</a>
                            </td>
                            <td>{{ $agenda->to }}</td>
                            <td>{{ $agenda->formatted_letter_date }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                @else
                    <tbody>
                    <tr>
                        <td colspan="4" class="text-center">
                            {{ __('menu.general.empty') }}
                        </td>
                    </tr>
                    </tbody>
                @endif
                <tfoot class="thead-light" style="background-color: #f9f6b8;">
                {{-- <tr>
                    <th>{{ __('model.letter.agenda_number') }}</th>
                    <th>{{ __('model.letter.reference_number') }}</th>
                    <th>{{ __('model.letter.to') }}</th>
                    <th>{{ __('model.letter.letter_date') }}</th>
                </tr> --}}
                </tfoot>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {!! $data->appends(['search' => $search, 'since' => $since, 'until' => $until, 'filter' => $filter])->links() !!}
    </div>
@endsection

@push('styles')
    <style>
        /* Hover effect */
        .hover-effect:hover {
            background-color: #fff3b8 !important;
            cursor: pointer;
        }

        /* Add stripes and hover effect for table */
        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f6b8;
        }

        /* Make the table headers stand out */
        .thead-light th {
            background-color: #f9f6b8;
            color: #333;
        }

        /* Enhance pagination styles */
        .pagination {
            justify-content: center;
        }
    </style>
@endpush
