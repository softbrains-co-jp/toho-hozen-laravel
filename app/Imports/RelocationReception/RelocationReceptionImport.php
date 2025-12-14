<?php

namespace App\Imports\RelocationReception;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Importable;

class RelocationReceptionImport implements WithMultipleSheets
{
    use Importable;

    public $relocationReception = []; // ← コントローラで使えるように保持

    public function sheets(): array
    {
        return [
            0 => new RelocationReceptionSheetImport($this), // ← 自分自身を渡す
        ];
    }
}
