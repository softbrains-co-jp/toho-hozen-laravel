<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Maintenance;
use Carbon\Carbon;
use Exception;

class updateTimeField extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-time-field';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
$this->line("処理開始");
        $maintenances = [];
        // try {
//             $maintenances = Maintenance::where('toh_cd', '06HK1275')
//             // $maintenances = Maintenance::whereNotNull('toh_cd')
//                 ->get();
// dd($maintenances);

//             $this->line("件数：" . count($maintenances));
//         } catch (\Exception $e) {
//             $this->error("エラー発生：" . $e->getMessage());
//             return Command::FAILURE;
//         }

            Maintenance::chunk(1000, function ($maintenances) {
                foreach ($maintenances as $maintenance) {

                    // 調査作業開始時間
                    $conduct_start_datetime = $this->convertTimeField($maintenance->conduct_start_datetime);
                    if ($conduct_start_datetime) {
                        $maintenance->conduct_start_datetime = $conduct_start_datetime;
                    }
                    elseif ($conduct_start_datetime === false) {
                        $this->error("{$maintenance->toh_cd}:conduct_start_datetime = {$maintenance->conduct_start_datetime}");
                    }

                    // 調査作業終了時間
                    $conduct_end_datetime = $this->convertTimeField($maintenance->conduct_end_datetime);
                    if ($conduct_end_datetime) {
                        $maintenance->conduct_end_datetime = $conduct_end_datetime;
                    }
                    elseif ($conduct_end_datetime === false) {
                        $this->error("{$maintenance->toh_cd}:conduct_end_datetime = {$maintenance->conduct_end_datetime}");
                    }

                    // 仮移設作業開始時間
                    $t_setup_start_datetime = $this->convertTimeField($maintenance->t_setup_start_datetime);
                    if ($t_setup_start_datetime) {
                        $maintenance->t_setup_start_datetime = $t_setup_start_datetime;
                    }
                    elseif ($t_setup_start_datetime === false) {
                        $this->error("{$maintenance->toh_cd}:t_setup_start_datetime = {$maintenance->t_setup_start_datetime}");
                    }

                    // 仮移設作業終了時間
                    $t_setup_end_datetime = $this->convertTimeField($maintenance->t_setup_end_datetime);
                    if ($t_setup_end_datetime) {
                        $maintenance->t_setup_end_datetime = $t_setup_end_datetime;
                    }
                    elseif ($t_setup_end_datetime === false) {
                        $this->error("{$maintenance->toh_cd}:t_setup_end_datetime = {$maintenance->t_setup_end_datetime}");
                    }

                    // 作業開始時間
                    $work_start_datetime = $this->convertTimeField($maintenance->work_start_datetime);
                    if ($work_start_datetime) {
                        $maintenance->work_start_datetime = $work_start_datetime;
                    }
                    elseif ($work_start_datetime === false) {
                        $this->error("{$maintenance->toh_cd}:work_start_datetime = {$maintenance->work_start_datetime}");
                    }

                    // 作業終了時間
                    $work_end_datetime = $this->convertTimeField($maintenance->work_end_datetime);
                    if ($work_end_datetime) {
                        $maintenance->work_end_datetime = $work_end_datetime;
                    }
                    elseif ($work_end_datetime === false) {
                        $this->error("{$maintenance->toh_cd}:work_end_datetime = {$maintenance->work_end_datetime}");
                    }

                    $maintenance->save();
                }
            });
$this->line("処理終了");
    }


    private function convertTimeField($value) {
        $return_value = null;

        try {
            if ($value) {
                $value = mb_convert_kana($value, 'as');
                $value = str_replace('::', ':', str_replace(';', ':', $value));

                $date = new Carbon($value);
                $return_value = $date->format('H:i');
            }
        }
        catch(Exception $e) {
            return false;
        }

        return $return_value;
    }
}
