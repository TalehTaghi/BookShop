@extends('layouts.master')
@section("title", "Categories")
@section('content')
    <main id="main-container">

        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Kateqoriya siyahı</h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Məhsullar</li>
                            <li class="breadcrumb-item active" aria-current="page">Kateqoriya siyahı</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
            <!-- Dynamic Table Full -->
            <div class="block block-rounded">
                @include('layouts.errors')
                <div class="block-header block-header-default">
                    {{--                    <h3 class="block-title">Dynamic Table <small>Full</small></h3>--}}
                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">#</th>
                            <th>Kateqoriya adı</th>
                            <th class="d-none d-sm-table-cell" style="width: 30%;">Əsas kateqoriyası</th>
                            <th class="d-none d-sm-table-cell" style="width: 15%;">Status</th>
                            <th style="width: 15%;">Əməliyyatlar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($all_data as $data)
                            <tr style="text-align: center">
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->mainCategoryData($data->main_category)->name ?? "--" }}</td>
                                <td>
                                    <span class="badge {{ $data->status === "0" ? "badge-danger" : "badge-success" }} ">{{ $data->status === "0" ? "Deaktiv" : "Aktiv" }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm" onclick="CategoryUpdateView({{ $data->id }})">Redaktə et</button>
                                    <button class="btn btn-outline-danger btn-sm">Sil</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END Dynamic Table Full -->
        </div>
        <!-- END Page Content -->

        <div class="modal" id="categoryEdit" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Müştəri</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('categoryEdit') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="edit_id_category" id="edit_id_category" />
                            <div class="form-group">
                                <label for="edit_name_category" class="col-form-label">Adı:</label>
                                <input type="text" class="form-control" name="edit_name_category" id="edit_name_category">
                            </div>
                            <div class="form-group">
                                <label for="edit_main_category">Əsas kateqoriya</label>
                                <select class="form-control" name="edit_main_category" id="edit_main_category">
                                    <option value="0">Əsas kateqoriya yoxdur</option>
                                    @foreach($all_data as $data)
                                        <option value="{{ $data->id }}">
                                            {{ $data->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_status_category" class="col-form-label">Status:</label>
                                <select name="edit_status_category" id="edit_status_category" class="form-control">
                                    <option value="0">Deaktiv</option>
                                    <option value="1">Aktiv</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
                                <button type="submit" class="btn btn-primary">Dəyişdir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/General.js') }}"></script>
@endsection
