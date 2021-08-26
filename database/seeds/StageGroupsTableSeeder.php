<?php

use App\Stage;
use App\StageGroup;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\User;

class StageGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            [
                'title' => 'Ввод и регистрация рекламации', 'sequence' => 1, //'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
                'stages' => [
                    [
                        'title'=> 'Ввод и регистрация рекламации',
                        'sequence' => 101,
                        'has_action' => true,
                        'has_date' => true,
                        'has_attachment' => true,
                        'has_approval' => false,
                        'owner' => User::ROLE_EMPLOYEE
                    ]
                ]
            ],
            [
                'title' => 'Принятые меры в течение  24 часа', 'sequence' => 2, //'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
                'stages' => [
                    [
                        'title' => 'Containment – Временная мера',
                        'sequence' => 201,
                        'has_action' => true,
                        'has_date' => true,
                        'has_attachment' => true,
                        'has_approval' => false,
                        'owner' => User::ROLE_SUPPLIER
                    ],
                    [
                        'title' => 'Подтверждения / Отказ',
                        'sequence' => 299,
                        'has_action' => false,
                        'has_date' => false,
                        'has_attachment' => false,
                        'has_approval' => true,
                        'owner' => User::ROLE_EMPLOYEE
                    ],
                ]
            ],
            [
                'title' => 'Корректирующие меры', 'sequence' => 3, //'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
                'stages' => [
                    [
                        'title' => 'Внедрение корректирующих мер',
                        'sequence' => 301,
                        'has_action' => true,
                        'has_date' => true,
                        'has_attachment' => true,
                        'has_approval' => false,
                        'owner' => User::ROLE_SUPPLIER
                    ],
                    [
                        'title' => 'Внедрение системы предотвращения ошибок',
                        'sequence' => 302,
                        'has_action' => true,
                        'has_date' => true,
                        'has_attachment' => true,
                        'has_approval' => false,
                        'owner' => User::ROLE_SUPPLIER
                    ],
                    [
                        'title' => 'Пункт не нужен, удалить',
                        'sequence' => 303,
                        'has_action' => true,
                        'has_date' => true,
                        'has_attachment' => true,
                        'has_approval' => false,
                        'owner' => User::ROLE_SUPPLIER
                    ],
                    [
                        'title' => 'Подтверждение / Отказ',
                        'sequence' => 304,
                        'has_action' => false,
                        'has_date' => false,
                        'has_attachment' => false,
                        'has_approval' => true,
                        'owner' => User::ROLE_EMPLOYEE
                    ]
                ]
            ],
            [
                'title' => 'Подтверждение', 'sequence' => 4, //'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
                'stages' => [
                    [
                        'title' => 'Quality alert  - Выпуск оповещения о качестве',
                        'sequence' => 401,
                        'has_action' => true,
                        'has_date' => true,
                        'has_attachment' => true,
                        'has_approval' => false,
                        'owner' => User::ROLE_SUPPLIER
                    ],
                    [
                        'title' => 'Результат проверки по 1-3 Диамонд',
                        'sequence' => 402,
                        'has_action' => true,
                        'has_date' => true,
                        'has_attachment' => true,
                        'has_approval' => false,
                        'owner' => User::ROLE_EMPLOYEE
                    ],
                    [
                        'title' => 'Подтверждение',
                        'sequence' => 999,
                        'has_action' => true,
                        'has_date' => true,
                        'has_attachment' => true,
                        'has_approval' => false,
                        'owner' => User::ROLE_EMPLOYEE
                    ],
                ]
            ],
        ];

        try{
            foreach ($groups as $group){
                $model = new StageGroup();
                $model->title = $group['title'];
                $model->sequence = $group['sequence'];
                $model->save();

                foreach ($group['stages'] as $stage){
                    $sub_model = new Stage();
                    $sub_model->title = $stage['title'];
                    $sub_model->sequence = $stage['sequence'];
                    $sub_model->has_action = $stage['has_action'];
                    $sub_model->has_date = $stage['has_date'];
                    $sub_model->has_attachment = $stage['has_attachment'];
                    $sub_model->has_approval = $stage['has_approval'];
                    $sub_model->owner = $stage['owner'];
                    $sub_model->stage_group_id = $model->id;
                    $sub_model->save();
                }
            }
        }
        catch (Exception $ex){
            echo $ex->getMessage();
        }

        //StageGroup::insert($groups);
    }
}
