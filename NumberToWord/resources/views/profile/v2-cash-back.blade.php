@extends('profile.v2-profile-app')

@section('profile-content')
@if (Session::has('status'))
    <div class="alert alert-info">
    @if(Session::get('status') == 'error')
        <div class="text-danger">Your entered password not match
    @else
        <div class="text-primary">Change your payment address success
    @endif
        </div>
    </div>
@endif
    <div class="profile-box-default">
        <h3 class="box-header clearfix">
            <span class="header-left">BALANCE & PAYMENT</span>
            <span class="header-right"><a href="{{url('profile/cash-back/history')}}">TRANSACTION HISTORY <i class="fa fa-long-arrow-right"></i></a></span></h3>
        <div class="box-content">
            <div class="row">
                <div class="col-sm-6">
                    <div class="payment-address-box">
                        <!-- HTML code is for without email account  -->
                        <!-- Please remove class hidden for used or test  -->
                        <div class="form-payment small-form-payment hidden">
                            <form class="payment-address-form" autocomplete="off">
                                <div class="form-left">
                                    <div class="form-group">
                                        <input type="text" autocomplete="off" class="form-control" name="email"
                                               placeholder="Enter your email for Paypal" title="Enter your email for Paypal">
                                    </div>
                                </div>
                                <div class="form-right-small">
                                    <button class="btn btn-none-body edit-pay-submit" type="submit"><i class="fa fa-save"></i></button>
                                </div>
                            </form>
                        </div>
                        <!-- HTML code is intended for who have email account  -->
                        <label>Payment Address:
                        <span>
                            <input type="hidden" value="{{$user['email_paypal']}}" id="paypalEmail">
                            <strong>{{$user['email_paypal']}}</strong>
                            <a class="btn-edit-email collapsed" data-toggle="collapse" href="#form-edit-payment" aria-expanded="false" aria-controls="form-edit-payment">
                                <i class="fa fa-pencil"></i></a>
                        </span>
                        </label>
                        <div class="collapse" id="form-edit-payment">
                            <div class="form-payment">
                                <form method="POST" action="{{url('/profile/cash-back/change-paypal-email/')}}" class="payment-address-form" autocomplete="off">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-left">
                                        <div class="form-group">
                                            <input type="email" autocomplete="off" class="form-control" name="email"
                                                   placeholder="Enter your email for Paypal" title="Enter your email for Paypal">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" autocomplete="off" class="form-control" name="password"
                                                   placeholder="Enter your current Password" title="Enter your current Password">
                                        </div>
                                    </div>
                                    <div class="form-right">
                                        <button class="btn btn-none-body edit-pay-submit" type="submit"><i class="fa fa-save btn-less-size"></i></button>
                                        <button class="btn btn-none-body" type="reset" data-toggle="collapse" data-target="#form-edit-payment"
                                                aria-expanded="false" aria-controls="form-edit-payment"><i class="fa fa-close"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- End HTML code for email account  -->
                    </div>
                    <!-- FAQs -->
                    <ul class="cash-helper" id="cash-helper" role="tablist" aria-multiselectable="true">
                        @foreach($questions as $i=>$q)
                        <li class="panel">
                            <div role="tab" id="heading-{{$i}}">
                                <a href="#{{$q['anchor']}}" id="{{$q['id']}}" role="button" data-toggle="collapse" data-parent="#cash-helper"
                                    aria-expanded="false" aria-controls="{{$q['anchor']}}">{{$q['question']}}</a>
                            </div>
                            <div id="{{$q['anchor']}}" class="collapse" role="tabpanel" aria-labelledby="heading-{{$i}}">
                                <div class="answer-content">
                                    {!!html_entity_decode($q['answer'])!!}
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <!-- <a class="cash-helper-see-more" href="javascript:;">See more</a> -->
                    <!-- End FAQs -->
                </div>
                <div class="col-sm-6 text-right">
                    <ul class="cash-back-calculation">
                        <li>Total Received
                        <span><strong class="received">${{$cashBackUser['totalCashBackReceived']}}</strong>
                            <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover"
                               data-content="{{ array_search('descTotalRecevied', $descriptionTotal) }}" data-placement="left"></i></span></li>
                        <li>Total Processing
                        <span><strong class="processing">${{$cashBackUser['totalCashBackProcess']}}</strong>
                            <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover"
                               data-content="{{ array_search('descTotalProcessing', $descriptionTotal) }}" data-placement="left"></i></span></li>
                        @if($cashBackUser['user']['bonus'])
                        <li>Bonus {{ $user['profile_completed'] == 1 ? '' : 'Pending' }}
                        <span><strong class="processing">${{$cashBackUser['user']['bonus']}}</strong>
                            <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover"
                               data-content="{{ array_search('descTotalPending', $descriptionTotal) }}" data-placement="left"></i></span></li>
                        @endif
                        <li>Total Available
                            <span>
                            @if($cashBackUser['user']['bonus'] && $user['profile_completed'] == 1)
                                <strong class="available">${{ $cashBackUser['totalCashBackAvailable'] + $cashBackUser['user']['bonus'] }}</strong>
                            @else
                                <strong class="available">${{ $cashBackUser['totalCashBackAvailable'] }}</strong>
                            @endif
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover"
                                   data-content="{{ array_search('descTotalAvailable', $descriptionTotal) }}" data-placement="left">
                                </i>
                            </span>
                        </li>
                    </ul>
                    <div class="collapse cash-confirm-pw" id="cash-confirm-pw" data-parent="#btn-cash-confirm-pw">
                        <form method="POST" action="{{url('/profile/cash-back/withdraw/')}}">
                            <div class="form-group">
                                <input name="password" type="password" class="form-control" placeholder="Enter your current Password" title="Enter your current Password">
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" id="totalCashback" name="totalCashback" value="{{$cashBackUser['totalCashBackAvailable']}}">
                                <input type="hidden" name="email" value="{{$user['email']}}">
                                <input type="hidden" name="emailPaypal" value="{{$user['email_paypal']}}">

                                <button type="submit" class="btn btn-theme btn-update">Confirm</button>&nbsp;&nbsp;&nbsp;
                                <button type="reset" class="btn btn-theme-cancel btn-update" data-toggle="collapse" href="#cash-confirm-pw" aria-expanded="false">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <button type="button" class="btn btn-theme btn-update collapsed" id="btn-cash-confirm-pw" data-toggle="collapse" href="#cash-confirm-pw"
                             aria-expanded="false" aria-controls="cash-confirm-pw">WITHDRAW</button>
                    <div id="warning-fill-paypal-email" class="note-withdraw" style="display:none">Please fill your Paypal address to start withdrawing!</div>
                    @if(Session::get('withdrawStatus') == 'success')
                    <div class="note-withdraw paid">Your Payment Request was Sent!</div>
                    @elseif(Session::get('withdrawStatus') == 'error')
                    <div class="note-withdraw paid">Error! Your entered password not match</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="profile-box-default">
        <h3 class="box-header has-collapse collapsed" data-toggle="collapse" href="#payment-history"
            aria-expanded="true">WITHDRAW History <i class="fa fa-caret-up"></i>
        </h3>
        <div id="payment-history" class="collapse in">
            <div class="box-content">
                <div class="form-filter">
                    <form method="POST" action="{{url('/profile/cash-back')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-element-group filter-date-range">
                            <label>From <input type="text" name="startDate" id="startDate" class="form-control"
                                               placeholder="All time" value="{{$start}}" /></label>
                            <label>To <input type="text" name="endDate" id="endDate" class="form-control"
                                             placeholder="All time" value="{{$end}}"></label>
                        </div>
                        <div class="form-element-group">
                            <label>
                                <select class="form-control" name="status">
                                    <option value="" {{ '' == $status ? "selected":"" }}>All Status</option>
                                    <option value="processing" {{ "processing" == $status ? "selected":"" }}>Processing</option>
                                    <option value="paid" {{ "paid" == $status ? "selected":"" }}> Paid </option>
                                </select>
                            </label>
                            <button type="submit" class="btn btn-theme">Apply</button>
                        </div>
                    </form>
                </div>
                <div id="tbl-withdraw-history" class="payment-history-tbl">
                    <div class="tbl-row tbl-header">
                        <div class="date request">Request Date</div>
                        <div class="date update">Updated</div>
                        <div class="amount">Amount Paid</div>
                        <div class="note hidden-xs">Note</div>
                        <div class="status hidden-xs">Status</div>
                    </div>
                    @foreach($cashBackUser['paymentHistory']['rows'] as $p)
                    <div class="tbl-row">
                        <div class="date request">{{ gmdate('d M Y', strtotime($p['createdAt'])) }}</div>
                        <div class="date update">{{ gmdate('d M Y', strtotime($p['updatedAt'])) }}</div>
                        <div class="amount {{ $p['status'] ? 'paid-xs' : 'processing-xs' }}">${{$p['requestMoney']}}</div>
                        <div class="note-content">
                            <div class="ellipsis1-more-paypal" style="line-height: 21px;">
                                @if(isset($p['paypal_transactions_log.transactionId']) && $p['paypal_transactions_log.transactionId'])
                                    Paypal transaction ID: {{$p['paypal_transactions_log.transactionId']}};
                                    Status: {{$p['paypal_transactions_log.transactionStatus']}};
                                    Time Processed: {{ date('d M Y h:m:s', strtotime($p['paypal_transactions_log.timeProcessed']))}};
                                @endif
                            </div>
                        </div>
                        <div class="status status-content">
                            {{ $p['status'] ? 'Paid' : 'Processing' }}
                        </div>
                    </div>
                    @endforeach
                </div>
                @if(!$cashBackUser['paymentHistory']['rows'])
                    <div class="no-record">No matching records found</div>
                @endif
                <div class="paging-box">
                    <div class="order-status-note">
                        <ul>
                            <li class="processing-xs">Processing</li>
                            <li class="paid-xs">Paid</li>
                        </ul>
                    </div>
                    @if($cashBackUser['paymentHistory']['rows'])
                    <ul class="paging">
                        <li>
                            <a href="{{url('/profile/cash-back?page=1')}}{{ $start ? '&startDate=' . $start : '' }}{{ $end ? '&endDate=' . $end : '' }}{{ $status ? '&status=' . $status : '' }}">First</a>
                        </li>
                        <!-- Preview page -->
                        <li>
                            @if($currentPage != 1)
                                <a href="{{url('/profile/cash-back?page=')}}{{ $currentPage - 1 }}{{ $start ? '&startDate=' . $start : '' }}{{ $end ? '&endDate=' . $end : '' }}{{ $status ? '&status=' . $status : '' }}">
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
                                    <a href="{{url('/profile/cash-back?page=')}}{{$i}}{{ $start ? '&startDate=' . $start : '' }}{{ $end ? '&endDate=' . $end : '' }}{{ $status ? '&status=' . $status : '' }}">{{$i}}</a>
                                </li>
                                @endif
                                @endfor
                                        <!-- Next page -->
                                <li>
                                    @if($currentPage != $pageList && $pageList > 0)
                                        <a href="{{ url('/profile/cash-back?page=')}}{{ $currentPage + 1 }}{{ $start ? '&startDate=' . $start : '' }}{{ $end ? '&endDate=' . $end : '' }}{{ $status ? '&status=' . $status : '' }}">
                                            @endif
                                            <i class="fa fa-caret-right"></i>
                                            @if($currentPage != $pageList && $pageList > 0)
                                        </a>
                                    @endif
                                </li>
                                <li>
                                    <a href="{{url('/profile/cash-back?page=')}}{{$pageList}}{{ $start ? '&startDate=' . $start : '' }}{{ $end ? '&endDate=' . $end : '' }}{{ $status ? '&status=' . $status : '' }}">Last</a>
                                </li>
                    </ul>
                    <div class="page-total">{{ $currentTotal }}/{{ $cashBackUser['paymentHistory']['count'] }} Requests</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts-footer')
<script type="text/javascript">
    jQuery(document).ready(function($){

        $('#btn-cash-confirm-pw').click(function(e){
            if($('#paypalEmail').val().length == 0){
                $('#warning-fill-paypal-email').show();
                return false;
            }else{
                $('#warning-fill-paypal-email').hide();
            }
        });
        /*
            1.If total cash back = 0
            2.or NOT completed profile
            3.or first_withdraw = 0
            => Disable button Withdraw
        */
        if(
            $('#totalCashback').val() == 0 || '{{$user["profile_completed"]}}' == 0   // NOT completed profile
            || ('{{$user["first_withdraw"]}}' == 0 && $('#totalCashback').val() < 25) // second withdraw but total < 25
            || ('{{$user["first_withdraw"]}}' == 1 && $('#totalCashback').val() < 15) // first withdraw but total < 15
        ){
            $('#btn-cash-confirm-pw').attr('disabled', 'disabled');
        }

        var datepickerOption = {
            todayHighlight: true,
            autoclose:true,
            format: "mm/dd/yyyy",
            disableTouchKeyboard:true,
            clearBtn: true
        };

        $('#endDate').datepicker(datepickerOption);

        $('#startDate').datepicker(datepickerOption).on('changeDate', function(e){
            // var dateFrom = $('#start').datepicker('getDate');
            //sets endDate to dt1 date + 1
            // dateFrom.setDate(dateFrom.getDate() + 1);

            // set startDate for #end when #start selected
            $('#endDate').datepicker().datepicker('setStartDate', e.date).datepicker('setDate', e.date);
        });
        // Set start date after reload page
        $('#endDate').datepicker().on('show', function(e){
            if("{{$start}}"){
                $('#endDate').datepicker().datepicker('setStartDate', "{{$start}}");
            }
        });
    })
</script>
@endsection
