@extends('profile.v2-profile-app')

@section('profile-content')
    <div class="profile-box-default">
        <h3 class="box-header clearfix">
            <span class="header-left"><a href="{{url('profile/cash-back')}}"><i class="fa fa-long-arrow-left"></i> BALANCE & PAYMENT</a></span>
            <span class="header-right">TRANSACTION HISTORY</span></h3>
        <div class="box-content">
            <div class="cb-history-box">
                <div class="form-filter">
                <form method="POST" action="{{url('/profile/cash-back/history')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-element-group filter-date-range">
                        <label>From <input type="text" name="start" id="start" class="form-control datepicker "
                        placeholder="All time" value="{{$start}}" /></label>
                        <label>To <input type="text" name="end" id="end" class="form-control datepicker "
                        placeholder="All time" value="{{$end}}"></label>
                    </div>
                    <div class="form-element-group">
                        <label>
                            <select class="form-control" name="slStatus">
                                @foreach($arrStatus as $v=>$k)
                                <option value="{{$k}}" {{ $k == $slStatus ? "selected":"" }}>{{$v}}</option>
                                @endforeach
                            </select>
                        </label>
                        <button type="submit" class="btn btn-theme">Apply</button>
                    </div>
                </form>
                </div>
                <div class="table-history">
                    <!-- Header -->
                    <div class="tbl-row row-header">
                        <div class="column-date">Order date</div>
                        <div class="column-title">Stores<div class="xs-title">/Payment date
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover"
                                   data-content="{{ array_search('descSmallScreen', $descriptionStatus) }}" data-placement="top"></i></div></div>
                        <div class="column-amount">Amount Paid</div>
                        <div class="column-cash">Cash Back</div>
                        <div class="column-date">Payment date <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover"
                                                                 data-content="{{ array_search('descBigScreen', $descriptionStatus) }}" data-placement="top"></i></div>
                        <div class="column-status">Status</div>
                    </div>

                    <!-- Items -->
                    @if(count($transHis['orders']['rows']) > 0)
                    @foreach($transHis['orders']['rows'] as $t)
                    <div class="tbl-row">
                        <div class="column-date">{{ date('d M Y', strtotime($t['orderDate'])) }}</div>
                        <div class="column-title">
                            <label>{{$t['store.name']}}</label>
                            <div class="xs-date">{{ date('d M Y', strtotime($t['paymentDate'])) }}</div>
                        </div>
                        <div class="column-amount">
                            @if($t['saleAmount'] < 0)
                            -${{$t['saleAmount'] * -1}}
                            @else
                            ${{$t['saleAmount']}}
                            @endif
                        </div>
                        <div class="column-cash {{array_search($t['status'], $transStatus)}}">

                        @if($t['status'] == 'process')
                        <i class="fa fa-warning" data-toggle="popover" data-trigger="hover" data-content="{{ array_search($t['status'], $descriptionStatus) }}"
                        data-placement="top"></i>
                        @elseif($t['status'] == 'cancel')
                        <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-content="{{ array_search($t['status'], $descriptionStatus) }}"
                        data-placement="top"></i>
                        @endif

                        ${{$t['cashBack']}}</div>
                        <div class="column-date">{{ date('d M Y', strtotime($t['paymentDate'])) }}</div>
                        <div class="column-status {{array_search($t['status'], $transStatus)}}">
                            <span class="cursor" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                data-content="{{ array_search($t['status'], $descriptionStatus) }}">
                                {{ array_search($t['status'], $transStatusText) }}
                                @if($t['warning'] == 1)
                                <i class="fa fa-warning"></i>
                                @endif
                                @if($t['status'] == 'cancel')
                                <i class="fa fa-info-circle"></i>
                                @endif

                            </span>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <!-- End Items -->
                    @if(count($transHis['orders']['rows']) > 0)
                    <!-- Footer -->
                    <div class="tbl-row row-footer">
                        <div class="column-date">Total</div>
                        <div class="column-title"><div class="xs-title">Total</div></div>
                        <div class="column-amount">${{ $currentTotalOrderPaid }}</div>
                        <div class="column-cash">${{ $currentTotalOrderCashback }}</div>
                        <div class="column-date"></div>
                        <div class="column-status"></div>
                    </div>
                    @endif
                </div>
                @if(!$transHis['orders']['rows'])
                    <div class="no-record">No matching records found</div>
                @endif
                <div class="paging-box">
                    <div class="order-status-note">
                        <ul>
                            <li class="processing">Processing</li>
                            <li class="success">Success</li>
                            <li class="cancelled">Cancelled</li>
                            <li class="paid">Paid</li>
                        </ul>
                    </div>
                    @if($transHis['orders']['rows'])
                    <ul class="paging">
                        <li>
                            <a href="{{url('/profile/cash-back/history?page=1')}}{{ $start ? '&start=' . $start : '' }}{{ $end ? '&end=' . $end : '' }}{{ $slStatus ? '&slStatus=' . $slStatus : '' }}">First</a>
                        </li>
                        <!-- Preview page -->
                        <li>
                            @if($currentPage != 1)
                                <a href="{{url('/profile/cash-back/history?page=')}}{{ $currentPage - 1 }}{{ $start ? '&start=' . $start : '' }}{{ $end ? '&end=' . $end : '' }}{{ $slStatus ? '&slStatus=' . $slStatus : '' }}">
                                    @endif
                                    <i class="fa fa-caret-left"></i>
                                    @if($currentPage != 1)
                                </a>
                            @endif
                        </li>
                        <!-- Pages list -->
                        @for($i=1; $i<$pageList + 1; $i++)
                            @if($i==$currentPage-1 || $i==$currentPage || $i==$currentPage+1 || ($i==$pageList-2 && $i < $currentPage+2) || ($currentPage==1&&$i==$currentPage+2))
                                <li {{$i == $currentPage ? "class=active" : ""}}>
                                    <a href="{{url('/profile/cash-back/history?page=')}}{{$i}}{{ $start ? '&start=' . $start : '' }}{{ $end ? '&end=' . $end : '' }}{{ $slStatus ? '&slStatus=' . $slStatus : '' }}">{{$i}}</a>
                                </li>
                            @endif
                        @endfor
                        <!-- Next page -->
                        <li>
                            @if($currentPage != $pageList && $pageList > 0)
                                <a href="{{ url('/profile/cash-back/history?page=')}}{{ $currentPage + 1 }}{{ $start ? '&start=' . $start : '' }}{{ $end ? '&end=' . $end : '' }}{{ $slStatus ? '&slStatus=' . $slStatus : '' }}">
                            @endif
                                    <i class="fa fa-caret-right"></i>
                            @if($currentPage != $pageList && $pageList > 0)
                                </a>
                            @endif
                        </li>
                        <li>
                            <a href="{{url('/profile/cash-back/history?page=')}}{{$pageList}}{{ $start ? '&start=' . $start : '' }}{{ $end ? '&end=' . $end : '' }}{{ $slStatus ? '&slStatus=' . $slStatus : '' }}">Last</a>
                        </li>
                    </ul>
                    <div class="page-total">{{ $currentTotal }}/{{ $transHis['orders']['count'] }} orders</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts-footer')
    <script type="text/javascript">
        $('.format-date-input').each(function () {
            var $that = $(this);
            if (!moment($that.val()).isValid()) return;
            if ($that.val().indexOf('Z') > -1) {
                // $that.val(moment.tz($that.val(), "{{Session::get('geoip-location')['timezone']}}").format('DD MMM YYYY'));
                $that.val(moment.tz($that.val(), "{{Session::get('geoip-location')['timezone']}}").format('L'));
            }else{
                // $that.val(moment.tz($that.val()+'Z', "{{Session::get('geoip-location')['timezone']}}").format('DD MMM YYYY'));
                $that.val(moment.tz($that.val()+'Z', "{{Session::get('geoip-location')['timezone']}}").format('L'));
            }
        });
        /* Set limit start end date*/
        var datepickerOption = {
            todayHighlight: true,
            autoclose:true,
            format: "mm/dd/yyyy",
            disableTouchKeyboard:true,
            clearBtn: true
        };

        $('#end').datepicker(datepickerOption);

        $('#start').datepicker(datepickerOption).on('changeDate', function(e){
            // var dateFrom = $('#start').datepicker('getDate');
            //sets endDate to dt1 date + 1
            // dateFrom.setDate(dateFrom.getDate() + 1);

            // set startDate for #end when #start selected
            $('#end').datepicker().datepicker('setStartDate', e.date).datepicker('setDate', e.date);
        });
        // Set start date after reload page
        $('#end').datepicker().on('show', function(e){
            if("{{$start}}"){
                $('#end').datepicker().datepicker('setStartDate', "{{$start}}");
            }
        });

    </script>
@endsection
