<style>
    .table-permission td {
        min-width: 130px;
    }

    .table-permission td:first-child {
        min-width: 160px;
    }
</style>
<form action="{{ route('staff.update_permission') }}" method="POST">
    @csrf
    @can('staff-permission')
        <button type="submit" class="btn btn-sm btn-flex btn-primary" style="float:inline-end">
            Cập nhật</button>
    @endcan
    <div class="table-responsive w-100">
        <table class="table table-bordered mt-3 table-permission">
            <tr class="text-start bg-primary text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="text-center">Quyền</th>
                <th colspan="6" class="text-center">Thao tác</th>
            </tr>
            <input type="hidden" name="staff_id" id="" value="{{ $staff->id }}">
            <input type="hidden" name="name" id="" value="{{ $staff->name }}">
            @foreach ($modules as $module)
                @php
                    $permission = permission_detail($staff->id, $module->code);
                    $actions = json_decode($module->actions);
                    $action_permisisons = $permission ? json_decode($permission->actions) : [];
                @endphp
                <tr>
                    <td class="">
                        <div class="">
                            {{ $module->name }}
                            <input type="hidden" name="module_id" id="" value="{{ $module->id }}">
                        </div>
                    </td>
                    <td>
                        <?php
                        $check = true;
                        foreach ($actions as $action) {
                            if (!in_array($action->code, $action_permisisons)) {
                                $check = false;
                            }
                        }
                        ?>
                        <div class="form-check ">
                            <input type="checkbox" name="" id="{{ $module->id }}"
                                class="form-check-input check-all" {{ $check ? 'checked' : '' }}
                                id="check-all-{{ $module->id }}" data-id="{{ $module->id }}">
                            <label class="" for="{{ $module->id }}">
                                Tất cả
                            </label>
                        </div>
                    </td>
                    @foreach ($actions as $action)
                        <td>
                            <div class="form-check ">
                                <input id="{{ $action->code }}_{{ $module->id }}" type="checkbox"
                                    name="actions[{{ $module->code }}][]" value="{{ $action->code }}"
                                    class="form-check-input module-{{ $module->id }}"
                                    {{ in_array($action->code, $action_permisisons) ? ' checked ' : '' }}>
                                <label class="" for="{{ $action->code }}_{{ $module->id }}">
                                    {{ $action->name }}
                                </label>
                            </div>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
</form>
