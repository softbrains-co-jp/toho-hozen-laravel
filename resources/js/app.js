import './bootstrap';

import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import { Japanese } from "flatpickr/dist/l10n/ja.js";
flatpickr.localize(Japanese);

import '../css/app.css';

// オプション設定（任意）
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: 'toast-top-center',
    timeOut: 4000,
};

// Alpineのマジックヘルパーとして登録
Alpine.magic('toastr', () => toastr);

