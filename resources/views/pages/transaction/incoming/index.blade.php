@extends('layout.main')

@section('content')
<x-breadcrumb
:values="[__('menu.transaction.menu'), __('menu.transaction.incoming_letter')]">

<!-- Tombol dengan warna success (hijau) -->
<a href="{{ route('transaction.incoming.create') }}" 
   class="btn btn-success d-inline-flex align-items-center px-3 py-2 rounded-3 shadow-sm transition-all hover:bg-success hover:text-white">
    <i class="bx bx-plus-circle me-2"></i>{{ __('menu.general.create') }}
</a>
</x-breadcrumb>


<div class="container">
    <!-- Loop untuk menampilkan setiap letter card -->
    @foreach($data as $letter)
        <x-letter-card :letter="$letter" />
    @endforeach

    <!-- Pagination dengan mempertahankan nilai pencarian -->
    <div class="d-flex justify-content-center mt-4">
        {!! $data->appends(['search' => $search])->links() !!}
    </div>
</div>

@endsection
