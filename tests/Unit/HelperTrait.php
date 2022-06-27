<?php

namespace App\Tests\Unit;

trait HelperTrait{

    public function validatorHasErrors(object $item, int $expectedErrors = 0){
        self::bootKernel();
        $error = self::getContainer()->get('validator')->validate($item);
        $this->assertCount($expectedErrors, $error);
    }
}