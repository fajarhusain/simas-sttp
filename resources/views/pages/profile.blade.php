@extends('layout.main')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .profile-card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
        }

        .profile-picture {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .upload-button {
            position: relative;
            overflow: hidden;
        }

        .upload-button input[type="file"] {
            position: absolute;
            font-size: 100px;
            opacity: 0;
            right: 0;
            top: 0;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #856404;
        }

        .alert-warning h6 {
            color: #856404;
        }
    </style>
@endpush

@push('script')
    <script>
        $('input#accountActivation').on('change', function () {
            $('button.deactivate-account').attr('disabled', !$(this).is(':checked'));
        });

        document.addEventListener('DOMContentLoaded', function (e) {
            (function () {
                let accountUserImage = document.getElementById('uploadedAvatar');
                const fileInput = document.querySelector('.account-file-input'),
                    resetFileInput = document.querySelector('.account-image-reset');

                if (accountUserImage) {
                    const resetImage = accountUserImage.src;
                    fileInput.onchange = () => {
                        if (fileInput.files[0]) {
                            accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                        }
                    };
                    resetFileInput.onclick = () => {
                        fileInput.value = '';
                        accountUserImage.src = resetImage;
                    };
                }
            })();
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="[__('navbar.profile.profile')]"></x-breadcrumb>

    <div class="row">
        <div class="col">
            @if(auth()->user()->role == 'admin')
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);">{{ __('navbar.profile.profile') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('settings.show') }}">{{ __('navbar.profile.settings') }}</a>
                    </li>
                </ul>
            @endif

            <div class="card mb-4 profile-card">
                <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <img src="{{ $data->profile_picture }}" alt="user-avatar" class="profile-picture" id="uploadedAvatar">
                        </div>
                        <div class="mb-3 upload-button">
                            <label for="upload" class="btn btn-primary me-2 mb-2" tabindex="0">
                                <i class="fas fa-upload"></i> {{ __('menu.general.upload') }}
                                <input type="file" name="profile_picture" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg">
                            </label>
                            <button type="button" class="btn btn-outline-secondary account-image-reset mb-2">
                                <i class="fas fa-undo"></i> {{ __('menu.general.cancel') }}
                            </button>
                            <p class="text-muted mb-0"><small>Max 800K (JPG, GIF, PNG)</small></p>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="col-md-6 col-lg-12">
                                <x-input-form name="name" :label="__('model.user.name')" :value="$data->name" />
                            </div>
                            <div class="col-md-6">
                                <x-input-form name="email" :label="__('model.user.email')" :value="$data->email" />
                            </div>
                            <div class="col-md-6">
                                <x-input-form name="phone" :label="__('model.user.phone')" :value="$data->phone ?? ''" />
                            </div>
                        </div>
                        <div class="mt-2 text-center">
                            <button type="submit" class="btn btn-primary me-2"><i class="fas fa-save"></i> {{ __('menu.general.update') }}</button>
                            <button type="reset" class="btn btn-outline-secondary"><i class="fas fa-undo"></i> {{ __('menu.general.cancel') }}</button>
                        </div>
                    </div>
                </form>
            </div>

            @if(auth()->user()->role == 'staff')
                <div class="card profile-card">
                    <h5 class="card-header"><i class="fas fa-user-slash"></i> {{ __('navbar.profile.deactivate_account') }}</h5>
                    <div class="card-body">
                        <div class="mb-3 col-12 mb-0">
                            <div class="alert alert-warning">
                                <h6 class="alert-heading fw-bold mb-1"><i class="fas fa-exclamation-triangle"></i> {{ __('navbar.profile.deactivate_confirm_message') }}</h6>
                            </div>
                        </div>
                        <form id="formAccountDeactivation" action="{{ route('profile.deactivate') }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation">
                                <label class="form-check-label" for="accountActivation">{{ __('navbar.profile.deactivate_confirm') }}</label>
                            </div>
                            <button type="submit" class="btn btn-danger deactivate-account" disabled><i class="fas fa-user-slash"></i> {{ __('navbar.profile.deactivate_account') }}</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection