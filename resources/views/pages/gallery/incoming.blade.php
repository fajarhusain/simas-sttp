@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="[__('menu.gallery.menu'), __('menu.gallery.incoming_letter')]">
    </x-breadcrumb>

    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
        @foreach($data as $attachment)
            <div class="col">
                <x-gallery-card
                    :filename="$attachment->filename"
                    :extension="$attachment->extension"
                    :path="$attachment->path_url"
                    :letter="$attachment->letter"
                />
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-2">
        {!! $data->appends(['search' => $search])->links() !!}
    </div>
@endsection

@push('styles')
    <style>
        /* Gallery card styling */
        .gallery-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .gallery-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Image preview styling */
        .gallery-card img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        /* Custom pagination styling */
        .pagination {
            justify-content: center;
        }
    </style>
@endpush
