<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TestCreateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "question"=> '2*2= qiymati toping',
                "test_type"=> "unique",
                "position_id"=> null,
                "answer_option" => [
                    [
                        "option" => "4",
                        "right" => true
                    ],
                    [
                        "option" => "6",
                        "right" => false
                    ],
                    [
                        "option" => "5",
                        "right" => false
                    ],
                ]
            ],
            [
                "question"=> '2*2+2= qiymati toping',
                "test_type"=> "unique",
                "position_id"=> null,
                "answer_option" => [
                    [
                        "option" => "4",
                        "right" => false
                    ],
                    [
                        "option" => "6",
                        "right" => true
                    ],
                    [
                        "option" => "5",
                        "right" => false
                    ],
                ]
            ],
            [
                "question"=> '2*2+2-2+1= qiymati togro keladigan javobni belgilang',
                "test_type"=> "multiple",
                "position_id"=> null,
                "answer_option" => [
                    [
                        "option" => "5",
                        "right" => true
                    ],
                    [
                        "option" => "6",
                        "right" => false
                    ],
                    [
                        "option" => "5",
                        "right" => true
                    ],
                ]
            ],
            [
                "question"=> "Javobi 18 ga teng bo'lgan misolni toping.",
                "test_type"=> "unique",
                "position_id"=> null,
                "answer_option" => [
                    [
                        "option" => "6+6+5",
                        "right" => false
                    ],
                    [
                        "option" => "7+3+9",
                        "right" => false
                    ],
                    [
                        "option" => "7+5+6",
                        "right" => true
                    ],
                ]
            ],
            [
                "question"=> "Sonlar ichida eng katta ikki xonali sonni belgilang?",
                "test_type"=> "unique",
                "position_id"=> null,
                "answer_option" => [
                    [
                        "option" => "56",
                        "right" => false
                    ],
                    [
                        "option" => "90",
                        "right" => true
                    ],
                    [
                        "option" => "80",
                        "right" => false
                    ],
                ]
            ],
            [
                "question"=> "Sonlar ichidan eng kichik birxonali sonni belgilang?",
                "test_type"=> "unique",
                "position_id"=> null,
                "answer_option" => [
                    [
                        "option" => "56",
                        "right" => true
                    ],
                    [
                        "option" => "90",
                        "right" => false
                    ],
                    [
                        "option" => "80",
                        "right" => false
                    ],
                ]
            ],
            [
                "question"=> "Javobida 4 chiqadigan qatorni belgilang?",
                "test_type"=> "multiple",
                "position_id"=> null,
                "answer_option" => [
                    [
                        "option" => "10 - 6",
                        "right" => true
                    ],
                    [
                        "option" => "10-1",
                        "right" => false
                    ],
                    [
                        "option" => "6-2",
                        "right" => true
                    ],
                ]
            ],
            [
                "question"=> " Taqqoslash to'g'ribajarilgan qatorni toping?",
                "test_type"=> "unique",
                "position_id"=> null,
                "answer_option" => [
                    [
                        "option" => "10>1",
                        "right" => true
                    ],
                    [
                        "option" => "52>53",
                        "right" => false
                    ],
                    [
                        "option" => "14=15",
                        "right" => false
                    ],
                ]
            ],
            [
                "question"=> "To'rtta tomoni teng bo'lgan to'g'ri to`rtburchak nima deb ataladi?",
                "test_type"=> "unique",
                "position_id"=> null,
                "answer_option" => [
                    [
                        "option" => "Uchburchak",
                        "right" => false
                    ],
                    [
                        "option" => "Kvadrat",
                        "right" => true
                    ],
                    [
                        "option" => "Kesma",
                        "right" => false
                    ],
                ]
            ],
            [
                "question"=> "Ifodaning qiymatini toping. 7 – 4 + 3 = ?",
                "test_type"=> "unique",
                "position_id"=> null,
                "answer_option" => [
                    [
                        "option" => "5",
                        "right" => false
                    ],
                    [
                        "option" => "6",
                        "right" => true
                    ],
                    [
                        "option" => "7",
                        "right" => false
                    ],
                ]
            ],
            [
                "question"=> "Yig'indini toping.",
                "test_type"=> "unique",
                "position_id"=> null,
                "answer_option" => [
                    [
                        "option" => "6+10=16",
                        "right" => true
                    ],
                    [
                        "option" => "10-6=4 ",
                        "right" => false
                    ],
                    [
                        "option" => "16-6=10",
                        "right" => false
                    ],
                ]
            ],
            [
                "question"=> "Yig'indini toping. 46+44",
                "test_type"=> "unique",
                "position_id"=> null,
                "answer_option" => [
                    [
                        "option" => "90",
                        "right" => true
                    ],
                    [
                        "option" => "80",
                        "right" => false
                    ],
                    [
                        "option" => "91",
                        "right" => false
                    ],
                ]
            ],
            [
                "question"=> "Qanday sonlar natural sonlar deyildi?",
                "test_type"=> "closed",
                "position_id"=> null,
                "answer_option" => [
                    [
                        "option" => "Natural son deb sanash (sanoq) uchun ishlatiladigan sonlarga aytiladi",
                        "right" => true
                    ]
                ]
            ],
            [
                "question"=> "10*10 qiymatni toping",
                "test_type"=> "closed",
                "position_id"=> null,
                "answer_option" => [
                    [
                        "option" => "100",
                        "right" => true
                    ]
                ]
            ],
        ];
        /*
        *   position = 1
        */
        foreach ($data as $key => $val) {
            $id = DB::table('test_contents')->insertGetId([
                'title' => $val['question'],
                'test_type' => $val['test_type'],
                'position_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            foreach ($val["answer_option"] as $value) {
                DB::table('test_contents')->insert([
                    'parent_id' => $id,
                    'title' => $value['option'],
                    'right' => $value['right'],
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
        /*
        *   position = 2
        */
        foreach ($data as $key => $val) {
            $id = DB::table('test_contents')->insertGetId([
                'title' => $val['question'],
                'test_type' => $val['test_type'],
                'position_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            foreach ($val["answer_option"] as $value) {
                DB::table('test_contents')->insert([
                    'parent_id' => $id,
                    'title' => $value['option'],
                    'right' => $value['right'],
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
        /*
        *   position = 3
        */
        foreach ($data as $key => $val) {
            $id = DB::table('test_contents')->insertGetId([
                'title' => $val['question'],
                'test_type' => $val['test_type'],
                'position_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            foreach ($val["answer_option"] as $value) {
                DB::table('test_contents')->insert([
                    'parent_id' => $id,
                    'title' => $value['option'],
                    'right' => $value['right'],
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
