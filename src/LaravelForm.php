<?php

namespace BewarHizirvan\LaravelForm;

class LaravelForm
{
    // Build wonderful things
    protected $card_class = '';
    protected $form_title = '';
    protected $form_name = '';
    protected $form_method = 'POST';
    protected $form_method_put_patch = null;
    protected $form_action;
    protected $form_class = '';
    protected $form_role = '';
    protected $form_id = '';
    protected $form_dir = 'left';
    protected $form_hasFile = null;
    protected $submit = 'Submit';
    protected $back_url = null;
    protected $rows = [];

    public function __construct($parameters = [])
    {
        if(isset($parameters['title'])) $this->form_title = $parameters['title'];
        if(isset($parameters['name'])) $this->form_name = $parameters['name'];
        if(isset($parameters['method']))
        {
            if($parameters['method'] == strtolower('put'))
            {
                $this->form_method = 'POST';
                $this->form_method_put_patch = strtoupper( $parameters['method'] );
            }elseif($parameters['method'] == strtolower('patch'))
            {
                $this->form_method = 'POST';
                $this->form_method_put_patch = strtoupper( $parameters['method'] );
            }else
                $this->form_method = $parameters['method'];
        }
        $this->form_action = Self::getAction($parameters);
        if(isset($parameters['class'])) $this->form_class = $parameters['class'];
        if(isset($parameters['card_class'])) $this->card_class = $parameters['card_class'];
        if(isset($parameters['role'])) $this->form_role = $parameters['role'];
        if(isset($parameters['id'])) $this->form_id = $parameters['id'];
        if(isset($parameters['dir'])) $this->form_dir = $parameters['dir'];
        if(isset($parameters['file'])) $this->form_hasFile = 'enctype="multipart/form-data"';
        if(isset($parameters['submit']))
        {
            if($parameters['submit'] == 'none') $this->submit = null;
            else $this->submit = $parameters['submit'];
        }
        if(isset($parameters['back_url']))
        {
            if($parameters['back_url'] == 'none') $this->back_url = null;
            elseif(\URL::current() == \URL::previous()) $this->back_url = route($parameters['back_url']);
            else $this->back_url = \URL::previous();
        }
    }

    protected static function Attributes($attributes)
    {
        $attr = '';
        foreach($attributes as $key => $val)
        {
            $attr .= " $key=\"$val\"";
        }
        return $attr;
    }

    public static function redirect($route = '/')
    {
        $request = request();
        if(isset($request->back_url) && \URL::previous() != $request->back_url)
            return redirect($request->back_url);
        else
            return redirect()->route($route);
    }

    protected static function getAction(array $options)
    {
        if (isset($options['url'])) {
            return Self::getUrlAction($options['url']);
        }

        if (isset($options['route'])) {
            return Self::getRouteAction($options['route']);
        }

        elseif (isset($options['action'])) {
            return Self::getControllerAction($options['action']);
        }

        return url()->current();
    }

    protected static function getUrlAction($options)
    {
        if (is_array($options)) {
            return \URL::to($options[0], array_slice($options, 1));
        }

        return \URL::to($options);
    }

    protected static function getRouteAction($options)
    {
        if (is_array($options)) {
            return \URL::route($options[0], array_slice($options, 1));
        }

        return \URL::route($options);
    }

    protected static function getControllerAction($options)
    {
        if (is_array($options)) {
            return \URL::action($options[0], array_slice($options, 1));
        }

        return \URL::action($options);
    }

    public function addText($input_name = null, $input_value = '', $input_par = [], $label = null, $label_par = [], $div_par = [])
    {
        if(!isset($input_par['class'])) $input_par['class'] = 'form-control';
        if(!isset($input_par['type'])) $input_par['type'] = 'text';
        if(!isset($input_par['id'])) $input_par['id'] = $input_name;
        $input_par['name'] = $input_name;
        $input_par['value'] = $input_value;
        $input_attr = Self::Attributes($input_par);

        $label = is_null($label)?trans('db.'.$input_name):$label;
        if(!isset($label_par['class'])) $label_par['class'] = 'col-md-2 col-form-label form-control-label';
        $label_par['for'] = $input_par['id'];
        $label_attr = Self::Attributes($label_par);

        if(!isset($div_par['class'])) $div_par['class'] = 'form-group row';
        $div_attr = Self::Attributes($div_par);
        $div_div_class = 'col-md-10';
        $this->rows[] = [
            'type' => 'text',
            'div_attr' => $div_attr,
            'label_attr' => $label_attr,
            'label' => $label,
            'div_div_class' => $div_div_class,
            'input_attr' => $input_attr,
        ];
    }

    public function addFile($input_name = null, $input_value = '', $input_par = [], $label = null, $label_par = [], $div_par = [])
    {
        if(!isset($input_par['class'])) $input_par['class'] = 'form-control';
        if(!isset($input_par['type'])) $input_par['type'] = 'file';
        if(!isset($input_par['id'])) $input_par['id'] = $input_name;
        $input_par['name'] = $input_name;
        $input_par['value'] = $input_value;
        $input_attr = Self::Attributes($input_par);

        $label = is_null($label)?trans('db.'.$input_name):$label;
        if(!isset($label_par['class'])) $label_par['class'] = 'col-md-2 col-form-label form-control-label';
        $label_par['for'] = $input_par['id'];
        $label_attr = Self::Attributes($label_par);

        if(!isset($div_par['class'])) $div_par['class'] = 'form-group row';
        $div_attr = Self::Attributes($div_par);
        $div_div_class = 'col-md-10';
        $this->rows[] = [
            'type' => 'file',
            'div_attr' => $div_attr,
            'label_attr' => $label_attr,
            'label' => $label,
            'div_div_class' => $div_div_class,
            'input_attr' => $input_attr,
        ];
    }

    public function addButton($label = '', $input_par = [])
    {
        if(!isset($input_par['type'])) $input_par['type'] = 'button';
        $input_attr = Self::Attributes($input_par);

        $this->rows[] = [
            'type' => 'button',
            'div_attr' => '',
            'label_attr' => '',
            'label' => $label,
            'div_div_class' => '',
            'input_attr' => $input_attr,
        ];
    }

    public function addHidden($input_name = null, $input_value = '', $input_par = [])
    {
        if(!isset($input_par['type'])) $input_par['type'] = 'hidden';
        if(!isset($input_par['id'])) $input_par['id'] = $input_name;
        $input_par['name'] = $input_name;
        $input_par['value'] = $input_value;
        $input_attr = Self::Attributes($input_par);

        $this->rows[] = [
            'type' => 'hidden',
            'div_attr' => '',
            'label_attr' => '',
            'label' => '',
            'div_div_class' => '',
            'input_attr' => $input_attr,
        ];
    }

    public function addTextArea($input_name = null, $input_value = '', $input_par = [], $label = null, $label_par = [], $div_par = [])
    {
        if(!isset($input_par['class'])) $input_par['class'] = 'form-control';
        if(!isset($input_par['type'])) $input_par['type'] = 'textarea';
        if(!isset($input_par['id'])) $input_par['id'] = $input_name;
        $input_par['name'] = $input_name;
        $input_attr = Self::Attributes($input_par);

        $label = is_null($label)?trans('db.'.$input_name):$label;
        if(!isset($label_par['class'])) $label_par['class'] = 'col-md-2 col-form-label form-control-label';
        $label_par['for'] = $input_par['id'];
        $label_attr = Self::Attributes($label_par);

        if(!isset($div_par['class'])) $div_par['class'] = 'form-group row';
        $div_attr = Self::Attributes($div_par);
        $div_div_class = 'col-md-10';
        $this->rows[] = [
            'type' => 'textarea',
            'value' => $input_value,
            'div_attr' => $div_attr,
            'label_attr' => $label_attr,
            'label' => $label,
            'div_div_class' => $div_div_class,
            'input_attr' => $input_attr,
        ];
    }

    public function addCheckbox($input_name = null, $input_value = 1, $checked = false, $input_par = [], $label = null, $label_par = [], $div_par = [])
    {
        if(!isset($input_par['class'])) $input_par['class'] = 'form-control form-checkbox';
        if(!isset($input_par['type'])) $input_par['type'] = 'checkbox';
        if(!isset($input_par['id'])) $input_par['id'] = $input_name;
        $input_par['name'] = $input_name;
        $input_par['value'] = $input_value;
        if($checked) $input_par['checked'] = 'checked';
        $input_attr = Self::Attributes($input_par);

        $label = is_null($label)?trans('db.'.$input_name):$label;
        if(!isset($label_par['class'])) $label_par['class'] = 'col-md-2 col-form-label form-control-label';
        $label_par['for'] = $input_par['id'];
        $label_attr = Self::Attributes($label_par);

        if(!isset($div_par['class'])) $div_par['class'] = 'form-group row';
        $div_attr = Self::Attributes($div_par);
        $div_div_class = 'col-md-10';
        $this->rows[] = [
            'type' => 'checkbox',
            'div_attr' => $div_attr,
            'label_attr' => $label_attr,
            'label' => $label,
            'div_div_class' => $div_div_class,
            'input_attr' => $input_attr,
        ];
    }

    public function addSelect($select_name= null, $select_options = [], $select_value='',$select_par = [],$label=null, $label_par = [], $div_par = [])
    {
        if(!isset($select_par['class'])) $select_par['class'] = 'form-control';
        if(!isset($select_par['type'])) $select_par['type'] = 'select';
        if(!isset($select_par['id'])) $select_par['id'] = $select_name;
        $select_par['name'] = $select_name;
        $input_attr = Self::Attributes($select_par);

        $label = is_null($label)?trans('db.'.$select_name):$label;
        if(!isset($label_par['class'])) $label_par['class'] = 'col-md-2 col-form-label form-control-label';
        $label_par['for'] = $select_par['id'];
        $label_attr = Self::Attributes($label_par);

        if(!isset($div_par['class'])) $div_par['class'] = 'form-group row';
        $div_attr = Self::Attributes($div_par);
        $div_div_class = 'col-md-10';
        $this->rows[] = [
            'type' => 'select',
            'options' => $select_options,
            'selected' => $select_value,
            'div_attr' => $div_attr,
            'label_attr' => $label_attr,
            'label' => $label,
            'div_div_class' => $div_div_class,
            'input_attr' => $input_attr,
        ];
    }

    public function addCheckboxGroup($input_name = null, $checkboxes = [], $checked_list = [], $input_par = [], $label = null, $label_par = [], $div_par = [])
    {
        if(!isset($input_par['class'])) $input_par['class'] = 'form-control form-checkbox';
        if(!isset($input_par['id'])) $input_par['id'] = $input_name;
        if(!isset($input_par['type'])) $input_par['type'] = 'checkbox';
        $input_par['name'] = $input_name;
        $inputs = [];
        foreach($checkboxes as $checkbox)
        {
            $check = $input_par;
            $check['class'] = 'custom-control-input';
            $check['id'] = $input_name.'_'.$checkbox['id'];
            $check['value'] = $checkbox['id'];
            if(in_array($checkbox['id'], $checked_list)) $check['checked'] = 'checked';
            $inputs[] = [
                'label' => $checkbox['name'],
                'label_for' => $check['id'],
                'group_id' => $checkbox['groupid'],
                'input_attr' => Self::Attributes($check)
            ];
        }
        $label = is_null($label)?trans('db.'.$input_name):$label;
        if(!isset($label_par['class'])) $label_par['class'] = 'col-md-2 col-form-label form-control-label';
        $label_par['for'] = $input_par['id'];
        $label_attr = Self::Attributes($label_par);

        if(!isset($div_par['class'])) $div_par['class'] = 'form-group row';
        $div_attr = Self::Attributes($div_par);
        $div_div_class = 'col-md-10';
        $this->rows[] = [
            'type' => 'checkboxGroup',
            'div_attr' => $div_attr,
            'label_attr' => $label_attr,
            'label' => $label,
            'div_div_class' => $div_div_class,
            'inputs' => $inputs,
        ];
    }

    public function addRadioGroup($input_name= null, $radios=[], $checked = '', $input_par = [], $label = null, $label_par = [], $div_par = [])
    {
        if(!isset($input_par['class'])) $input_par['class'] = 'form-control form-radio';
        if(!isset($input_par['id'])) $input_par['id'] = $input_name;
        if(!isset($input_par['type'])) $input_par['type'] = 'radio';
        $input_par['name'] = $input_name;
        $inputs = [];
        foreach($radios as $radio)
        {
            $attr = $input_par;
            $attr['class'] = 'custom-control-input';
            $attr['id'] = $input_name.'_'.$radio['id'];
            $attr['value'] = $radio['id'];
            if($radio['id'] == $checked) $attr['checked'] = 'checked';
            $inputs[] = [
                'label' => $radio['name'],
                'label_for' => $attr['id'],
                'input_attr' => Self::Attributes($attr)
            ];
        }
        $label = is_null($label)?trans('db.'.$input_name):$label;
        if(!isset($label_par['class'])) $label_par['class'] = 'col-md-2 col-form-label form-control-label';
        $label_par['for'] = $input_par['id'];
        $label_attr = Self::Attributes($label_par);

        if(!isset($div_par['class'])) $div_par['class'] = 'form-group row';
        $div_attr = Self::Attributes($div_par);
        $div_div_class = 'col-md-10';
        $this->rows[] = [
            'type' => 'radioGroup',
            'div_attr' => $div_attr,
            'label_attr' => $label_attr,
            'label' => $label,
            'div_div_class' => $div_div_class,
            'inputs' => $inputs,
        ];

    }

    public function addTable($label = '', $table_data = [], $label_par = [], $table_par = [], $thead_par = [], $tbody_par = [], $tfoot_par = [], $div_par = [])
    {
        if(!isset($table_data['inputs'])) $table_data['inputs'] = [];
        if(!isset($table_data['names'])) $table_data['names'] = [];
        if(!isset($table_data['sums'])) $table_data['sums'] = [];
        if(!isset($table_data['buttons'])) $table_data['buttons'] = [];
        foreach($table_data['inputs'] as $key => $value)
        {
            if(!isset($value['name'])) $value['name'] = '';
            if(!isset($value['class'])) $value['class'] = 'form-control text-center';
            if(!isset($value['type'])) $value['type'] = 'text';
            if(!isset($value['id'])) $value['id'] = $value['name'];
            if(!isset($value['value'])) $value['value'] = '';
            $table_data['inputs'][$key] = Self::Attributes($value);
        }


        if(!isset($table_par['class'])) $table_par['class'] = 'table align-items-center table-flush table-striped order-table';
        if(!isset($table_par['id'])) $table_par['id'] = 'table1';
        $table_attr = Self::Attributes($table_par);

        if(!isset($thead_par['class'])) $thead_par['class'] = 'text-center';
        $thead_attr = Self::Attributes($thead_par);

        if(!isset($tbody_par['class'])) $tbody_par['class'] = '';
        $tbody_attr = Self::Attributes($tbody_par);

        if(!isset($tfoot_par['class'])) $tfoot_par['class'] = '';
        $tfoot_attr = Self::Attributes($tfoot_par);

        if(!isset($label_par['class'])) $label_par['class'] = 'col-md-2 col-form-label form-control-label';
        $label_par['for'] = $table_par['id'];
        $label_attr = Self::Attributes($label_par);

        if(!isset($div_par['class'])) $div_par['class'] = 'form-group row';
        $div_attr = Self::Attributes($div_par);
        $div_div_class = 'col-md-10';
        $this->rows[] = [
            'type' => 'table',
            'div_attr' => $div_attr,
            'label_attr' => $label_attr,
            'label' => $label,
            'div_div_class' => $div_div_class,
            'table_attr' => $table_attr,
            'thead_attr' => $thead_attr,
            'tbody_attr' => $tbody_attr,
            'tfoot_attr' => $tfoot_attr,
            'table_data' => $table_data,
        ];
    }





    public function render()
    {
        $form = [
            'title' => $this->form_title,
            'name' =>$this->form_name,
            'method' => $this->form_method,
            'put_patch' => $this->form_method_put_patch,
            'action' => $this->form_action,
            'class' => $this->form_class,
            'card_class' => $this->card_class,
            'role' => $this->form_role,
            'id' => $this->form_id,
            'dir' => $this->form_dir,
            'file' => $this->form_hasFile,
            'back_url' => $this->back_url,
            'submit' => $this->submit,
            'rows' => $this->rows,

        ];
        return view('laravelform::form', compact('form'));
    }
}
