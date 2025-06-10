<!-- components/header.blade.php -->
<div class="header-container mb-4 ">
    <style>
        .header-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px
        }

        .header-title {
            color: #4723d9;
            font-weight: 600;
            font-size: 1.75rem;
            margin: 0;
        }

        .form-select {
            border-color: #e0e0e0;
            font-size: 0.9rem;
            padding: 8px 12px;
            border-radius: 6px;
            background-color: #f8f9fa;
            transition: border-color 0.2s;
        }

        .form-select:focus {
            border-color: #4723d9;
            box-shadow: 0 0 0 2px rgba(71, 35, 217, 0.2);
            outline: none;
        }

        .btn-primary {
            background-color: #4723d9;
            border-color: #4723d9;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: white;
            color: #4723d9;
            border-color: #4723d9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-primary {
            border-color: #4723d9;
            color: #4723d9;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-outline-primary:hover {
            background-color: #4723d9;
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-primary:hover .btn-text-prof {
            color: white;
        }

        .btn-text-emploi,
        .btn-text-prof {
            display: inline;
        }

        @media (max-width: 768px) {
            .header-container {
                padding: 15px;
            }

            .header-title {
                font-size: 1.5rem;
                margin-bottom: 15px;
                text-align: center;
            }

            .form-select,
            .btn-outline-primary {
                width: 100%;
                margin-bottom: 10px;
            }

            .btn-outline-primary {
                white-space: normal;
                text-align: center;
                padding: 10px 16px;
            }
        }

        /* Improved grid layout */
        .header-grid {
            display: grid;
            grid-template-columns: 1fr auto auto;
            gap: 1rem;
            align-items: center;
        }

        @media (max-width: 992px) {
            .header-grid {
                grid-template-columns: 1fr auto;
            }

            .header-title {
                grid-column: 1 / -1;
                text-align: center;
                margin-bottom: 10px;
                text-decoration: underline;
            }
        }

        @media (max-width: 768px) {
            .header-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .btn-outline-primary {
                white-space: normal;
                text-align: center;
                padding: 10px 16px;
                line-height: 1.3;
            }

            .btn-text-emploi,
            .btn-text-prof {
                display: inline;
                margin-bottom: 0;
            }

            .btn-text-emploi:after {
                content: " ";
            }
        }

        /* Previous styles remain the same */

        /* Enhanced export dropdown styles */
        .export-container {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .export-select {
            border: 1px solid #28a745;
            color: #28a745;
            background-color: white;
            border-radius: 6px;
            padding: 8px 32px 8px 12px;
            font-size: 0.9rem;
            font-weight: 500;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2328a745' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .export-select:hover {
            background-color: rgba(40, 167, 69, 0.05);
        }

        .export-select:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.25);
        }

        /* Existing export button styles */
        .btn-export {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        .btn-export:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .export-group {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }




        .dropdown-menu {
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #4723d9;
        }
    </style>

    <div class="header-grid">
        <div class="d-flex align-items-center gap-3">
            @isset($icon)
                {!! $icon !!}
            @endisset
            <h3 style="color: #330bcf; font-weight: 600;">{{ $heading ?? '' }}</h3>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            {{-- the importdata is a button entire code --}}
            @isset($importData)
                {!! $importData !!}
            @endisset
            @isset($exportData)
                <div class="export-group">
                    <div class="dropdown">
                        <button class="btn btn-success rounded fw-semibold dropdown-toggle" type="button"
                            id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-file-export"></i> {{ $exportData['buttonText'] ?? 'Export' }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                            @foreach ($exportData['options'] as $option)
                                <li>
                                    <a class="dropdown-item" href="{{ $option['route'] }}">
                                        {{ $option['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endisset

            @isset($buttons)
                @foreach ($buttons as $button)
                    <a href="{{ $button['route'] }}"
                        class="btn {{ $button['type'] === 'primary' ? 'btn-primary' : 'btn-outline-primary' }} rounded fw-semibold my-2">
                        @isset($button['bicon'])
                            {!! $button['bicon'] !!}
                        @endisset
                        {{ $button['text'] }}
                    </a>
                @endforeach
            @endisset
        </div>
    </div>
</div>
<style>
    .form-select {
        border-color: #e0e0e0;
        font-size: 0.9rem;
        padding: 8px 12px;
        border-radius: 6px;
        background-color: #f8f9fa;
        transition: border-color 0.2s;
    }

    .form-select:focus {
        border-color: #4723d9;
        box-shadow: 0 0 0 2px rgba(71, 35, 217, 0.2);
        outline: none;
    }

    .btn-primary {
        background-color: #4723d9;
        border-color: #4723d9;
        font-size: 0.9rem;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background-color: white;
        color: #4723d9;
        border-color: #4723d9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        font-size: 0.9rem;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-success:hover {
        background-color: white;
        color: #28a745;
        border-color: #28a745;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }



    .dropdown-menu {
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #4723d9;
    }

    .modal-content {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        border-bottom: 1px solid #e0e0e0;
    }

    .modal-footer {
        border-top: 1px solid #e0e0e0;
    }

    .form-control:focus {
        border-color: #4723d9;
        box-shadow: 0 0 0 2px rgba(71, 35, 217, 0.2);
    }

    .header-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
        justify-content: space-between;
    }

    @media (max-width: 992px) {
        .header-grid {
            flex-direction: column;
            align-items: stretch;
        }

        .header-title {
            text-align: center;
            margin-bottom: 1rem;
            text-decoration: underline;
        }
    }

    @media (max-width: 768px) {
        .header-container {
            padding: 15px;
        }

        .header-title {
            font-size: 1.5rem;
        }

        .header-grid>* {
            width: 100%;
        }

        .btn-primary,
        .btn-success {
            width: 100%;
            text-align: center;
        }
    }


    .modal-content {
        max-width: 90%;
        animation: fadeIn 0.3s;
    }

    @media (max-width: 768px) {
        .modal-content {
            max-width: 95%;
            margin: 1rem;
        }
    }
</style>
