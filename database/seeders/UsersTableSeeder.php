<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bolim=[
            'Xodimlar bo\'limi',
            'Buxgalteriya',
            'O\'quv uslubiy bo\'limi',
            "Yoshlar bilan ishlash Ma'naviyat va Ma'rifat bo'limi",
            "Marketing va talabalar amaliyoti bo'limi",
            "Ta'lim sifatini nazorat qilish bo'limi",
            "Fuqaro va mehnat muhofazasi bo'limi",
            "Devonxona va Arxiv",
            "Xalqaro hamkorlik bo'limi",
            "Ilmiy-inavatsion ishlanmalarni tijoratlashtirish bo'limi",
            "Reja-moliya bo'limi",
            "Korrupsiyaga qarshi kurashish \"Komplaens-nazorat\"tizimini boshqarish bo'limi",
            "Xorijiy oliy talim muassasalari bilan hamkorlikdagi qo'shma talim dasturlarini muvofiqlashtirish bo'limi",
            "Yuriskonsult",
            "Audit",
            "Matbuot xizmati",
            "Filial kengashi",
            "Bosh muhandis",
            "Yoshlar ittifoqi boshlang‘ich tashkiloti",
            "Jismoniy va yuridik shaxslarning murojaatlari bilan ishlash, nazorat va monitoring bo‘limi",
            "O'qitishni texnik vositalar bilan ta'minlash",
            "Texnik foydalanish va xo'jalik bo'limi"
        ];
        $fa=[
            'Amaliy matematika fakulteti',
            'Psixologiya fakulteti'
        ];
        $kaf=[
            'Amaliy matematika',
            'Kompyuter ilmlari va dasturlashtirish',
            "Ijtimoiy fanlar",
            "O'zbek tili va Adabiyoti",
            "Xorijiy tillar",
            "Biotexnologiya",
            "Iqtisodiyot",
            "Psixologiya kafedrasi",
            "Межфакультетские дисциплины"
        ];
        foreach($bolim as $b){
            DB::table('bolims')->insert([
                'name' => $b,
                'bolim_id'=>1
            ]);
        }
        foreach($fa as $b){
            DB::table('bolims')->insert([
                'name' => $b,
                'bolim_id'=>2
            ]);
        }
        
        DB::table('users')->insert([
            'name' => 'Asliddin',
            'lavozim' => 'admin',
            'fam' => 'Asliddin',
            'sh' => 'Asliddin',
            'phone' => '+998991234567',
            'email' => 'a@jbnuu.uz',
            'bolim_id'=>'1',
            'role' => '3',
            'password' => Hash::make('a')
        ]);

        DB::table('users')->insert([
            'lavozim' => 'ishchi',
            'name' => 'Ishchi',
            'fam' => 'Ishchi',
            'sh' => 'Asliddin',
            'phone' => '+998991234565',
            'bolim_id'=>'2',
            'email' => 'b1@jbnuu.uz',
            'role' => '2',
            'password' => Hash::make('a')
        ]);
        DB::table('users')->insert([
            'name' => 'Ishchi',
            'lavozim' => 'ishchi',
            'fam' => 'Ishchi',
            'sh' => 'Asliddin',
            'phone' => '+998991234566',
            'email' => 'b2@jbnuu.uz',
            'bolim_id'=>'1',
            'role' => '2',
            'password' => Hash::make('a')
        ]);
        DB::table('users')->insert([
            'name' => 'User',
            'lavozim' => 'User',
            'fam' => 'User',
            'sh' => 'Asliddin',
            'phone' => '+998991234569',
            'email' => 'c1@jbnuu.uz',
            'bolim_id'=>'2',
            'role' => '1',
            'password' => Hash::make('a')
        ]);
        DB::table('users')->insert([
            'name' => 'User',
            'fam' => 'User',
            'lavozim' => 'User',
            'sh' => 'Asliddin',
            'phone' => '+998991234568',
            'email' => 'c2@jbnuu.uz',
            'role' => '1',
            'bolim_id'=>'1',
            'password' => Hash::make('a')
        ]);
    }
}
