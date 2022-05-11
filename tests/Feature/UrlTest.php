<?php

namespace Tests\Feature;

use App\Http\Controllers\BasicController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Exception;

class UrlTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @testdox 當資料表為空時，新增一筆「https://www.google.com.tw」，應該只會有一筆「https://www.google.com.tw」資料
     *
     * @return void
     */
    public function test_should_show_one_data_when_add_data_into_empty_table()
    {
        $basicController = new \App\BasicController();

        $expected = 'https://www.google.com.tw';

        $actual = $basicController->createUrl($expected)->origin_url;

        $this->assertSame($expected, $actual);
    }

    /**
     * @testdox 當資料表已有「https://www.google.com.tw」時，新增一筆「https://laravel.com/」，應該要有兩筆「https://www.google.com.tw」及「https://laravel.com/」資料
     *
     * @return void
     */
    public function test_should_show_all_data_when_add_data_into_table()
    {
        $basicController = new \App\BasicController();

        $expected = ['https://www.google.com.tw', 'https://laravel.com/'];

        $basicController->createUrl($expected[0]);
        $actual = $basicController->createUrl($expected[1])->origin_url;

        $this->assertSame($expected[1], $actual);

    }

    /**
     * @testdox 新增一筆「不符合 URL 格式」的資料，應該會有「輸入的 URL 不符合格式！」的錯誤訊息
     *
     * @return void
     */
    public function test_should_show_exception_when_add_error_url_into_table()
    {
        $this->expectException(Exception::class);

        $basicController = new \App\BasicController();

        $inputUrl = 'http://localhost';

        $basicController->checkUrlRules($inputUrl);
    }

    /**
     * @testdox 當資料表已有「https://www.google.com.tw」時，新增一筆「https://www.google.com.tw」的資料，應該會顯示「已儲存的短網址」紀錄
     *
     * @return void
     */
    public function test_should_show_record_when_add_same_url_into_table()
    {
        $basicController = new \App\BasicController();

        $expected = 'https://www.google.com.tw';

        $actual = $basicController->createUrl($expected)->origin_url;

        $this->assertSame($expected, $actual);
    }
}
