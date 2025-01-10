<?php


namespace frontend\tests\Unit;

use common\models\Tarefa;
use frontend\tests\UnitTester;

class TarefaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    public function _fixtures()
    {
        return [
            'user' => [
                'class' => \common\fixtures\UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
            'userInfo' => [
                'class' => \common\fixtures\UserInfoFixture::class,
                'dataFile' => codecept_data_dir() . 'userinfo.php',
            ],
        ];
    }

    protected function _before() {}

    // tests
    public function testValidations()
    {
        $tarefa = new Tarefa();

        $tarefa->description = null;
        $tarefa->user_id = null;
        $tarefa->is_done = null;

        $this->assertFalse($tarefa->validate(['description']));
        $this->assertFalse($tarefa->validate(['user_id']));
        $this->assertFalse($tarefa->validate(['is_done']));

        $tarefa->description = "nullnullnullnullnullnull";
        $tarefa->user_id = 9;
        $tarefa->is_done = null;

        $this->assertFalse($tarefa->validate(['description']));
        $this->assertFalse($tarefa->validate(['user_id']));
        $this->assertFalse($tarefa->validate(['is_done']));

        $tarefa->description = "Arruma o quarto";
        $tarefa->user_id = 5;
        $tarefa->is_done = 0;

        $this->assertTrue($tarefa->validate(['description']));
        $this->assertTrue($tarefa->validate(['user_id']));
        $this->assertTrue($tarefa->validate(['is_done']));
    }

    public function testCreate()
    {
        $tarefa = new Tarefa();

        $tarefa->description = 'Arruma o quarto';
        $tarefa->user_id = 5;
        $tarefa->is_done = 0;

        $this->assertTrue($tarefa->validate(['description']));
        $this->assertTrue($tarefa->validate(['user_id']));
        $this->assertTrue($tarefa->validate(['is_done']));
        $tarefa->save();

        $taskTromDatabase = Tarefa::find()->where(['description' => 'Arruma o quarto'])->one();
        $this->assertNotNull($taskTromDatabase);
    }

    public function testUpdate()
    {
        $this->createTask();
        $task = Tarefa::find()->where(['description' => 'Arruma o quarto'])->one();
        $newDescription = 'User new name';

        $task->description = $newDescription;
        $task->save();

        $taskTromDatabase = Tarefa::find()->where(['description' => $newDescription])->one();
        $this->assertNotNull($taskTromDatabase);
        $this->assertEquals($newDescription, $taskTromDatabase->description);
    }

    public function testDelete()
    {
        $this->createTask();
        $task = Tarefa::find()->where(['description' => 'Arruma o quarto'])->one();

        $task->delete();

        $taskTromDatabase = Tarefa::find()->where(['description' => 'Arruma o quarto'])->one();
        $this->assertNull($taskTromDatabase);
    }

    protected function createTask()
    {
        $tarefa = new Tarefa();

        $tarefa->description = 'Arruma o quarto';
        $tarefa->user_id = 5;
        $tarefa->is_done = 0;

        $this->assertTrue($tarefa->validate(['description']));
        $this->assertTrue($tarefa->validate(['user_id']));
        $this->assertTrue($tarefa->validate(['is_done']));
        $tarefa->save();

        $taskTromDatabase = Tarefa::find()->where(['description' => 'Arruma o quarto'])->one();
        $this->assertNotNull($taskTromDatabase);
    }
}
