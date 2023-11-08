@extends('user.layout.main')
@section('style')
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="user/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
@endsection
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-5 " id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">

                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                    <!--begin::Item-->
                    <h5 class="breadcrumb-item text-white opacity-75">
                        <a href=".#" class="text-white text-hover-primary">Khuyến mãi</a>
                    </h5>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <h5 class="breadcrumb-item">
                        <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
                    </h5>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <h5 class="breadcrumb-item text-white opacity-75">Nhóm khách hàng</h5>
                    <!--end::Item-->


                </ul>
                <!--end::Breadcrumb-->
            </div>
            <div class="d-flex align-items-center py-3 py-md-1">
                <!--begin::Wrapper-->
                <form action="" id="form-filter">


                    <div class="me-4 row">
                        <!--begin::Search-->
                        <input type="text" data-kt-user-table-filter="search" name="search"
                            class="form-control col form-control-solid w-250px ps-13 mx-3"
                            placeholder="Nhập nội dung cần tìm ... " />
                        <!--end::Search-->
                        <select class="form-select col filter-status form-filter select-picker" name="status">
                            <option selected value="">Trạng thái </option>
                            @foreach ($data['status'] as $key => $item)
                                <option value="{{ $key }}">{{ $item[0] }}</option>
                            @endforeach


                        </select>
                    </div>
                </form>
            </div>

        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->

    <!--begin::Main-->
    <!--begin::Root-->

    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Container-->
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    <!--begin::Post-->
                    <div class="content flex-row-fluid" id="kt_content">
                        @include('User.customer_group.content')
                    </div>
                </div>
            </div>
        </div>
        <!--end::Wrapper-->
    </div>



@endsection

@section('script')
    <script>
        const routeList = "{{ route('customer_group.list') }}";
        const routeUpdate = "{{ route('customer_group.update') }}";
        filterTable();

        function filterTable() {
            loadTable(routeList);
        };

        $('.btn-add').click(function(e) {
            e.preventDefault();
            $('#modal-add').trigger('reset');
            $('#modal-add').modal('show');
        })
        $('.btn-close').click(function(e) {
            e.preventDefault();
            $('#modal-add').trigger('reset');
            $('#modal-add').modal('hide');
        })
        $('.btn-cancle').click(function(e) {
            e.preventDefault();
            $('#modal-add').trigger('reset');
            $('#modal-add').modal('hide');
        })

        $('.close-btn2').click(function(e) {
            e.preventDefault();
            // $('#modal-edit').trigger('reset');
            $('#modal-edit').modal('hide');
        })
        function confirmDelete(id) {
            deleteData(id, "{{ route('customer_group.delete') }}");
        }

        function changeStatus(id) {
            $.post("{{ route('customer_group.update') }}", {
                id
            }, function(rs) {
                Toast.fire({
                    icon: rs?.type,
                    title: rs.message
                });
            });
        }
        $(document).ready(function() {
            $(document).on("click", ".btn-edit", function(e) {
                showSpinner(".table-loading");
                e.preventDefault();
                const url = $(this).attr('href');
                console.log(url)
                $.get(url, function(data) {
                    hideSniper(".table-loading");
                    console.log(data);
                    $('.content-update').html(data);
                    $('#modal-edit').modal('show');
                })
            })
        })
    </script>
    <!--begin::Custom Javascript(used for this page only)-->
    <script src=""></script>
    <script src="user/assets/js/custom/apps/user-management/users/list/table.js"></script>
    <script src="user/assets/js/custom/apps/user-management/users/list/export-users.js"></script>
    <script src="user/assets/js/custom/apps/user-management/users/list/add.js"></script>
    <script src="user/assets/js/widgets.bundle.js"></script>
    <script src="user/assets/js/custom/widgets.js"></script>
    {{-- <script src="user/assets/js/custom/apps/chat/chat.js"></script> --}}
    <script src="user/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="user/assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="user/assets/js/custom/utilities/modals/users-search.js"></script>
    <!--end::Custom Javascript-->
@endsection