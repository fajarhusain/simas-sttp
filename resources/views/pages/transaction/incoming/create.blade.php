@extends('layout.main')

@section('content')
    <x-breadcrumb :values="[__('menu.transaction.menu'), __('menu.transaction.incoming_letter'), __('menu.general.create')]"/>

    <div class="card mb-4">
        <form action="{{ route('transaction.incoming.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <input type="hidden" name="type" value="incoming">

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                    <x-input-form name="reference_number" :label="__('model.letter.reference_number')"/>
                    <x-input-form name="from" :label="__('model.letter.from')"/>
                    <x-input-form name="agenda_number" :label="__('model.letter.agenda_number')"/>
                    <x-input-form name="letter_date" :label="__('model.letter.letter_date')" type="date"/>
                    <x-input-form name="received_date" :label="__('model.letter.received_date')" type="date"/>
                    
                    <div class="mb-3">
                        <label for="classification_code" class="form-label">{{ __('model.letter.classification_code') }}</label>
                        <select class="form-select" id="classification_code" name="classification_code">
                            @foreach($classifications as $classification)
                                <option value="{{ $classification->code }}" @selected(old('classification_code') == $classification->code)>
                                    {{ $classification->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <x-input-form name="note" :label="__('model.letter.note')"/>

                    <div class="mb-3">
                        <label for="attachments" class="form-label">{{ __('model.letter.attachment') }}</label>
                        <input type="file" class="form-control @error('attachments') is-invalid @enderror" id="attachments" name="attachments[]" multiple/>
                        <span class="error invalid-feedback">{{ $errors->first('attachments') }}</span>
                    </div>
                </div>

                <x-input-textarea-form name="description" :label="__('model.letter.description')" class="mt-3"/>

            </div>
            
            <div class="card-footer text-end">
                <button class="btn btn-success">
                    <i class="bx bx-save"></i> {{ __('menu.general.save') }}
                </button>
            </div>
        </form>
    </div>
@endsection
