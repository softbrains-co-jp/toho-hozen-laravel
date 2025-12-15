<?php

namespace App\Services\Export;

use App\Models\Maintenance;

class LocationService
{
    public function makeTxt(string $date): string
    {
        $maintenances = Maintenance::with('trader')
            ->where(function ($q) use ($date) {
                $q->whereDate('work_plan_date', $date)
                    ->orWhereDate('t_setup_plan_date', $date);
            })
            ->orderBy('toh_cd')
            ->get([
                'toh_cd',
                'work_address',
                'trader_cd',
            ]);

        $lines = [];

        foreach ($maintenances as $m) {
            $address = $this->sanitizeAddress($m->work_address);
            $traderName = $m->trader?->name ?? '';
            $key = $traderName . $m->toh_cd;

            $lines[] = implode(',', [
                $key,
                $key,
                $address,
                8,
            ]);
        }

        return implode("\r\n", $lines) . "\r\n";
    }

    private function sanitizeAddress(?string $address): string
    {
        return $address
            ? str_replace('¥', '', $address)
            : '';
    }
}
