@extends('layouts.admin')
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb-4 mt-1">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <h4 class="font-weight-bold">Dashboard Penjualan</h4>
                        <div class="form-group mb-0 vanila-daterangepicker d-flex flex-row">
                            <div class="date-icon-set">
                                <input type="text" name="start" class="form-control" placeholder="Tanggal Mulai">
                                <span class="search-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="" width="20" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </span>
                            </div>
                            <span class="flex-grow-0">
                                <span class="btn">-</span>
                            </span>
                            <div class="date-icon-set">
                                <input type="text" name="end" class="form-control" placeholder="Tanggal Selesai">
                                <span class="search-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="" width="20" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <p class="mb-2 text-secondary">Total Penjualan</p>
                                            <h5 class="mb-0 font-weight-bold">Rp. 25.500.000</h5>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0 mt-2 text-success font-weight-bold">+3.55%</p>
                                        <small class="mb-0 mt-2 text-underline text-secondary">Lihat Detail</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <p class="mb-2 text-secondary">Total Keuntungan</p>
                                            <h5 class="mb-0 font-weight-bold">Rp. 25.500.000</h5>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0 mt-2 text-success font-weight-bold">+3.55%</p>
                                        <small class="mb-0 mt-2 text-underline text-secondary">Lihat Detail</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <p class="mb-2 text-secondary">Total Transaksi</p>
                                            <h5 class="mb-0 font-weight-bold">47</h5>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0 mt-2 text-success font-weight-bold">+3.55%</p>
                                        <small class="mb-0 mt-2 text-underline text-secondary">Lihat Detail</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <h4 class="font-weight-bold">Laporan Penjualan</h4>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div><svg width="24" height="24" viewBox="0 0 24 24" fill="primary"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="3" y="3" width="18" height="18" rx="2"
                                                        fill="#324253" />
                                                </svg>
                                                <span>Pendapatan</span>
                                            </div>
                                            <div class="ml-3"><svg width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="3" y="3" width="18" height="18" rx="2"
                                                        fill="#4788ff" />
                                                </svg>
                                                <span>Pengeluaran</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="chart-apex-column-01" class="custom-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-header card-header-border d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Produk Terlaris</h4>
                            </div>
                        </div>
                        <div class="card-body-list">
                            <ul class="list-style-3 mb-0">
                                <li class="p-3 list-item d-flex justify-content-start align-items-center">
                                    <div class="avatar">
                                        <img class="avatar avatar-img avatar-60 rounded"
                                            src="{{ asset('images/products/mukena.png') }}" alt="1.jpg">
                                    </div>
                                    <div class="list-style-detail ml-3 mr-2">
                                        <p class="mb-0">Mukena Travel Compact</p>
                                    </div>
                                    <div class="list-style-action d-flex justify-content-end ml-auto">
                                        <h6 class="font-weight-bold">50 Terjual</h6>
                                    </div>
                                </li>
                                <li class="p-3 list-item d-flex justify-content-start align-items-center">
                                    <div class="avatar">
                                        <img class="avatar avatar-img avatar-60 rounded"
                                            src="{{ asset('images/products/koko.png') }}" alt="2.jpg">
                                    </div>
                                    <div class="list-style-detail ml-3 mr-2">
                                        <p class="mb-0">Baju Koko Zaren</p>
                                    </div>
                                    <div class="list-style-action d-flex justify-content-end ml-auto">
                                        <h6 class="font-weight-bold">30 Terjual</h6>
                                    </div>
                                </li>
                                <li class="p-3 list-item d-flex justify-content-start align-items-center">
                                    <div class="avatar">
                                        <img class="avatar avatar-img avatar-60 rounded"
                                            src="{{ asset('images/products/Sarung.png') }}" alt="3.jpg">
                                    </div>
                                    <div class="list-style-detail ml-3 mr-2">
                                        <p class="mb-0">Sarung BHS</p>
                                    </div>
                                    <div class="list-style-action d-flex justify-content-end ml-auto">
                                        <h6 class="font-weight-bold">25 Terjual</h6>
                                    </div>
                                </li>
                                <li class="p-3 list-item d-flex justify-content-start align-items-center">
                                    <div class="avatar">
                                        <img class="avatar avatar-img avatar-60 rounded"
                                            src="{{ asset('images/products/gamis.png') }}" alt="4.jpg">
                                    </div>
                                    <div class="list-style-detail ml-3 mr-2">
                                        <p class="mb-0">Gamis Wanita</p>
                                    </div>
                                    <div class="list-style-action d-flex justify-content-end ml-auto">
                                        <h6 class="font-weight-bold">10 Terjual</h6>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fit-icon-2 text-info text-center">
                                            <div id="circle-progress-01"
                                                class="circle-progress-01 circle-progress circle-progress-light"
                                                data-min-value="0" data-max-value="100" data-value="62"
                                                data-type="percent"></div>
                                        </div>
                                        <div class="ml-3">
                                            <h5 class="text-white font-weight-bold">1,860 <small> /3k
                                                    Target</small></h5>
                                            <small class="mb-0">Order In Period</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="font-weight-bold">Total Pelanggan</h6>
                                        <div class="d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="20"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span class=" font-weight-bold">47</span>
                                        </div>
                                    </div>
                                    {{-- <p class="mb-0">Pages views per day</p> --}}
                                    <div id="chart-apex-column-02" class="custom-chart"></div>
                                    {{-- <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0 pt-3 ">25 June</p>
                                        <p class="mb-0 pt-3 ">26 June</p>
                                        <p class="mb-0 pt-3 ">27 June</p>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="font-weight-bold mb-3">Kategori Terlaris </h4>
                            <div id="chart-apex-column-03" class="custom-chart"></div>
                            <div class="d-flex justify-content-around align-items-center">
                                <div><svg width="24" height="24" viewBox="0 0 24 24" fill="#ffbb33"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="3" y="3" width="18" height="18" rx="2" fill="#ffbb33" />
                                    </svg>

                                    <span>Baju Pria</span>
                                </div>
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="#e60000"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="3" y="3" width="18" height="18" rx="2" fill="#e60000" />
                                    </svg>

                                    <span>Sarung</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around align-items-center mt-3">
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="primary"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="3" y="3" width="18" height="18" rx="2" fill="#04237D" />
                                    </svg>

                                    <span>Mukenah</span>
                                </div>
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="primary"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="3" y="3" width="18" height="18" rx="2" fill="#8080ff" />
                                    </svg>

                                    <span>Aksesoris</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page end  -->
        </div>
    </div>
@endsection
