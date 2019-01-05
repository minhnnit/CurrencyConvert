@extends('email-template.main-tmp')
@section('content')
    <table class="mail-body" cellpadding="0" cellspacing="0" border="0" width="600px" align="center" style="margin:10px auto; width:600px;">
        <tr class="mail-content">
            <td>
                <p style="padding:10px 0; color:#555;">Dear [[ fullname ]]!</p>
                <p style="padding:10px 0; color:#555;">{!!html_entity_decode($content)!!}</p>
                @if(!empty($button))
                <p style="padding:10px 0;"><a href="{{$button['link']}}" style="background-color:#854d99; border-radius:2px; padding:10px 50px; font-size:16px; font-weight:bold; color:#fff; display:inline-block; margin-bottom:40px; text-decoration:none;">{{$button['text']}}</a></p>
                @endif
            </td>
        </tr>
    </table>
@endsection