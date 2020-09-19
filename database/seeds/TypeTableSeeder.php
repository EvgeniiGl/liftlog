<?php

use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['title' => 'АПД'],
            ['title' => 'АГП ПО УКСЛ'],
            ['title' => 'ПРОНИКНОВЕНИЕ В ШАХТУ'],
            ['title' => 'НЕ ЗАКРЫТЫ ДК'],
            ['title' => 'МНОГОКРАТНЫЙ РЕВЕРС'],
            ['title' => 'АВАРИЙНАЯ БЛОКИРОВКА'],
            ['title' => 'КЗ ЦЕПИ БЕЗОПАСНОСТИ'],
            ['title' => 'НЕ ОТКРЫТЫ ДВЕРИ ПОСЛЕ ДВИЖЕНИЯ'],
            ['title' => 'ОТСУТ. НАПР. В Ц/УПР'],
            ['title' => 'ОТСУТ. СВЯЗЬ С MCS'],
            ['title' => 'НЕТ СВЯЗИ С ЛБ'],
            ['title' => 'ЗАЖАТА КНОПКА "СТОП"'],
            ['title' => 'ЗАЖАТА КНОПКА "ВЫЗОВ"'],
            ['title' => 'РЦБ'],
            ['title' => 'НЕТ Т.О.'],
            ['title' => 'ПОСТОРОННИЙ ШУМ ПРИ ДВИЖЕНИИ'],
            ['title' => 'ЛЮФТ КАБИНЫ'],
            ['title' => 'СКРЕЖЕТ ДК'],
            ['title' => 'СКРЕЖЕТ ДШ'],
            ['title' => 'ТЕМНАЯ КАБИНА'],
            ['title' => 'НЕДОСТАТОЧНОЕ ОСВЕЩЕНИЕ КАБИНЫ'],
            ['title' => 'НЕТ АВАРИЙНОГО ОСВЕЩЕНИЯ'],
            ['title' => 'ПУТАЕТ ЭТАЖИ'],
            ['title' => 'НЕ РАБОТАЕТ КН "ВЫЗОВА"'],
            ['title' => 'НЕ РАБОТАЕТ КН "ПРИКАЗА"'],
            ['title' => 'НЕ РАБОТАЕТ КН "ВЫЗОВА ДИСП."'],
            ['title' => 'ПРОНИКНОВЕНИЕ В МП'],
            ['title' => 'ОТКЛ. ЭЛ. ЭНЕРГИИ'],
            ['title' => 'ДВЕРИ ОТКРЫВАЮТСЯ С ПОВТОРА'],
            ['title' => 'НЕТ ПОВТОРА "ВЫЗОВА"'],
            ['title' => 'ПОЖАРНАЯ ОПАСНОСТЬ'],
            ['title' => 'РЕЖИМ "ПОГРУЗКА"'],
            ['title' => 'НЕ ИДЕТ В ДВИЖЕНИЕ "НОРМА"'],
            ['title' => 'НЕ СРАБ. ДЧ "УБ"'],
            ['title' => 'НЕ СРАБ. ДЧ "ДК"']
        ];

        DB::table('types')->insert($types);
    }
}
