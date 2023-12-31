@foreach ($tables as $item)
    <div class="col-xl-3 col-lg-4 col-md-6 pb-3" data-type="{{ $item->area_id }}">
        <div class="pos-checkout-table in-use">
            <a href="{{ route('sale.choose_product', $item->id) }}"
                class="pos-checkout-table-container {{ 'pos-table ' . $item->id }}">
                <div class="pos-checkout-table-header">
                    @if ($item->status_order == 'active')
                        <div class="status" style="color: green!important" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Bàn đang có người sử dụng"><i class="fa fa-circle fa-2xl"></i>
                        </div>
                    @elseif($item->booking_id != null)
                        <div class="status text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="Bàn được đặt"><i class="fa fa-circle fa-2xl"></i></div>
                    @else
                        <div class="status text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        title="Bàn trống"><i class="fa fa-circle fa-2xl"></i></div>
                    @endif
                    <div class="fw-semibold">Bàn</div>
                    <div class="fw-bold fs-1">{{ $item->name }}</div>
                    {{-- <div class="fs-13px text-body text-opacity-50">9 order</div> --}}
                </div>
                @if ($item->status_order == 'active')
                    <div class="pos-checkout-table-info small">
                        <div class="row">
                            <div class="col-6 d-flex justify-content-center">
                                <div class="w-20px"><i class="far fa-user text-body text-opacity-50"></i></div>
                                <div class="w-120px">{{ $item->order->customer_name ?? '' }}</div>
                            </div>
                            <div class="col-6 d-flex justify-content-center">
                                <div class="w-20px"><i class="far fa-clock text-body text-opacity-50"></i></div>
                                <div class="w-120px">
                                    {{ $item->order && $item->status_order == 'active' ? date('d/m/Y H:i', strtotime($item->order->created_at)) : '' }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex justify-content-center">
                                <div class="w-20px"><i class="fa fa-receipt text-body text-opacity-50"></i></div>
                                <div class="w-120px">
                                    {{ $item->order && $item->status_order == 'active' ? number_format($item->order->total, 0, ',', '.') . ' đ' : '' }}
                                </div>
                            </div>
                            <div class="col-6 d-flex justify-content-center">
                                <div class="w-20px"><i class="fa fa-dollar-sign text-body text-opacity-50"></i></div>
                                <div class="w-120px">
                                    {{ $item->status_order == 'active' && $item->status_order == 'active' ? 'Chưa thanh toán' : '' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($item->booking_id != null)
                    <div class="pos-checkout-table-info small">
                        <div class="row">
                            <div class="col-6 d-flex justify-content-center">
                                <div class="w-20px"><i class="far fa-user text-body text-opacity-50"></i></div>
                                <div class="w-120px">{{ $item->booking->name ?? '' }}</div>
                            </div>
                            <div class="col-6 d-flex justify-content-center">
                                <div class="w-20px"><i class="far fa-clock text-body text-opacity-50"></i></div>
                                <div class="w-120px">
                                    Đặt trước
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex justify-content-center">
                                <div class="w-20px"><i class="fas fa-phone text-body text-opacity-50"></i></div>
                                <div class="w-120px">{{ $item->booking->phone ?? '' }}</div>
                            </div>
                            <div class="col-6 d-flex justify-content-center">
                                <div class="w-20px"><i class="far fa-hashtag text-body text-opacity-50"></i></div>
                                <div class="w-120px">
                                    {{ $item->booking->quantity ?? 1 }} người
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="pos-checkout-table-info small" style="height: 50px">
                    </div>
                @endif
            </a>
        </div>
    </div>
@endforeach
