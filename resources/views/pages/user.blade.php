@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>DAFTAR USER PEGAWAI</h4>
                        <h6>Halaman User</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i data-feather="rotate-ccw"
                                class="feather-rotate-ccw"></i></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                data-feather="chevron-up" class="feather-chevron-up"></i></a>
                    </li>
                </ul>
            </div>

            <!-- /product list -->
            <div class="card-body pb-0">
                <div class="table-top table-top-two table-top-new">
                    <div class="search-set mb-0">
                        <div class="total-employees">
                            <h6><i data-feather="users" class="feather-user"></i>Total User
                                <span>{{ $count }}</span>
                            </h6>
                        </div>
                        <div class="search-input">
                            <a href="#" class="btn btn-searchset"><i data-feather="search"
                                    class="feather-search"></i></a>
                            <input type="search" id="searchInput" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /product list -->


            <div class="employee-grid-widget">
                <div class="row">
                    @foreach ($user as $item)
                        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 employee-item"
                            data-name="{{ $item->pegawai->nama }}" data-nip="{{ $item->pegawai->nip }}"
                            data-email="{{ $item->email }}">
                            <div class="employee-grid-profile">
                                <div class="profile-head">
                                    <label class="checkboxs">
                                        <span class="checkmarks"></span>
                                    </label>
                                    <div class="profile-head-action">
                                        @if ($item->status == 1)
                                            <span class="badge badge-linesuccess text-center w-auto me-1">Active</span>
                                        @else
                                            <span class="badge badge-linedanger text-center w-auto me-1">InActive</span>
                                        @endif
                                        <div class="dropdown profile-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false"><i data-feather="more-vertical"
                                                    class="feather-user"></i></a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a data-bs-effect="effect-sign" data-bs-toggle="modal"
                                                        href="#modaledit{{ $item->id }}" class="dropdown-item"><i
                                                            data-feather="edit" class="info-img"></i>Edit</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-info">
                                    <div class="profile-pic profile">
                                        @if ($item->pegawai->image != null)
                                            <img src="{{ asset('storage/avatar/' . $item->pegawai->image) }}"
                                                alt="avatar">
                                        @else
                                            <img src="{{ asset('assets') }}/img/notfound.png" alt="avatar">
                                        @endif
                                    </div>
                                    <h5>NIP : {{ $item->pegawai->nip }}</h5>
                                    <h4>{{ $item->pegawai->nama }}</h4>
                                    <span>{{ $item->role->role }}</span>
                                </div>
                                <ul class="department">
                                    <li>
                                        Email
                                        @if ($item->email == null)
                                            <span> - </span>
                                        @else
                                            <span>{{ $item->email }}</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal fade" id="modaledit{{ $item->id }}">
                            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit User</h4><button aria-label="Close" class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="user/{{ $item->id }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="name" value="{{ $item->pegawai->nama }}"
                                                    class="form-control" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="text" name="email" value="{{ $item->email }}"
                                                    class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-cancel"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save
                                                changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="{{ asset('js') }}/user.js" type="text/javascript"></script>
@endsection
