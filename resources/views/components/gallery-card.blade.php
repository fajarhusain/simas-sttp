<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between flex-column flex-sm-row align-items-center">
            <div>
                <h5 class="card-title mb-0 text-uppercase text-muted">{{ $extension }}</h5>
                <small>
                    @if($letter->type == 'incoming')
                        <a href="{{ route('transaction.incoming.show', $letter) }}" class="fw-bold text-decoration-none text-primary">{{ $letter->reference_number }}</a>
                    @else
                        <a href="{{ route('transaction.outgoing.show', $letter) }}" class="fw-bold text-decoration-none text-primary">{{ $letter->reference_number }}</a>
                    @endif
                </small>
            </div>
            <div class="text-center mt-2 mt-sm-0">
                @if(strtolower($extension) == 'pdf')
                    <i class="bx bxs-file-pdf display-6 text-danger"></i>
                @elseif(strtolower($extension) == 'png')
                    <i class="bx bxs-file-png display-6 text-success"></i>
                @elseif(in_array(strtolower($extension), ['jpeg', 'jpg']))
                    <i class="bx bxs-file-jpg display-6 text-warning"></i>
                @else
                    <i class="bx bxs-file display-6 text-muted"></i>
                @endif
            </div>
        </div>
        
        <div class="accordion mt-3" id="accordion-{{ str_replace('.', '-', $filename) }}">
            <div class="accordion-item">
                <button type="button" class="accordion-button collapsed text-uppercase text-dark" data-bs-toggle="collapse" data-bs-target="#accordion-id-{{ str_replace('.', '-', $filename) }}" aria-expanded="false" aria-controls="accordion-id-{{ str_replace('.', '-', $filename) }}">
                    <i class="bx bx-folder-open me-2"></i>{{ $filename }}
                </button>
                <div id="accordion-id-{{ str_replace('.', '-', $filename) }}" class="accordion-collapse collapse" data-bs-parent="#accordion-{{ str_replace('.', '-', $filename) }}">
                    @if(strtolower($extension) == 'pdf')
                        <a class="btn btn-primary btn-sm my-3" download href="{{ $path }}">
                            <i class="bx bx-download me-1"></i>{{ __('menu.general.download') }}
                        </a>
                    @elseif(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                        <img src="{{ $path }}" class="img-fluid" alt="Preview" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
