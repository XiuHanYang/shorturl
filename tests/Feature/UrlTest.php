<?php

namespace Tests\Feature;

use App\Http\Controllers\UrlController;
use App\Models\Urls;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Exception;

class UrlTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @testdox 當資料表為空時，新增一筆命名為「hannah」的「https://www.google.com.tw」，應該只會有一筆「https://www.google.com.tw」資料
     *
     * @return void
     */
    public function test_should_show_one_data_when_add_data_into_empty_table()
    {
        $basicController = new \App\BasicController();

        $expected = ['inputUrl' => 'https://www.google.com.tw', 'inputName' => 'hannah'];

        $actual = $basicController->createUrl($expected)->origin_url;

        $this->assertSame($expected['inputUrl'], $actual);
    }

    /**
     * @testdox 當資料表已有命名為「hannah」的「https://www.google.com.tw」時，新增一筆命名為「hannah-1」的「https://laravel.com/」，應該要有兩筆「https://www.google.com.tw」及「https://laravel.com/」資料
     *
     * @return void
     */
    public function test_should_show_all_data_when_add_data_into_table()
    {
        $basicController = new \App\BasicController();

        $expected = [
            ['inputUrl' => 'https://www.google.com.tw', 'inputName' => 'hannah'],
            ['inputUrl' => 'https://laravel.com/', 'inputName' => 'hannah-1']
        ];

        $basicController->createUrl($expected[0]);
        $actual = $basicController->createUrl($expected[1])->origin_url;

        $this->assertSame($expected[1]['inputUrl'], $actual);
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
     * @testdox 當資料表已有命名為「hannah」的「https://www.google.com.tw」時，新增一筆「https://www.google.com.tw」的資料，應該會顯示「已儲存的短網址」紀錄
     *
     * @return void
     */
    public function test_should_show_record_when_add_same_url_into_table()
    {
        $basicController = new \App\BasicController();

        $expected = ['inputUrl' => 'https://www.google.com.tw', 'inputName' => 'hannah'];

        $actual = $basicController->createUrl($expected)->origin_url;

        $this->assertSame($expected['inputUrl'], $actual);
    }

    /**
     * @testdox 當資料表已有命名為「hannah」的「https://www.google.com.tw」時，新增一筆命名為「hannah」的「https://laravel.com」的資料，應該會有「已重複命名！」的錯誤訊息
     *
     * @return void
     */
    public function test_should_show_exception_when_add_same_name_into_table()
    {
        $this->expectException(Exception::class);

        $basicController = new \App\BasicController();

        $expected = [
            ['inputUrl' => 'https://www.google.com.tw', 'inputName' => 'hannah'],
            ['inputUrl' => 'https://laravel.com/', 'inputName' => 'hannah']
        ];

        $basicController->createUrl($expected[0]);
        $basicController->checkNameOnly($expected[1]['inputName']);
    }

    /**
     * @testdox 當資料表已有命名為「hannah」的「https://www.google.com.tw」時，刪除「https://www.google.com.tw」，應該會更新「deleted_at」時間
     *
     * @return void
     */
    public function test_should_show_status_code_when_id_in_table()
    {
        $urlController = new UrlController();
        $basicController = new \App\BasicController();

        $data = ['inputUrl' => 'https://www.google.com.tw', 'inputName' => 'hannah'];

        $data = $basicController->createUrl($data);

        $actual = $urlController->destroy(6)->status();

        $this->assertSame(200, $actual);
    }

    /**
     * @testdox 刪除「不存在的 id」，應該會有「不存在的 id ！」的錯誤訊息
     *
     * @return void
     */
    public function test_should_show_exception_when_id_not_exist_table()
    {
        $this->expectException(Exception::class);

        $urlController = new UrlController();

        $urlController->destroy(1);
    }
}
