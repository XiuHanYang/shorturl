<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Exception;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NamespaceController;

class UrlTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @testdox 當資料表為空時，新增一筆會員為「hannah」，命名空間為「profollo」的「https://www.google.com.tw」，應該只會有一筆「https://www.google.com.tw」資料
     *
     * @return void
     */
    public function test_should_show_one_data_when_add_data_into_empty_table()
    {
        $basicController = new \App\BasicController();
        $urlController = new UrlController();

        $expected = [
            'inputMemberId'     => 1,
            'inputNamespaceId'  => 1,
            'inputUrl'          => 'https://www.google.com.tw'
        ];

        $this->call('POST', 'members', ['name' => 'hannah', 'password' => 'a12345']);
        $this->call('POST', 'namespaces', ['memberId' => 1, 'name' => 'profollo']);

        $basicController->createUrl($expected['inputUrl'], $expected['inputMemberId'], $expected['inputNamespaceId']);
        $actual = $urlController->show(1);

        $this->assertSame($expected['inputUrl'], $actual->originUrl);
    }

    /**
     * @testdox 當資料表已有會員為「hannah」，命名空間為「profollo」的「https://www.google.com.tw」時，新增一筆會員為「hannah」，命名空間為「profollo」的「https://laravel.com/」，應該要有兩筆「https://www.google.com.tw」及「https://laravel.com/」資料
     *
     * @return void
     */
    public function test_should_show_all_data_when_add_data_into_table()
    {
        $basicController = new \App\BasicController();
        $urlController = new UrlController();

        $expected = [
            [
                'inputMemberId'     => 2,
                'inputNamespaceId'  => 2,
                'inputUrl'          => 'https://www.google.com.tw'
            ],
            [
                'inputMemberId'     => 2,
                'inputNamespaceId'  => 2,
                'inputUrl'          => 'https://laravel.com/'
            ]
        ];

        $this->call('POST', 'members', ['name' => 'hannah', 'password' => 'a12345']);
        $this->call('POST', 'namespaces', ['memberId' => 2, 'name' => 'profollo']);

        $basicController->createUrl($expected[0]['inputUrl'], $expected[0]['inputMemberId'], $expected[0]['inputNamespaceId']);
        $basicController->createUrl($expected[1]['inputUrl'], $expected[1]['inputMemberId'], $expected[1]['inputNamespaceId']);
        $actual = $urlController->show(3);

        $this->assertSame($expected[1]['inputUrl'], $actual->originUrl);
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
     * @testdox 當資料表已有會員為「hannah」，命名空間為「profollo」的「https://www.google.com.tw」時，新增一筆會員為「hannah」，命名空間為「profollo」的「https://www.google.com.tw」的資料，應該會顯示「已儲存的短網址」紀錄
     *
     * @return void
     */
    public function test_should_show_record_when_add_same_url_into_table()
    {
        $basicController = new \App\BasicController();
        $urlController = new UrlController();

        $expected = [
            [
                'inputMemberId'     => 3,
                'inputNamespaceId'  => 3,
                'inputUrl'          => 'https://www.google.com.tw'
            ],
            [
                'inputMemberId'     => 3,
                'inputNamespaceId'  => 3,
                'inputUrl'          => 'https://www.google.com.tw'
            ]
        ];

        $this->call('POST', 'members', ['name' => 'hannah', 'password' => 'a12345']);
        $this->call('POST', 'namespaces', ['memberId' => 3, 'name' => 'profollo']);

        $basicController->createUrl($expected[0]['inputUrl'], $expected[0]['inputMemberId'], $expected[0]['inputNamespaceId']);
        $basicController->createUrl($expected[1]['inputUrl'], $expected[1]['inputMemberId'], $expected[1]['inputNamespaceId']);
        $actual = $urlController->show(4);

        $this->assertSame($expected[1]['inputUrl'], $actual->originUrl);
    }

    /**
     * @testdox 當資料表已有會員為「hannah」，命名空間為「profollo」的「https://www.google.com.tw」時，刪除「https://www.google.com.tw」，應該會更新「deleted_at」時間
     *
     * @return void
     */
    public function test_should_show_status_code_when_id_in_table()
    {
        $urlController = new UrlController();
        $basicController = new \App\BasicController();

        $expected = [
            'inputMemberId'     => 4,
            'inputNamespaceId'  => 4,
            'inputUrl'          => 'https://www.google.com.tw'
        ];

        $this->call('POST', 'members', ['name' => 'hannah', 'password' => 'a12345']);
        $this->call('POST', 'namespaces', ['memberId' => 4, 'name' => 'profollo']);

        $basicController->createUrl($expected['inputUrl'], $expected['inputMemberId'], $expected['inputNamespaceId']);

        $actual = $urlController->destroy(5)->status();

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

    /**
     * @testdox 當會員資料表為空時，新增一筆「hannah」的帳號，應該只會有一筆「hannah」的會員資料
     *
     * @return void
     */
    public function test_should_show_one_data_when_add_member_into_empty_table()
    {
        $memberController = new MemberController();
        $basicController = new \App\BasicController();

        $expected = ['name' => 'hannah', 'password' => 'a12345'];

        $this->call('POST', 'members', $expected);
        $actual = $memberController->show(5, $basicController);

        $this->assertSame($expected['name'], $actual['name']);
    }

    /**
     * @testdox 當會員資料表已有一筆「hannah」時，新增一筆「Miles」的帳號，應該會有兩筆「hannah」及「Miles」的會員資料
     *
     * @return void
     */
    public function test_should_show_all_data_when_add_member_into_table()
    {
        $memberController = new MemberController();
        $basicController = new \App\BasicController();

        $expected = [
            ['name' => 'hannah', 'password' => 'a12345'],
            ['name' => 'Miles', 'password' => 'b12345']
        ];

        $this->call('POST', 'members', $expected[0]);
        $this->call('POST', 'members', $expected[1]);

        $actual = $memberController->show(7, $basicController);

        $this->assertSame($expected[1]['name'], $actual['name']);
    }

    /**
     * @testdox 當會員資料表已有命名為「hannah」的資料時，新增一筆「hannah」的資料，http status code 應該會顯示 500
     *
     * @return void
     */
    public function test_should_show_status_code_500_when_add_same_member_into_table()
    {

        $expected = [
            ['name' => 'hannah', 'password' => 'a12345'],
            ['name' => 'hannah', 'password' => 'b12345']
        ];

        $this->call('POST', 'members', $expected[0]);
        $actual = $this->call('POST', 'members', $expected[1]);

        $this->assertSame(500, $actual->status());
    }

    /**
     * @testdox 當會員資料表已有命名為「hannah」的資料時，刪除「hannah」的資料，應該會更新「deleted_at」時間
     *
     * @return void
     */
    public function test_should_show_status_code_200_when_id_in_member_table()
    {
        $memberController = new MemberController();
        $basicController = new \App\BasicController();

        $data = ['name' => 'hannah', 'password' => 'a12345'];
        $this->call('POST', 'members', $data);

        $actual = $memberController->destroy(10, $basicController);

        $this->assertSame(200, $actual->status());
    }

    /**
     * @testdox 刪除「不存在的會員編號」，應該會有「不存在的會員編號！」的錯誤訊息
     *
     * @return void
     */
    public function test_should_show_exception_when_id_not_exist_member_table()
    {
        $this->expectException(Exception::class);

        $memberController = new MemberController();
        $basicController = new \App\BasicController();

        $memberController->destroy(1, $basicController);
    }

    /**
     * @testdox 當命名空間資料表為空時，新增一筆會員名稱為「hannah」，命名空間名稱為「profollo」的資料，應該只會有一筆會員名稱為「hannah」，命名空間名稱為「profollo」的資料
     *
     * @return void
     */
    public function test_should_show_one_data_when_add_namespace_into_empty_table()
    {
        $memberData = ['name' => 'hannah', 'password' => 'a12345'];
        $this->call('POST', 'members', $memberData);

        $expected = ['memberId' => 11, 'name' => 'profollo'];
        $actual = $this->call('POST', 'namespaces', $expected);

        $this->assertSame($expected['name'], $actual['name']);

    }

    /**
     * @testdox 當命名空間資料表已有一筆會員名稱為「hannah」，命名空間名稱為「profollo」時，新增一筆會員名稱為「hannah」，命名空間名稱為「travel」的資料，應該要有兩筆會員名稱為「hannah」，命名空間名稱為「profollo」及會員名稱為「hannah」，命名空間名稱為「travel」的資料
     *
     * @return void
     */
    public function test_should_show_all_data_when_add_namespace_into_table()
    {
        $namespaceController = new NamespaceController();
        $basicController = new \App\BasicController();

        $memberData = ['name' => 'hannah', 'password' => 'a12345'];
        $this->call('POST', 'members', $memberData);

        $namespaceData = [
            ['memberId' => 12, 'name' => 'profollo'],
            ['memberId' => 12, 'name' => 'travel']
        ];

        $this->call('POST', 'namespaces', $namespaceData[0]);
        $this->call('POST', 'namespaces', $namespaceData[1]);

        $actual = $namespaceController->show(7, $basicController);

        $this->assertSame($namespaceData[1]['name'], $actual['name']);
    }

    /**
     * @testdox 當命名空間資料表已有一筆會員名稱為「hannah」，命名空間名稱為「profollo」時，新增一筆會員名稱為「hannah」，命名空間名稱為「profollo」的資料，應該會有「已重複命名！」的錯誤訊息
     *
     * @return void
     */
    public function test_should_show_exception_when_add_same_namespace_into_table()
    {
        $basicController = new \App\BasicController();

        $this->expectException(Exception::class);

        $memberData = ['name' => 'hannah', 'password' => 'a12345'];
        $this->call('POST', 'members', $memberData);

        $namespaceData = [
            ['memberId' => 13, 'name' => 'profollo'],
            ['memberId' => 13, 'name' => 'profollo']
        ];

        $this->call('POST', 'namespaces', $namespaceData[0]);

        $columnName = ['member_id', 'name'];

        $basicController->checkNamespaceOnly($columnName, $namespaceData[1]['memberId'], $namespaceData[1]['name']);

    }

    /**
     * @testdox 新增一筆會員編號為「不存在」，命名空間名稱為「travel」的資料，應該會有「不存在的會員編號！」的錯誤訊息
     *
     * @return void
     */
    public function test_should_show_exception_when_add_member_id_not_exist_namespace_table()
    {
        $basicController = new \App\BasicController();

        $this->expectException(Exception::class);

        $basicController->existsMember('id', 1);
    }

}
