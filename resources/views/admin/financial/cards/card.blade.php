@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/admin/vendor/owl.carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/owl.carousel/owl.theme.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        .credit-card,
        .credit-card2,
        .credit-card3,
        .credit-card4,
        .credit-card5,
        .credit-card6 {
            width: 350px;
            height: 200px;
            border-radius: 10px;
            color: white;
            padding: 20px;
            position: relative;
            margin-bottom: 20px;
            border: none;
        }

        .credit-card {
            background: linear-gradient(135deg, #0D324D 0%, rgb(214, 172, 219) 100%);
        }

        .credit-card2 {
            background: linear-gradient(135deg, rgb(69, 74, 77) 0%, rgb(147, 166, 185) 100%);
        }

        .credit-card3 {
            background: linear-gradient(135deg, #5D4157 0%, #A8CABA 100%);
        }

        .credit-card4 {
            background: linear-gradient(135deg, #403A3E 0%, #BE5869 100%);
        }

        .credit-card5 {
            background: linear-gradient(135deg, #2C3E50 0%, #4CA1AF 100%);
        }

        .credit-card6 {
            background: linear-gradient(135deg, #E65C00 0%, #F9D423 100%);
        }

        .card-number {
            font-size: 1.5em;
            letter-spacing: 2px;
            margin-top: 80px;
        }

        .card-name {
            position: absolute;
            bottom: 20px;
            left: 20px;
        }

        .card-level {
            font-size: 1.3em;
            letter-spacing: 1px;
            bottom: 20px;
            left: 20px;
        }

        .expiry-date {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 260px;
        }
    </style>

    <style>
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .custom-button {
            background-color: #0071bc;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .custom-button:hover {
            background-color: #005a93;
        }

        .custom-button:active {
            background-color: #003e66;
        }
    </style>

    <style>
        .selectable-card {
            cursor: pointer;
            border-radius: 10px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .selectable-card:hover {
            border-color: rgb(54, 102, 141);
        }

        .selectable-card.selected {
            border: 2px solid rgb(54, 102, 141);
            box-shadow: 0 0 10px rgba(10, 58, 83, 0.5);
        }
    </style>
@endpush

@section('content')
    @php
        $cardClasses = ['credit-card', 'credit-card2', 'credit-card3', 'credit-card4', 'credit-card5', 'credit-card6'];
    @endphp

    <section class="section">
        <div class="section-header">
            <h1> {{ trans('panel.make_cards') }} </h1>
        </div>

        <form action="{{ route('admin.generateKeys') }}" method="POST" style="width:100%;">
            @csrf

            <div class="row" style="margin-bottom:20px;">
                <div class="col-md-3">
                    <label for="cardType">{{ trans('panel.choose_card_type') }}</label>
                    <select id="cardType" name="type" class="form-control">
                        <option value="school">{{ trans('panel.schools') }}</option>
                        <option value="pos">{{ trans('panel.point_of_sales') }}</option>
                        <option value="other">{{ trans('panel.others') }}</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="subscribeId">{{ trans('panel.pack_name') }}</label>
                    <select id="subscribeId" name="subscribe_id" class="form-control">
                        @foreach ($subscribes as $subscribe)
                            <option value="{{ $subscribe->id }}" {{ $subscribe->id == 3 ? 'selected' : '' }}>
                                {{ $subscribe->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="expiresIn">{{ trans('panel.expiry_date') }}</label>
                    <input type="number" id="expiresIn" name="expires_in" class="form-control" value="6" />
                </div>

                <div class="col-md-3">
                    <label for="numberOfKeys">عدد البطاقات المراد إنشاؤها</label>
                    <input type="number" id="numberOfKeys" name="number_of_keys" class="form-control" value="100" />
                </div>
            </div>

            <div class="row mt-20">
                @foreach ($schoolLevels as $index => $level)
                    @php
                        $className = $cardClasses[$index % 6];
                    @endphp
                    <div class="col-md-4">
                        <div class="{{ $className }} selectable-card" data-level-id="{{ $level->id }}"
                            data-value="{{ $level->name }}">

                            <div class="logo">
                                <img src="{{ asset('store/1/abajim.png') }}" alt="Visa" width="80">
                            </div>
                            <div class="card-level">{{ $level->name }}</div>
                            <div class="card-number">XXX XXX XXX</div>
                            <div class="card-name">الكرطابلة</div>
                            <div class="expiry-date">XX/XX</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <input type="hidden" name="level_id" id="selectedLevelId" value="" />

            <div class="button-container">
                <button type="submit" class="custom-button">Generate Keys</button>
            </div>
        </form>

        <table class="table table-striped table-bordered mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Key</th>
                    <th>Ref</th>
                    <th>Pack Name</th>
                    <th>Status</th>
                    <th>Expires in (Months)</th>
                    <th>Level</th>
                    <th>Used</th>
                    <th>Printed</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="keysTableBody">
                @foreach ($keys as $key)
                    <tr>
                        <td>{{ $key->id }}</td>
                        <td>{{ $key->card_key }}</td>
                        <td>{{ $key->reference }}</td>
                        <td>{{ $key->subscribe->title }}</td>
                        <td>{{ $key->status }}</td>
                        <td>{{ $key->expires_in }}</td>
                        <td>{{ $key->level->name }}</td>
                        <td>{{ $key->is_used ? 'Yes' : 'No' }}</td>
                        <td>{{ $key->is_printed ? 'Yes' : 'No' }}</td>
                        <td>
                            <form method="POST" action="#" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-4">
            {{ $keys->links() }}
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script>
        document.querySelectorAll('.selectable-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.selectable-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                const levelId = this.getAttribute('data-level-id');
                document.getElementById('selectedLevelId').value = levelId;
            });
        });
    </script>

    <script>
        let currentPage = 1;

        function fetchKeys(page = 1) {
            axios.get(`/admin/generate-keys?page=${page}`)
                .then(function(response) {
                    const keysData = response.data;
                    const keys = keysData.data;
                    const pagination = keysData.links;
                    const tableBody = document.getElementById('keysTableBody');
                    tableBody.innerHTML = '';

                    keys.forEach(function(key, index) {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${key.id}</td>
                        <td>${key.key}</td>
                        <td>${key.subscribe_id}</td>
                        <td>${key.status}</td>
                        <td>${key.expires_in}</td>
                        <td>${key.level_id}</td>
                        <td>${key.created_at}</td>
                        <td>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    `;
                        tableBody.appendChild(row);
                    });
                    currentPage = page;
                })
                .catch(function(error) {
                    console.error('Error fetching keys:', error);
                });
        }

        document.getElementById('generateKeysButton').addEventListener('click', function() {
            fetchKeys();
        });
    </script>
@endpush
