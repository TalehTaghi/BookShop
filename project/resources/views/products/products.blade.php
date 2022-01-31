@extends('layouts.master')
@section('title',"Products")
@section('content')
    <main id="main-container">

        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Məhsulların Siyahısı</h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Məhsullar</li>
                            <li class="breadcrumb-item active" aria-current="page">Məhsul Siyahı</li>
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
                <div class="block-header block-header-default">
                    @include('layouts.errors')
                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                        <thead>
                        <tr style="text-align: center">
                            <th>#</th>
                            <th>Məhsul adı</th>
                            <th>Müəllif</th>
                            <th>Kateqoriya</th>
                            <th>Qiymət</th>
                            <th>Oxunma sayı</th>
                            <th>Status</th>
                            <th>Əməliyyatlar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($all_data as $data)
                            <tr style="text-align: center">
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->author }}</td>
                                <td>{{ $data->CategoryGet($data->category_id) ?? "Kateqoriya tapılmadı" }}</td>
                                <td>{{ $data->price }}</td>
                                <td>{{ $data->read_count }}</td>
                                <td>
                                    <span class="badge  {{ $data->status==="0" ? "badge-danger" : "badge-success" }} ">{{ $data->status==="0" ? "Deaktiv" : "Aktiv" }} </span>
                                </td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm" onclick="ProductUpdateView({{ $data->id }},'{{ asset('') }}')">Redaktə et</button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="ProductDelete({{ $data->id }})">Sil</button>
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
    </main>

    <div class="modal fade" id="productView" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Məhsul</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('productEdit') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="edit_id" id="edit_id" />
                        <div class="form-group">
                            <label for="edit_name" class="col-form-label">Məhsul adı:</label>
                            <input type="text" class="form-control" name="edit_name" id="edit_name">
                        </div>
                        <div class="form-group">
                            <label for="edit_author" class="col-form-label">Müəllif:</label>
                            <input type="text" class="form-control" name="edit_author" id="edit_author">
                        </div>
                        <div class="form-group">
                            <label for="edit_category">Kateqoriya</label>
                            <select class="form-control" id="edit_category" name="edit_category">
                                <option value="" disabled="disabled" selected="selected">Seçim edin</option>
                                @foreach($categories as $category)
                                    <optgroup label="{{ $category->name }}">
                                        @if($category->SubCategoryGet($category->id))
                                            @foreach($category->SubCategoryGet($category->id) as $subcategory)
                                                <option
                                                    value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="" disabled="disabled">Alt kateqoriya yoxdur</option>
                                        @endif
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_about" class="col-form-label">Açıqlama:</label>
                            <textarea id="edit_about" name="edit_about" class="js-summernote"></textarea>
                        </div>
                        <div class="custom-file mb-2">
                            <input type="file" class="custom-file-input" data-toggle="custom-file-input"
                                   id="edit_img" name="edit_img">
                            <label class="custom-file-label" for="edit_img">Şəkil Seç</label>
                        </div>
                        <div id="current_img"></div>
                        <div class="form-group">
                            <label for="edit_price" class="col-form-label">Qiymət:</label>
                            <input type="number" min="0.01" step="0.01" class="form-control" name="edit_price" id="edit_price">
                        </div>
                        <div class="form-group">
                            <label for="edit_status" class="col-form-label">Status:</label>
                            <select name="edit_status" id="edit_status" class="form-control">
                                <option value="1">Aktiv</option>
                                <option value="0">Deaktiv</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
                            <button type="submit" class="btn btn-primary">Redaktə Et</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('js')
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/general.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>jQuery(function () { Dashmix.helpers(['summernote']); });</script>
@endsection
