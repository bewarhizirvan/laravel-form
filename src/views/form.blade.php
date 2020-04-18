    <div class="card" dir="{{ ($form['dir'] == "left")?"ltr":"rtl" }}" style="text-align: {{ $form['dir'] }}">
        <!-- Form Card header -->
        <div class="card-header">
            <div class="row">
                <div class="col-7">
                        <h3 class="mb-0">
                            {!! $form['title'] !!}
                        </h3>
                </div>
            </div>
        </div>
        <!-- Form Card body -->
        <div class="card-body">
            <form name="{{ $form['name'] }}" method="{{ $form['method'] }}" action="{{ $form['action'] }}" accept-charset="UTF-8" class="{{ $form['class'] }}" role="{{ $form['role'] }}" id="{{ $form['id'] }}" @isset($form['file']) enctype="multipart/form-data" @endisset }}>
@if(isset($form['back_url']) && $form['back_url'] != null)
                <div class="form-group row" style="text-align: {{ ($form['dir'] == "left")?"right":"left" }}">
                    <div class="col-md-10">
                        <a href="{{$form['back_url']}}" class="btn btn-primary">{{trans('db.back')}}</a>
                    </div>
                </div>
@endif
@foreach($form['rows'] as $row)
@switch($row['type'])
@case('text')
                <div{!! $row['div_attr'] !!}>
                    <label{!! $row['label_attr'] !!}>{!! $row['label'] !!}</label>
                    <div class="{{$row['div_div_class']}}">
                        <input{!! $row['input_attr'] !!}>
                    </div>
                </div>
@break
@case('textarea')
                <div{!! $row['div_attr'] !!}>
                    <label{!! $row['label_attr'] !!}>{!! $row['label'] !!}</label>
                    <div class="{{$row['div_div_class']}}">
                        <textarea{!! $row['input_attr'] !!}>{!! $row['value'] !!}</textarea>
                    </div>
                </div>
@break
@case('hidden')
                <input{!! $row['input_attr'] !!}>
@break
@case('checkbox')
                 <div{!! $row['div_attr'] !!}>
                     <label{!! $row['label_attr'] !!}>{!! $row['label'] !!}</label>
                     <div class="{{$row['div_div_class']}}">
                         <input{!! $row['input_attr'] !!}>
                     </div>
                 </div>
@break
@case('checkboxGroup')
                <div{!! $row['div_attr'] !!}>
                    <label{!! $row['label_attr'] !!}>{!! $row['label'] !!}</label>
                    <div class="{{$row['div_div_class']}}">
<?php $group_id = isset($row['inputs'][0]['group_id'])? $row['inputs'][0]['group_id']:0; ?>
@foreach($row['inputs'] as $input)
@if($input['group_id'] != $group_id)
                        <hr class="my-3">
                        <div class="custom-control custom-checkbox mb-3">
                            <input{!! $input['input_attr'] !!}>
                            <label class="custom-control-label" for="{!! $input['label_for'] !!}"><span>{!! $input['label'] !!}</span></label>
                        </div>
<?php $group_id = $input['group_id']; ?>
@else
                        <div class="custom-control custom-checkbox mb-3">
                            <input{!! $input['input_attr'] !!}>
                            <label class="custom-control-label" for="{!! $input['label_for'] !!}"><span>{!! $input['label'] !!}</span></label>
                        </div>
@endif
@endforeach
                    </div>
                </div>
@break
@case('radioGroup')
                <div{!! $row['div_attr'] !!}>
                    <label{!! $row['label_attr'] !!}>{!! $row['label'] !!}</label>
                    <div class="{{$row['div_div_class']}}">
@foreach($row['inputs'] as $input)
                        <div class="custom-control custom-radio mb-3">
                            <input{!! $input['input_attr'] !!}>
                            <label class="custom-control-label" for="{!! $input['label_for'] !!}"><span>{!! $input['label'] !!}</span></label>
                        </div>
@endforeach
                    </div>
                </div>
@break
@case('file')
                <div{!! $row['div_attr'] !!}>
                    <label{!! $row['label_attr'] !!}>{!! $row['label'] !!}</label>
                    <div class="{{$row['div_div_class']}}">
                        <input{!! $row['input_attr'] !!}>
                    </div>
                </div>
@break
@case('select')
                <div{!! $row['div_attr'] !!}>
                    <label{!! $row['label_attr'] !!}>{!! $row['label'] !!}</label>
                    <div class="{{$row['div_div_class']}}">
                        <select{!! $row['input_attr'] !!}>
@foreach($row['options'] as $key => $value)
                            <option value="{{$key}}"<?php if($key == $row['selected']) echo " selected"; ?>>{!! $value !!}</option>
@endforeach
                        </select>
                    </div>
                </div>
@break
@case('button')
                <button type="button" onclick="primeOrderAdd()">Try it</button>
@break
@case('table')
                <div{!! $row['div_attr'] !!}>
                    <div class="table-responsive">
                    <label{!! $row['label_attr'] !!}>{!! $row['label'] !!}</label>
                    <div class="{{$row['div_div_class']}}">
                        <table{!! $row['table_attr'] !!}>
                            <thead{!! $row['thead_attr'] !!}>
                            <tr>
@foreach($row['table_data']['names'] as $key => $name)
                                <th class="th-{{$key}}">{{ $name }}</th>
@endforeach
                            </tr>
                            </thead>
                            <tbody{!! $row['tbody_attr'] !!}>
                            <tr>
@foreach($row['table_data']['inputs'] as $input)
@if(strrpos($input, 'hidden') === false)
                                <td><input{!! $input !!}></td>
@else
                                <input{!! $input !!}>
@endif
@endforeach
                            </tr>
                            </tbody>
                            <tfoot{!! $row['tbody_attr'] !!}>
                            <tr>
@foreach($row['table_data']['sums'] as $name)
                                    <td id="{{ $name }}" style="text-align: center" tabindex="-1" disabled>&nbsp;</td>
@endforeach
                            </tr>
                            </tfoot>
                        </table>
                        <div style="text-align: left">
@foreach($row['table_data']['buttons'] as $button)
                            <button type="button" class="btn {{isset($button['class'])?$button['class']:''}}" tabindex="-1" onclick="{{$button['onclick']}}">{{$button['name']}}</button>
@endforeach
                        </div>
                    </div>
                    </div>
                </div>
@break
@default
@endswitch
@endforeach
@if(isset($form['put_patch']))
                <input name="_method" type="hidden" value="{{$form['put_patch']}}">
@endif
                <input name="back_url" type="hidden" value="{{ url()->previous() }}"><br />
@if( $form['submit'] != null )
                    <button class="btn btn-primary btn-lg btn-block" type="submit" id="formSubmit">{{ $form['submit'] }}</button>
@endif
                @csrf

            </form>
        </div>
    </div>
