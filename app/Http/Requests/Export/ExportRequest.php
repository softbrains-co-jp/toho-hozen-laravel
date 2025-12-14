<?php

namespace App\Http\Requests\Export;

use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $code = $this->input('key_cd');

        return [
            'action' => [
                'required',
                'string'
            ],
            'export01_from' => [
                'required_if:action,export01',
                'date',
            ],
            'export01_to' => [
                'required_if:action,export01',
                'date',
            ],
        ];
    }

    public function attributes() {
        return [
            'export01_from' => '付託日(From)',
            'export01_to' => '付託日(To)',
            'check_date' => 'チェック日',
            't_term_start_date' => '仮工期（自）',
            't_term_end_date' => '仮工期（至）',
            't_term2_start_date' => '仮工期変更後（自）',
            't_term2_end_date' => '仮工期変更後（至）',
            'term_start_date' => '本工期（自）',
            'term_end_date' => '本工期（至）',
            'term2_start_date' => '仮工期変更後（自）',
            'term2_end_date' => '仮工期変更後（至）',
            'kddi_oder_date' => 'KDDI依頼日',
            'report_date' => '工事完了報告日',
            'work_report_date' => '工事報告日',
            'conduct_commit_date' => '調査付託日',
            'conduct_plan_date' => '現場調査予定日',
            'conduct_action_date' => '現場調査実施日',
            'conduct_report_date' => '調査報告日',
            'check1_date' => '建柱確認日1',
            'check2_date' => '建柱確認日2',
            'check3_date' => '建柱確認日3',
            't_setup_plan_date' => '仮移設予定日',
            't_setup_action_date' => '仮移設実施日',
            'commit_date' => '工事付託日',
            'work_plan_date' => '作業予定日',
            'work_action_date' => '作業実施日',
            'kddi_check_date' => 'KDDI確認依頼日',
            'add_order_date' => '追加申請依頼日',
            'add_receive_date' => '追加申請回答日',
            'add_design_receive_date' => '追加申請図面受領日',
            'complete_order_date' => '竣工報告依頼日',
            'complete_receive_date' => '竣工届受理日',
            'cancel_order_date' => '解除申請依頼日',
            'cancel_report_receive_date' => '解除竣工届受領日',
            'cancel_design_receive_date' => '解除申請図面受領日',
            'conduct_receive_date' => '調査報告書受領日',
            't_work_receive_date' => '仮工事報告書受領日',
            'complete_design_receive_date' => '竣工図書受領日',
            'wire_change_order_date' => '電線設備変更依頼書送信日',
            'gemini_order_date' => 'GEMINI修正依頼日',
            'complete_report_date' => '竣工報告日',
        ];
    }

    public function messages()
    {
        return [
            'export01_from.required_if' => ':attributeを入力してください。',
            'export01_to.required_if' => ':attributeを入力してください。',
        ];
    }
}
