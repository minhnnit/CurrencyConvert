<div class="submits-control-modal" >
    <a href="#" data-toggle="modal" data-target="#submitCodeModal" >Submit a {{config('config.coupon')}} code</a>
</div>
<div class="modal fade" id="submitCodeModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="submit-form-title">Submit a {{config('config.Coupon')}} code @if($store['name']) for {{$store['name']}} store @endif</h4>
            </div>
            <div class="modal-body">
                <div class="description">When you submit a {{config('config.coupon')}} on http://www.{{config('config.domain')}}, You help others save money.</div>
                @include('elements.submit-voucher')
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->