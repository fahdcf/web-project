<!-- components/header.blade.php -->
<div class="header-container mb-4 ">
    <style>
        .header-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
    </style>

    <div class="header-grid">
        <div class="d-flex align-items-center gap-3">
            @isset($icon)
                {!! $icon !!}
            @endisset
            <h3 style="color: #330bcf; font-weight: 500;">{{ $heading ?? '' }}</h3>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
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
