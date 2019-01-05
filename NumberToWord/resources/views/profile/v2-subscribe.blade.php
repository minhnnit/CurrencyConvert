<?php
/**
 * Created by PhpStorm.
 * User: Hung Cuong
 * Date: 1/21/2016
 * Time: 8:29 AM
 */
?>
@extends('profile.v2-profile-app')

@section('profile-content')
    <div class="profile-box-default profile-subscription-box">
        <h3 class="box-header">Subscription Settings</h3>
        <div class="box-content">
            <form id="form-settings-alerts" action="{{url('/profile/subscribe')}}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="box-alert-settings">
                    <div class="box-title">Customize your email alerts settings:</div>
                    <div class="box-choose-email-settings">
                        <label>
                            <input type="radio" name="type" value="daily" @if($selfSubscribe['type'] == 'daily') checked @endif>
                            Daily updates
                        </label>
                        <label>
                            <input type="radio" name="type" value="weekly" @if($selfSubscribe['type'] == 'weekly') checked @endif>
                            Weekly updates
                        </label>
                        <label>
                            <input type="radio" name="type" value="never" @if($selfSubscribe['type'] == 'never') checked @endif>
                            Never (stop all alerts)
                        </label>
                    </div>
                </div>
                <div class="box-alert-settings">
                    <div class="box-title">Choose alert types:</div>
                    <div class="box-choose-type-settings">
                        <label>
                            <input type="checkbox" name="personAlert" value="1" @if($selfSubscribe['personAlert'] == 1) checked @endif>
                            New coupons & deals from your Favorite Stores & Categories
                        </label>
                        <label>
                            <input type="checkbox" name="systemAlert" value="1" @if($selfSubscribe['systemAlert'] == 1) checked @endif>
                            News & Updates from DontPayAll.com
                        </label>
                    </div>
                </div>
                <div class="box-alert-settings">
                    <div class="box-title">Select your favorite categories:</div>
                    <div class="box-choose-categories-settings scrollbar-auto">
                        <ul class="box-categories-list clearfix">
                            @foreach($categories as $category)
                            <li class="col-lg-3 col-sm-4 col-xs-6">
                                <label>
                                    <input type="checkbox" name="categoryIds[]" value="{{$category['id']}}" @if(in_array($category['id'], $selfSubscribe['categoryIds'])) checked @endif>
                                    {{$category['name']}}</label>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-theme btn-update">Update</button>
                    <span class="alert"></span>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts-footer')
    <script type="text/javascript">
        var $formSettingAlerts = $('#form-settings-alerts');
        $formSettingAlerts.on('submit', function (e) {
            e.preventDefault();
            $formSettingAlerts.find('button[type="submit"]').empty().append("<i class='fa fa-spinner fa-pulse'></i> Saving...").addClass('disabled');
            $.ajax({
                type: 'post',
                url: $formSettingAlerts.attr('action'),
                data: $formSettingAlerts.serialize()
            }).done(function (data) {
                if (data.status == 'success') {
                    $formSettingAlerts.find('button[type="submit"]').parent().find('span.alert').remove();
                    $formSettingAlerts.find('button[type="submit"]').empty().text('Saved');
                } else if (data.status == 'error') {
                    $formSettingAlerts.find('button[type="submit"]').parent().find('span.alert').addClass('alert-danger').text(data.msg);
                }
                setTimeout(function () {
                    $formSettingAlerts.find('button[type="submit"]').empty().text('Update').removeClass('disabled');
                },2000);
            });
        });
    </script>
@endsection