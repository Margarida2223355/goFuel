<?php

namespace frontend\tests\unit;

use common\models\Category;
use common\models\Subcategory;

class CategorySubcategoryTest extends \Codeception\Test\Unit
{
    public function _fixtures()
    {
        return [
            'categories' => [
                'class' => \common\fixtures\CategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'cat.php',
            ],
            'subcategories' => [
                'class' => \common\fixtures\SubcategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'subcat.php',
            ],
        ];
    }
    
    public function testCreate()
    {
        $category = new Category();
        $category->name = 'Test Category';
        $category->is_deleted = 0;
        $this->assertTrue($category->save(), 'Category should be saved successfully');

        $this->assertNotNull($category->id, 'Category ID should be set after save');

        $subcategory = new Subcategory();
        $subcategory->description = 'Test Subcategory';
        $subcategory->category_id = $category->id;
        $subcategory->is_deleted = 0;
        $this->assertTrue($subcategory->save(), 'Subcategory should be saved successfully');

        $this->assertNotNull($subcategory->id, 'Subcategory ID should be set after save');
        $this->assertEquals($category->id, $subcategory->category_id, 'Subcategory should be linked to the correct category');
    }

    public function testRead()
    {
        $category = Category::findOne(['name' => 'Test Category']);
        $this->assertNotNull($category, 'Category should exist in the database');

        $subcategory = Subcategory::findOne(['description' => 'Test Subcategory']);
        $this->assertNotNull($subcategory, 'Subcategory should exist in the database');

        $relatedSubcategories = $category->subcategories;
        $this->assertCount(1, $relatedSubcategories, 'Category should have one subcategory');
        $this->assertEquals($subcategory->id, $relatedSubcategories[0]->id, 'Related subcategory should match');
    }

    public function testUpdate()
    {
        $category = Category::findOne(['name' => 'Test Category']);
        $this->assertNotNull($category, 'Category should exist in the database');
        $category->name = 'Updated Category';
        $this->assertTrue($category->save(), 'Category should be updated successfully');

        $subcategory = Subcategory::findOne(['description' => 'Test Subcategory']);
        $this->assertNotNull($subcategory, 'Subcategory should exist in the database');
        $subcategory->description = 'Updated Subcategory';
        $this->assertTrue($subcategory->save(), 'Subcategory should be updated successfully');
    }

    public function testDelete()
    {
        $subcategory = Subcategory::findOne(['description' => 'Test Subcategory']);
        $this->assertNotNull($subcategory, 'Subcategory should exist in the database');
        $this->assertEquals(1, $subcategory->delete(), 'Subcategory should be deleted successfully');

        $category = Category::findOne(['name' => 'Test Category']);
        $this->assertNotNull($category, 'Category should exist in the database');
        $this->assertEquals(1, $category->delete(), 'Category should be deleted successfully');
    }
}
