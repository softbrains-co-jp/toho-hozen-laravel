import './bootstrap';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
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

