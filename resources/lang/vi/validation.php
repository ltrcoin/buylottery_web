<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute không đúng định dạng.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => ':attribute không được lớn hơn :max ký tự.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => ':attribute không được để trống',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute và :other không trùng nhau.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'organization' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'organization_id' => 'Tên tổ chức trực thuộc',
        'group_code' => 'Mã nhóm',
        'group_name' => 'Tên nhóm',
        'group_description' => 'Mô tả',
        'name' => 'Tên',
        'status' => 'Trạng thái',
        'type' => 'Kiểu',
        'actions' => 'Danh sách hành động',
        'description' => 'Mô tả',
        'start_date' => 'Ngày bắt đầu',
        'end_date' => 'Ngày kết thúc'
    ],

    'user' => [
        'fullname' => 'Hãy nhập họ tên',
        'group_id' => 'Hãy chọn nhóm',
        'email' => 'Hãy nhập email',
        'email2' => 'Email không đúng',
        'password_required' => 'Hãy nhập password',
        'repassword_required' => 'Hãy nhập lại password',
        'user_same_password' => 'Nhập lại password sai',
    ],

    'organize' => [
        'name' => 'Tên tổ chức là bắt buộc',
        'type' => 'Chọn kiểu tổ chức',
        'code' => 'Chọn mã tổ chức',
        'address' => 'Nhập địa chỉ',
        'tel' => 'Nhập số điện thoại',
        'email' => 'Nhập email',
        'email2' => 'Không đúng định dạng email',
        'legal_representative_name' => '',
        'total_current_capital' => 'Nhập tổng số vốn hiện tại',
        'certificate' => 'Upload giấy chứng nhận hoạt động',
        'established_date' => 'Chọn ngày thành lập',
        'support_type' => 'Chọn loại hình hỗ trợ',
        'support_description' => 'Mô tả chi tiết dự định hỗ trợ',
        'support_time' => 'Thời gian hỗ trợ',
        'costs' => 'Nhập chi phí',
        'people_type' => 'Hãy chọn',
        'business_areas' => 'Lĩnh vực kinh doanh',
        'target_market' => 'Nhập thị trường mục tiêu',
        'outstanding_features' => 'Nhập các tính năng nổi bật',
        'investment_status' => 'Hãy chọn',
        'properties' => 'Hãy chọn tính chất',
        'level' => 'Chọn kiểu tổ chức',
        'dob' => 'Nhập ngày tháng năm sinh',
        'input_excel' => 'Hãy nhập tệp excel (.xls, .xlsx)'
    ]
];
