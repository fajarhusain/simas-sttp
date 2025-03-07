@extends('layout.main')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .settings-card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .settings-card:hover {
            transform: translateY(-5px);
        }

        .settings-group {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .settings-group h5 {
            margin-bottom: 15px;
            color: #333;
        }
    </style>
@endpush

@section('content')
    <x-breadcrumb :values="[__('navbar.profile.settings')]"></x-breadcrumb>

    <div class="row">
        <div class="col">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.show') }}">{{ __('navbar.profile.profile') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);">{{ __('navbar.profile.settings') }}</a>
                </li>
            </ul>

            <div class="card mb-4 settings-card">
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="settings-group">
                            <h5>{{ __('Pengaturan Umum') }}</h5>
                            <div class="row">
                                @foreach($configs as $config)
                                    @continue($config->code == 'language' || $config->code == 'app_name' || $config->code == 'app_description')
                                    <div class="col-md-6">
                                        <x-input-form :name="$config->code" :value="$config->value ?? ''" :label="__('model.config.' . $config->code)"/>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="settings-group">
                            <h5>{{ __('Pengaturan Aplikasi') }}</h5>
                            <div class="row">
                                @foreach($configs as $config)
                                    @continue($config->code !== 'app_name' && $config->code !== 'app_description')
                                    <div class="col-md-6">
                                        <x-input-form :name="$config->code" :value="$config->value ?? ''" :label="__('model.config.' . $config->code)"/>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-2 text-center">
                            <button type="submit" class="btn btn-primary me-2"><i class="fas fa-save"></i> {{ __('menu.general.update') }}</button>
                            <button type="reset" class="btn btn-outline-secondary"><i class="fas fa-undo"></i> {{ __('menu.general.cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection