<div class="container py-2"> <!-- Kontainer utama untuk memisahkan card dari batas luar -->
    <div class="card mb-3 shadow-lg border-0 rounded-lg overflow-hidden">
        <div class="card-header" style="background-color: #f3e885; color: #333; padding-bottom: 0;">
            <div class="d-flex justify-content-between flex-column flex-sm-row">
                <div class="d-flex flex-column flex-sm-row align-items-start">
                    <div class="mb-2 mb-sm-0">
                        <h5 class="text-uppercase text-dark mb-0 fw-bold">{{ $letter->reference_number }}</h5>
                        <small class="d-block text-muted">
                            {{ $letter->type == 'incoming' ? $letter->from : $letter->to }}
                        </small>
                    </div>
                    
                    <div class="ms-sm-4 mt-2 mt-sm-0 text-sm-end text-muted">
                        <div>
                            <small class="text-secondary">
                                <i class="bx bx-agenda me-1"></i>{{ __('model.letter.agenda_number') }}: {{ $letter->agenda_number }}
                            </small>
                        </div>
                        <div>
                            <small class="text-info">
                                <i class="bx bx-category-alt me-1"></i>{{ $letter->classification?->type }}
                            </small>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex align-items-center justify-content-between">
                    <!-- Tanggal Surat -->
                    <div class="text-end me-3 d-flex flex-column align-items-end">
                        <small class="d-block text-secondary">
                            <i class="bx bx-calendar me-1"></i>{{ __('model.letter.letter_date') }}
                        </small>
                        <span class="fw-semibold text-dark" style="font-size: 1.1rem;">
                            {{ $letter->formatted_letter_date }}
                        </span>
                        <!-- Menambahkan garis bawah tipis untuk pembeda -->
                        <div class="mt-1" style="border-bottom: 2px solid #7a0101; width: 1000%;"></div>
                    </div>

                    <!-- Tombol Dispose untuk Surat Masuk -->
                    @if($letter->type == 'incoming')
                        <a href="{{ route('transaction.disposition.index', $letter) }}" class="btn btn-outline-info d-flex align-items-center border-2 rounded-lg shadow-lg p-2 transition-all hover:bg-info hover:text-white">
                            <i class="bx bx-share-alt me-2"></i> {{ __('model.letter.dispose') }}
                            <span class="badge bg-dark text-info ms-2">{{ $letter->dispositions->count() }}</span>
                        </a>
                    @endif
                    
                    <!-- Dropdown Menu untuk Aksi Lainnya -->
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="dropdown-{{ $letter->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded text-dark fs-4"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow-lg rounded-3 border-0">
                            @if(!\Illuminate\Support\Facades\Route::is('*.show'))
                                <a class="dropdown-item d-flex align-items-center text-dark hover-bg-warning p-2 rounded-3 transition-all" href="{{ route('transaction.' . $letter->type . '.show', $letter) }}">
                                    <i class="bx bx-eye me-2"></i>{{ __('menu.general.view') }}
                                </a>
                            @endif
                            <a class="dropdown-item d-flex align-items-center text-dark hover-bg-warning p-2 rounded-3 transition-all" href="{{ route('transaction.' . $letter->type . '.edit', $letter) }}">
                                <i class="bx bx-edit-alt me-2"></i>{{ __('menu.general.edit') }}
                            </a>
                            <form action="{{ route('transaction.' . $letter->type . '.destroy', $letter) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <span class="dropdown-item d-flex align-items-center text-danger hover-bg-danger p-2 rounded-3 transition-all cursor-pointer btn-delete">
                                    <i class="bx bx-trash me-2"></i>{{ __('menu.general.delete') }}
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
        <div class="card-body">
            <hr>
            <p class="text-muted">{{ $letter->description }}</p>
            
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start">
                <!-- Catatan Surat -->
                <small class="text-secondary text-truncate" style="max-width: 70%;">{{ $letter->note }}</small>
                
                <!-- Lampiran Surat -->
                @if($letter->attachments->count())
                    <div class="d-flex flex-wrap gap-3 mt-2 mt-sm-0">
                        @foreach($letter->attachments as $attachment)
                            <a href="{{ $attachment->path_url }}" target="_blank" class="text-decoration-none">
                                <div class="attachment-icon">
                                    @if($attachment->extension == 'pdf')
                                        <i class="bx bxs-file-pdf display-6 text-danger"></i>
                                    @elseif(in_array($attachment->extension, ['jpg', 'jpeg', 'png']))
                                        <i class="bx bxs-file-image display-6 text-success"></i>
                                    @else
                                        <i class="bx bxs-file display-6 text-primary"></i>
                                    @endif
                                    <small class="d-block text-center mt-1">{{ strtoupper($attachment->extension) }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        
            <!-- Slot Konten -->
            {{ $slot }}
        </div>
    </div>
</div>
