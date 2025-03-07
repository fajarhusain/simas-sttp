@extends('layout.main')

@push('script')
    <script>
        $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            $('#editModal form').attr('action', '{{ route('reference.status.index') }}/' + id);
            $('#editModal input:hidden#id').val(id);
            $('#editModal input#status').val($(this).data('status'));
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb
        :values="[__('menu.reference.menu'), __('menu.reference.status')]">
        <button
    type="button"
    class="btn btn-primary create-button-pulse"
    data-bs-toggle="modal"
    data-bs-target="#createModal">
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

    <div class="card mb-5">
        <div class="table-responsive">
            <table id="statusTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('model.status.status') }}</th>
                        <th>{{ __('menu.general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if($data)
                        @foreach($data as $status)
                            <tr>
                                <td>{{ $status->id }}</td>
                                <td>{{ $status->status }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm btn-edit"
                                            data-id="{{ $status->id }}"
                                            data-status="{{ $status->status }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                        <i class="fas fa-edit"></i> {{ __('menu.general.edit') }}
                                    </button>
                                    <form action="{{ route('reference.status.destroy', $status) }}" class="d-inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm btn-delete" type="button">
                                            <i class="fas fa-trash-alt"></i> {{ __('menu.general.delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center">
                                {{ __('menu.general.empty') }}
                            </td>
                        </tr>
                    @endif
                </tbody>
                {{-- <tfoot>
                    <tr>
                        <th>#</th>
                        <th>{{ __('model.status.status') }}</th>
                        <th>{{ __('menu.general.action') }}</th>
                    </tr>
                </tfoot> --}}
            </table>
        </div>
    </div>
    
    {!! $data->appends(['search' => $search])->links() !!}
    
    <!-- Create Modal -->
    <div class="modal fade" id="createModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="{{ route('reference.status.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalTitle"><i class="fas fa-plus"></i> {{ __('menu.general.create') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-input-form name="status" :label="__('model.status.status')"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> {{ __('menu.general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('menu.general.save') }}</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle"><i class="fas fa-edit"></i> {{ __('menu.general.edit') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <x-input-form name="status" :label="__('model.status.status')"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> {{ __('menu.general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('menu.general.save') }}</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#statusTable').DataTable({
                responsive: true,
                order: [[0, 'asc']]  // Sorting by the first column (ID)
            });
    
            // Handle delete confirmation
            $('.btn-delete').on('click', function() {
                if(confirm("Apakah anda yakin ingin menghapus data ini?")){
                    $(this).closest('form').submit();
                }
            });
    
            // Edit modal setup
            $('#editModal').on('show.bs-modal', function (event) {
              var button = $(event.relatedTarget);
              var id = button.data('id');
              var status = button.data('status');
              var modal = $(this);
              modal.find('.modal-body #id').val(id);
              modal.find('.modal-body #status').val(status);
              modal.find('form').attr('action', '{{ route("reference.status.update", "") }}/' + id);
            });
        });
    </script>
    
@endsection
