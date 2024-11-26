@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>DAFTAR PRODUK</h4>
                        <h6>Halaman Produk</h6>
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
                <div class="page-btn">
                    <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#tambahProduk"><i
                            data-feather="plus-circle" class="me-2"></i>TAMBAH PRODUK</a>
                </div>
            </div>

            <div class="card-body pb-0">
                <div class="table-top table-top-two table-top-new">
                    <div class="search-set mb-0">
                        <div class="total-employees">
                            <h6><i data-feather="shopping-bag" class="feather-user"></i>Total Produk
                                <span></span>
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

            <div class="pos-products">
                <div class="tabs_container">
                    <div class="tab_content">
                        <div class="row">
                            @foreach ($produk as $item)
                                <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3" data-name="{{ $item->nama }}"
                                    data-kode="{{ $item->kodeproduk }}">
                                    <div class="product-info default-cover card">
                                        <a href="javascript:void(0);" class="img-bg">
                                            <img src="{{ asset('storage/Produk/' . $item->image) }}" alt="Products">
                                        </a>
                                        <h6 class="cat-name"><a href="javascript:void(0);"> {{ $item->kodeproduk }}</a>
                                        </h6>
                                        <h6 class="product-name"><a href="javascript:void(0);">{{ $item->nama }}</a></h6>
                                        <div class="d-flex align-items-center justify-content-between price">
                                            <span>Berat {{ $item->berat }} /gram</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between price">
                                            <span>Karat {{ $item->karat }}</span>
                                            <p>Harga {{ 'Rp.' . ' ' . number_format($item->harga_jual) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Pegawai -->
    <div class="modal fade" id="tambahProduk">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Produk</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form action="/produk" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Berat</label>
                                <input type="text" name="berat" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Karat</label>
                                <input type="text" name="karat" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Harga Jual</label>
                                <input type="text" name="hargajual" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Harga Beli</label>
                                <input type="text" name="hargabeli" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis</label>
                            <select class="select" name="jenis_id">
                                <option>Pilih Jenis</option>
                                @foreach ($jenis as $item)
                                    <option value="{{ $item->id }}"> {{ $item->jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" rows="4" name="keterangan"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6 new-employee-field">
                                <label class="form-label">Image</label>
                                <div class="profile-pic-upload">
                                    <div class="profile-pic active-profile preview" id="preview">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Image</label>
                                <div class="col-md-12">
                                    <input id="image" type="file" class="form-control" name="image_file">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="select" name="status">
                                <option>Pilih Status</option>
                                <option value="1"> Aktif</option>
                                <option value="2"> Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Pegawai -->

    <script>
        const imgInput = document.getElementById('image')
        const previewImage = document.getElementById('preview')

        imgInput.addEventListener("change", () => {
            const file = imgInput.files[0]
            const reader = new FileReader;

            reader.addEventListener("load", () => {
                previewImage.innerHTML = ""
                const img = document.createElement("img")
                img.src = reader.result

                previewImage.appendChild(img)
            })

            reader.readAsDataURL(file)
        })
    </script>
@endsection
