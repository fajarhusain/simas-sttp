@extends('layout.main')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.btn-edit').click(function() {
                const id = $(this).data('id');
                $('#editModal form').attr('action', '{{ route('reference.classification.index') }}/' + id);
                $('#editModal input:hidden#id').val(id);
                <span class="math-inline">\('\#editModal input\#code'\)\.val\(</span>(this).data('code'));
                <span class="math-inline">\('\#editModal input\#type'\)\.val\(</span>(this).data('type'));
                <span class="math-inline">\('\#editModal input\#description'\)\.val\(</span>(this).data('description'));
            });

            $('.btn-delete').click(function(e) {
                e.preventDefault();
                const form = $(this).closest('form');

                Swal.fire({
                    title: '{{ __('menu.general.are_you_sure') }}',
                    text: "{{ __('menu.general.you_wont_be_able_to_revert_this') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __('menu.general.yes_delete_it') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Initialize Bootstrap tooltips for delete button
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="[__('menu.reference.menu'), __('menu.reference.classification')]">
        <button type="button" class="btn btn-primary create-button-pulse" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus"></i> {{ __('menu.general.create') }}
        </button>

        <style>
            .create-button-pulse {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                    box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
                }
                70% {
                    transform: scale(1.1);
                    box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
                }
                100% {
                    transform: scale(1);
                    box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
                }
            }
        </style>
    </x-breadcrumb>

    <div class="row">
        @if($data)
            @foreach($data as $classification)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h5 class="card-title">{{ $classification->code }}</h5>
                            <p class="card-text">
                                <strong>{{ __('model.classification.type') }}:</strong> {{ $classification->type }}<br>
                                <strong>{{ __('model.classification.description') }}:</strong> {{ $classification->description }}
                            </p>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button class="btn btn-info btn-sm btn-edit"
                                            data-id="{{ $classification->id }}"
                                            data-code="{{ $classification->code }}"
                                            data-type="{{ $classification->type }}"
                                            data-description="{{ $classification->description }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                        <i class="fas fa-edit"></i> {{ __('menu.general.edit') }}
                                    </button>
                                </div>
                                <div>
                                    <form action="{{ route('reference.classification.destroy', $classification) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm btn-delete"
                                                type="button"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="{{ __('menu.general.delete') }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center">
                {{ __('menu.general.empty') }}
            </div>
        @endif
    </div>

    {!! $data->appends(['search' => $search])->links() !!}

    <div class="modal fade" id="createModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="{{ route('reference.classification.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalTitle">{{ __('menu.general.create') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-input-form name="code" :label="__('model.classification.code')"/>
                    <x-input-form name="type" :label="__('model.classification.type')"/>
                    <x-input-form name="description" :label="__('model.classification.description')"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        {{ __('menu.general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary">{{ __('menu.general.save') }}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">{{ __('menu.general.edit') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <x-input-form name="code" :label="__('model.classification.code')"/>
                    <x-input-form name="type" :label="__('model.classification.type')"/>
                    <x-input-form name="description" :label="__('model.classification.description')"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        {{ __('menu.general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary">{{ __('menu.general.update') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection