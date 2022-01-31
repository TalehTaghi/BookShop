@extends('layouts.master')
@section('title',"Settings | Contacts")
@section('content')
    <main id="main-container">

        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Ümumi Nizamlamalar</h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Nizamlamalar</li>
                            <li class="breadcrumb-item active" aria-current="page">Ümumi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
            <!-- Elements -->
            <div class="block block-rounded">
                @include('layouts.errors')
                <div class="block-content">
                    <form action="{{ route('contactsPost') }}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <!-- Basic Elements -->
                        <div class="row push">
                            <div class="col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" value="{{ $data[0]->email }}" />
                                </div>
                                <div class="form-group">
                                    <label for="phone1">Nömrə 1</label>
                                    <input type="text" class="form-control" id="phone1" name="phone1" value="{{ $data[0]->phone1 }}" />
                                </div>
                                <div class="form-group">
                                    <label for="phone2">Nömrə 2</label>
                                    <input type="text" class="form-control" id="phone2" name="phone2" value="{{ $data[0]->phone2 }}" />
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $data[0]->address }}" />
                                </div>
                                <button class="btn btn-outline-primary">Dəyişdir</button>
                            </div>
                        </div>
                        <!-- END Basic Elements -->

                    </form>
                </div>
            </div>
            <!-- END Elements -->
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
@endsection
