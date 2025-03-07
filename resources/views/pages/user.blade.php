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
                $('#editModal form').attr('action', '{{ route('user.index') }}/' + id);
                $('#editModal input:hidden#id').val(id);
                $('#editModal input#name').val($(this).data('name'));
                $('#editModal input#phone').val($(this).data('phone'));
                $('#editModal input#email').val($(this).data('email'));
                if ($(this).data('active') == 1) {
                    $('#editModal input#is_active').prop('checked', true);
                } else {
                    $('#editModal input#is_active').prop('checked', false);
                }
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
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="[__('menu.users')]">
        <button type="button" class="btn btn-primary btn-create" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus"></i> {{ __('menu.general.create') }}
        </button>
    </x-breadcrumb>

    <div class="row">
        @if($data)
            @foreach($data as $user)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $user->name }}</h5>
                            <p class="card-text">
                                <i class="fas fa-envelope"></i> {{ $user->email }}<br>
                                <i class="fas fa-phone"></i> {{ $user->phone }}<br>
                                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ __('model.user.' . ($user->is_active ? 'active' : 'nonactive')) }}
                                </span>
                            </p>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button class="btn btn-sm btn-info btn-edit"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}"
                                            data-phone="{{ $user->phone }}"
                                            data-active="{{ $user->is_active }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                        <i class="fas fa-edit"></i> {{ __('menu.general.edit') }}
                                    </button>
                                </div>
                                <div>
                                    <form action="{{ route('user.destroy', $user) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger btn-delete" type="button">
                                            <i class="fas fa-trash-alt"></i> {{ __('menu.general.delete') }}
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

    {{-- Modal Create --}}
    <div class="modal fade" id="createModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="{{ route('user.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('menu.general.create') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-input-form name="name" :label="__('model.user.name')"/>
                    <x-input-form name="email" :label="__('model.user.email')" type="email"/>
                    <x-input-form name="phone" :label="__('model.user.phone')"/>
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

    {{-- Modal Edit --}}
    <div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('menu.general.edit') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <x-input-form name="name" :label="__('model.user.name')"/>
                    <x-input-form name="email" :label="__('model.user.email')" type="email"/>
                    <x-input-form name="phone" :label="__('model.user.phone')"/>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active">
                        <label class="form-check-label" for="is_active"> {{ __('model.user.is_active') }} </label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="reset_password" id="reset_password">
                        <label class="form-check-label" for="reset_password"> {{ __('model.user.reset_password') }} </label>
                    </div>
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