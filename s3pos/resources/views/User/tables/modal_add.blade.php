<div class="modal fade" id="modal_add_table" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Thêm bàn</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary btn-close"
                    data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body py-lg-10 px-lg-10">
                <!--begin::Stepper-->
                <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid"
                    id="kt_modal_create_app_stepper">
                    <!--begin::Aside-->

                    <!--begin::Aside-->
                    <!--begin::Content-->
                    <div class="flex-row-fluid py-lg-5 px-lg-15">
                        <!--begin::Form-->
                        <form class="form" novalidate="novalidate"
                            id="kt_modal_create_app_form">
                            <!--begin::Step 4-->
                            <div data-kt-stepper-element="content" class="current">
                                <div class="w-100">
                                    <div class="row">
                                        <div
                                            class="col-md-6 d-flex flex-column mb-7 fv-row">
                                            <!--begin::Label-->
                                            <label
                                                class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                <span class="required">Tên bàn</span>
                                                <span class="ms-1"
                                                    data-bs-toggle="tooltip"
                                                    title="Specify a card holder's name">
                                                    <i
                                                        class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                            <input type="text"
                                                class="form-control form-control-solid"
                                                placeholder="Nhập tên bàn"
                                                name="name" value="" />
                                        </div>

                                        <div
                                            class=" col-md-6 d-flex flex-column mb-7 fv-row">
                                            <!--begin::Label-->
                                            <label
                                                class="fs-6 fw-semibold form-label mb-2">Mã
                                                bàn</label>
                                            <!--end::Label-->
                                            <!--begin::Input wrapper-->
                                            <div class="position-relative">
                                                <!--begin::Input-->
                                                <input type="text"
                                                    class="form-control form-control-solid"
                                                    placeholder="Nhập mã hoặc mã tự sinh"
                                                    name="code" value="" />
                                                <!--end::Input-->
                                                <!--begin::Card logos-->
                                                <div
                                                    class="position-absolute translate-middle-y top-50 end-0 me-5">
                                                    <img src="assets/media/svg/card-logos/visa.svg"
                                                        alt=""
                                                        class="h-25px" />
                                                    <img src="assets/media/svg/card-logos/mastercard.svg"
                                                        alt=""
                                                        class="h-25px" />
                                                    <img src="assets/media/svg/card-logos/american-express.svg"
                                                        alt=""
                                                        class="h-25px" />
                                                </div>
                                                <!--end::Card logos-->
                                            </div>
                                            <!--end::Input wrapper-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div
                                            class="col-md-6 d-flex flex-column mb-7 fv-row">
                                            <!--begin::Label-->
                                            <label
                                                class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                <span class="required">Loại bàn</span>
                                                <span class="ms-1"
                                                    data-bs-toggle="tooltip"
                                                    title="Specify a card holder's name">
                                                    <i
                                                        class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                            <input type="text"
                                                class="form-control form-control-solid"
                                                placeholder="Số ghế của bàn"
                                                name="capacity" value="" />
                                        </div>

                                        <div
                                            class=" col-md-6 d-flex flex-column mb-7 fv-row">
                                            <!--begin::Label-->
                                            <label
                                                class="required fs-6 fw-semibold form-label mb-2">Khu vực</label>
                                                <span class="ms-1"
                                                data-bs-toggle="tooltip"
                                                title="Specify a card holder's name">
                                                
                                            </span>
                                           <select name="area_id" id="" class="form-select form-select-solid" data-control="select2" data-hide-search="true">
                                            <option value="">kv 1</option>
                                            <option value="">kv 2</option>
                                           </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div
                                            class="col-md-6 d-flex flex-column mb-7 fv-row">
                                            <!--begin::Label-->
                                            <label
                                                class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                <span class="required">Số ghế</span>
                                                <span class="ms-1"
                                                    data-bs-toggle="tooltip"
                                                    title="Specify a card holder's name">
                                                    <i
                                                        class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                            <input type="number"
                                                class="form-control form-control-solid"
                                                placeholder="Số ghế của bàn"
                                                name="capacity" value="" />
                                        </div>

                                        <div
                                            class=" col-md-6 d-flex flex-column mb-7 fv-row">
                                            <!--begin::Label-->
                                            <label
                                                class="required fs-6 fw-semibold form-label mb-2">Trạng thái</label>
                                                <span class="ms-1"
                                                data-bs-toggle="tooltip"
                                                title="Specify a card holder's name">
                                                
                                            </span>
                                           <select name="status" id="" class="form-select form-select-solid" data-control="select2" data-hide-search="true">
                                            <option value="1">Hiển thị</option>
                                            <option value="">Ẩn</option>
                                           </select>
                                        </div>
                                    </div>


                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Mô tả</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <textarea class="form-control" aria-label="With textarea" rows="2"></textarea>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            

                            <!--begin::Actions-->
                            <div class="text-center pt-10">
                                <button type="reset" class="btn btn-light me-3 btn-cancle"
                                    data-kt-users-modal-action="cancel">Hủy</button>
                                <button type="submit" class="btn btn-primary"
                                    data-kt-users-modal-action="submit">
                                    <span class="indicator-label">Lưu</span>
                                    <span class="indicator-progress">Please wait...
                                        <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Stepper-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>