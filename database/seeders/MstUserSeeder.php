<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\MstUser;

class MstUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => '鈴木浩二', 'login_id' => 'TO000986', 'email' => 'k-suzuki@toho-elec.co.jp', 'password' => 'Uj8wmRXZ', 'role' => '管理者'],
            ['name' => '栗田充', 'login_id' => 'TO100046', 'email' => 't-kurita@toho-elec.co.jp', 'password' => 's2ZPJHjw', 'role' => '管理者'],
            ['name' => '安立雄一郎', 'login_id' => 'TO000983', 'email' => 'y-adachi@toho-elec.co.jp', 'password' => 'Pt4y#VMA', 'role' => '管理者'],
            ['name' => '金子央歩', 'login_id' => 'TO000310', 'email' => 'hisamu-kaneko@toho-elec.co.jp', 'password' => 'N4gdXH9y', 'role' => '管理者'],
            ['name' => '藤田彩佳', 'login_id' => 'TO100192', 'email' => 'ayaka-fujita@toho-ac.com', 'password' => 'Qv6#YrN3', 'role' => '管理者'],
            ['name' => '前田和也', 'login_id' => 'TO000308', 'email' => 'kazuya-maeda@toho-elec.co.jp', 'password' => 'aX76n8cV', 'role' => '管理者'],
            ['name' => '渡辺浩之', 'login_id' => 'TO000232', 'email' => 'hiroyuki-watanabe@toho-ac.com', 'password' => 'Ww8xQ9m5', 'role' => '管理者'],
            ['name' => '羽太悠', 'login_id' => 'TO100203', 'email' => 'ha-hata@toho-ac.com', 'password' => 'uF2T!cgn', 'role' => '東邦ユーザー'],
            ['name' => '熊谷愛子', 'login_id' => 'TO100050', 'email' => 'aiko-kumagai@toho-ac.com', 'password' => 'mN3C!PXf', 'role' => '東邦ユーザー'],
            ['name' => '木村貴浩', 'login_id' => 'TO000280', 'email' => 'takahiro-kimura@toho-ac.com', 'password' => 'H4hc=LB5', 'role' => '東邦ユーザー'],
            ['name' => '鈴木知郁', 'login_id' => 'TO000234', 'email' => 'tomofumi-suzuki@toho-ac.com', 'password' => 'Vs25xQ+L', 'role' => '東邦ユーザー'],
            ['name' => '平林祐貴', 'login_id' => 'TO100206', 'email' => 'yuuki-hirabayashi@toho-ac.com', 'password' => 'Ei4D7ast', 'role' => '東邦ユーザー'],
            ['name' => '有賀裕之', 'login_id' => 'HOU00083', 'email' => 'h-ariga@daiko-tk.com', 'password' => 'xV4$Y23u', 'role' => '一般ユーザー'],
            ['name' => '石塚敏之', 'login_id' => 'HOU00085', 'email' => 'ishizuka@daiko-tk.com', 'password' => 'N6qCFLxw', 'role' => '一般ユーザー'],
            ['name' => '赤嶺尚紀', 'login_id' => 'HOU00013', 'email' => 'naoki.akamine@daiko-tk.com', 'password' => 'i6R%YUvE', 'role' => '一般ユーザー'],
            ['name' => '小林亮太', 'login_id' => 'HOU00078', 'email' => 'ryota.kobayashi@daiko-tk.com', 'password' => 'Uq2Sfy$R', 'role' => '一般ユーザー'],
            ['name' => '杉塚淳子', 'login_id' => 'HOU00079', 'email' => 'jyunko.sugizuka@housei-tk.com', 'password' => 'Jf9cG53y', 'role' => '一般ユーザー'],
            ['name' => '佐野拓美', 'login_id' => 'HOU00092', 'email' => 'kanagawa-001@daiko-tk.com', 'password' => 'K7k@N$rJ', 'role' => '一般ユーザー'],
            ['name' => '清水千春', 'login_id' => 'HOU00090', 'email' => 'kanagawa-002@daiko-tk.com', 'password' => 'd8VMa!N$', 'role' => '一般ユーザー'],
            ['name' => '本木茂隆', 'login_id' => 'NSN00031', 'email' => 'shigetaka-motoki@nissan-tsushin.co.jp', 'password' => 'Ba6D!Ejz', 'role' => '一般ユーザー'],
            ['name' => '嶋田和英', 'login_id' => 'NSN00033', 'email' => 'kazuhide-shimada@nissan-tsushin.co.jp', 'password' => 'Zg4ECu@h', 'role' => '一般ユーザー'],
            ['name' => '嶋田拓', 'login_id' => 'NSN00045', 'email' => 'taku-shimada@nissan-tsushin.co.jp', 'password' => 'mT5gcD36', 'role' => '一般ユーザー'],
            ['name' => 'ファンティトゥヒエン', 'login_id' => 'NSN00048', 'email' => 'pham-hien@nissan-tsushin.co.jp', 'password' => 'wN8WY+Uv', 'role' => '一般ユーザー'],
            ['name' => '田子裕子', 'login_id' => 'NSN00049', 'email' => 'yuko-tago@nissan-tsushin.co.jp', 'password' => 'U6nWtbEe', 'role' => '一般ユーザー'],
            ['name' => '伊沢英人', 'login_id' => 'NTS00004', 'email' => 'h_izawa@telesys.jp', 'password' => 'qA7h6$RF', 'role' => '一般ユーザー'],
            ['name' => '伊藤信行', 'login_id' => 'NTS00001', 'email' => 'n_ito@telesys.jp', 'password' => 'Zd6TKFAr', 'role' => '一般ユーザー'],
            ['name' => '日野孝昭', 'login_id' => 'NTS00009', 'email' => 'h_ide@telesys.jp', 'password' => 'N7d=HRPp', 'role' => '一般ユーザー'],
            ['name' => '井手英樹', 'login_id' => 'NTS00018', 'email' => 't_hino@telesys.jp', 'password' => 'G4fsT!@y', 'role' => '一般ユーザー'],
            ['name' => '外山拓巳', 'login_id' => 'SND00001', 'email' => 't.toyama@sanei-densetu.com', 'password' => 'B7zHYTxj', 'role' => '一般ユーザー'],
            ['name' => '濱崎勇作', 'login_id' => 'SND00002', 'email' => 'y.hamasaki@sanei-densetu.com', 'password' => 'A4pymU6s', 'role' => '一般ユーザー'],
            ['name' => '大塚拓郎', 'login_id' => 'TLE00003', 'email' => 't-ootsuka@tele-engi.co.jp', 'password' => 'Fm9qMvnB', 'role' => '一般ユーザー'],
            ['name' => '田邊逸裕', 'login_id' => 'TLE00004', 'email' => 'i-tanabe@tele-engi.co.jp', 'password' => 'Tq3KQ+Fx', 'role' => '一般ユーザー'],
            ['name' => '宮本純一', 'login_id' => 'TLE00021', 'email' => 'j-miyamoto@tele-engi.co.jp', 'password' => 'hT6RM97K', 'role' => '一般ユーザー'],
            ['name' => '高橋礼子', 'login_id' => 'TLE00023', 'email' => 'r-kaneko@tele-engi.co.jp', 'password' => 'v8HTeCA9', 'role' => '一般ユーザー'],
            ['name' => '吉田美由紀', 'login_id' => 'TLE00027', 'email' => 'auhikari-home@tele-engi.co.jp', 'password' => 'Ju5zb+yH', 'role' => '一般ユーザー'],
            ['name' => '永吉麻美', 'login_id' => 'TLE00036', 'email' => 'a-nagayoshi@tele-engi.co.jp', 'password' => 'yU7LSk8d', 'role' => '一般ユーザー'],
        ];

        foreach ($users as $user) {
            MstUser::updateOrCreate([
                'login_id' => $user['login_id'],
            ], [
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'role' => $this->mapRole($user['role']),
            ]);
        }
    }

    private function mapRole(string $role): int
    {
        return match ($role) {
            '管理者' => MstUser::ROLE_ADMIN,
            '東邦ユーザー', '東邦ユーザ' => MstUser::ROLE_TOHO,
            '一般ユーザー', '一般ユーザ' => MstUser::ROLE_USER,
            default => MstUser::ROLE_USER,
        };
    }
}
