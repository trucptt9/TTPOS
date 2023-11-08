<!--begin::Card-->
<div class="card">
    <div class="report">

    </div>
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">

        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                <button  class="btn btn-light-primary btn-add">
                    <i class="ki-duotone ki-plus fs-2"></i>Thêm </button>
            </div>
            @include('User.promotion.modal_add')

        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body py-4 table-loading">
        <!--begin::Table-->
        <table class="table align-middle table-bordered fs-6 gy-5">

            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                    
                    <th class="w-140px">Mã</th>
                    <th class="">Tên chương trình</th>
                    <th class="w-240px">Thời gian áp dụng</th>
                    <th class="w-140px">Giá trị</th>
                    <th class="w-140px">Điều kiện</th>
                    <th class="w-240px">Mô tả</th>
                    <th class="w-125px text-center">Trạng thái</th>
                    <th class=" w-90px text-center">#</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 fw-semibold" id="load-table">
                <tr>
                    <td colspan="8" class="text-center no-data">
                        Không tìm thấy dữ liệu!
                    </td>
                </tr>
            </tbody>
        </table>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->