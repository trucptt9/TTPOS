@if ($list->count() > 0)
    @php
        $paginate = $list->appends(request()->all())->links();
    @endphp
    @foreach ($list as $item)
        <tr>
            <td>
                @if ($item->image != null)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="" width="50" height="50">
                @else
                    <img src="{{ asset('images/image_none.png') }}" alt="" width="50" height="50">
                @endif
            </td>
            <td>
                {{ $item->code }}
            </td>
            <td>
                {{ $item->name }}
            </td>
            <td class="text-center">
                {{ $item->products_count }}
            </td>
            <td class="text-center">
                <div class="form-check form-check-sm form-check-custom form-check-solid justify-content-center">
                    <input name="status" class="form-check-input " type="checkbox" id={{ $item->id }}
                        {{ $item->status == 'active' ? 'checked' : '' }}
                        onclick="changeStatus('{{ $item->id }}')" />
                </div>
            </td>
            <td class="text-center d-flex justify-content-center">
                @can('product_category-update')
                    <a class="btn btn-light btn-edit" style="padding: 0px"
                        href="{{ route('product_category.detail', $item->id) }}">
                        <i class="ki-duotone ki-message-edit fs-2qx text-success">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </a>
                @endcan
                @can('product_category-delete')
                    <button class="btn btn-light btn-delete" style="padding: 0px"
                        onclick="confirmDelete('{{ $item->id }}')">
                        <i class="ki-duotone ki-trash fs-2qx text-danger">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                        </i>
                    </button>
                @endcan
            </td>
        </tr>
    @endforeach
    @if ($paginate != '')
        <tr>
            <td colspan="5">
                <div class="mt-2">
                    {{ $paginate }}
                </div>
            </td>
        </tr>
    @endif
@else
    <tr>
        <td colspan="6" class="text-center no-data">
            Không tìm thấy dữ liệu!
        </td>
    </tr>
@endif
