@extends('layouts.master')
@section('title',"Sliders")
@section('content')
    <main id="main-container">

        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Slider</h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Nizamlamalar</li>
                            <li class="breadcrumb-item active" aria-current="page">Slider</li>
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
                    <button type="button" class="btn btn-outline-success mb-3" data-toggle="modal" data-target="#add">Əlavə Et</button>
                    <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">#</th>
                            <th style="width: 25%">Slider</th>
                            <th class="d-none d-sm-table-cell" style="width: 30%;">Url</th>
                            <th class="d-none d-sm-table-cell" style="width: 15%;">Status</th>
                            <th style="width: 25%;">Əməliyyatlar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sliders as $slider)
                            <tr>
                                <td>{{ $slider->id }}</td>
                                <td>{{ $slider->name }}</td>
                                <td>{{ $slider->url }}</td>
                                <td>
                                    @if($slider->status=="1")
                                        <span class="badge badge-success">Aktiv</span>
                                    @elseif($slider->status=="0")
                                        <span class="badge badge-danger">Deaktiv</span>
                                    @endif
                                </td>
                                <td>
                                    <button onclick="SliderUpdateView({{ $slider->id }})" class="btn btn-outline-info">Redaktə Et</button>
                                    <button onclick="SliderDelete({{ $slider->id }})" class="btn btn-outline-danger">Sil</button>
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


    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Slider əlavəsi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('SliderPost') }}"  enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="add_name" class="col-form-label">Adı:</label>
                            <input type="text" class="form-control" name="add_name" id="add_name">
                        </div>
                        <div class="form-group">
                            <label for="add_url" class="col-form-label">Url:</label>
                            <input type="url" class="form-control" name="add_url" id="add_url">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" data-toggle="custom-file-input"
                                   id="dm-profile-edit-avatar" name="image">
                            <label class="custom-file-label" for="dm-profile-edit-avatar">Şəkil Seç</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
                            <button type="submit" class="btn btn-primary">Əlavə Et</button>
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
@endsection

@section('js')
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/general.js') }}"></script>
@endsection
