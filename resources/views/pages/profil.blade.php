@extends('layouts.default')

@section('title', 'Profil Toko')

@push('css')
    <link href="/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css" rel="stylesheet" />
    <link href="/assets/plugins/dropzone/dist/min/dropzone.min.css" rel="stylesheet" />
    <link href="/assets/plugins/tag-it/css/jquery.tagit.css" rel="stylesheet" />
    <style>
        .table-no-border {
            width: 100%;
            border-collapse: collapse;
        }
        .table-no-border td, .table-no-border th {
            border: none;
            padding: 8px;
            vertical-align: top;
        }
        .table-no-border td:first-child {
            font-weight: bold;
            width: 200px;
            white-space: nowrap;
            text-align: left;
        }
        .table-no-border td:nth-child(2) {
            width: 10px;
            text-align: center;
        }
        .table-no-border td:nth-child(3) {
            padding-left: 10px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.min.js"></script>
    <script src="/assets/plugins/dropzone/dist/min/dropzone.min.js"></script>
    <script src="/assets/plugins/jquery-migrate/dist/jquery-migrate.min.js"></script>
    <script src="/assets/plugins/tag-it/js/tag-it.min.js"></script>
    <script src="/assets/js/demo/product-details.demo.js"></script>
@endpush

@section('content')
    <div class="d-flex align-items-center mb-3">
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/extra/products">Profil</a></li>
            </ol>
            <h1 class="page-header mb-0">Profil Toko</h1>
        </div>
    </div>
    
    <div class="card border-0 mb-4">
        <div class="card-header h6 mb-0 bg-none p-3">
            <i class="fa fa-store fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Informasi Toko
        </div>
        <div class="card-body">
            <table class="table-no-border">
                <tr>
                    <td>Nama Toko</td>
                    <td>:</td>
                    <td>Toko Data</td>
                </tr>
                <tr>
                    <td>Nomor NPWRD</td>
                    <td>:</td>
                    <td>100002031</td>
                </tr>
                <tr>
                    <td>Alamat Toko</td>
                    <td>:</td>
                    <td>Jalan surabaya No. 123</td>
                </tr>
                <tr>
                    <td>Email Toko</td>
                    <td>:</td>
                    <td>databumi@email.com</td>
                </tr>
                <tr>
                    <td>Pemilik Toko</td>
                    <td>:</td>
                    <td>Nama Pemilik</td>
                </tr>
                <tr>
                    <td>Telepon Toko</td>
                    <td>:</td>
                    <td>0812-3456-7890</td>
                </tr>
                <tr>
                    <td>Website Toko</td>
                    <td>:</td>
                    <td>www.databumi.id</td>
                </tr>
                <tr>
                    <td>Instagram Toko</td>
                    <td>:</td>
                    <td>@databumi.id</td>
                </tr>
            </table>

            <div class="row mt-4">
                <div class="col text-center">
                    <button type="button" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
