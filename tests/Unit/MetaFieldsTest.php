<?php


namespace Tests\Unit;


use App\Helpers\MetaFields;
use Tests\TestCase;

class MetaFieldsTest extends TestCase {

    public function testToGuessSimilarFieldNames()
    {
        $fields = ["Concept or white-paper" => 55,
            "early-stage" => 21,
            "pilot" => 17,
            "unkown" => 297,
            "Pilot completed" => 31,
            "live" => 11,
            "Aborted or ended" => 23,
            " Live or in Production" => 38,
            "Proof of Concept or demo" => 22,
            " Proof of Concept or demo" => 2,
            "Inactive" => 11,
            "Production aborted or ended" => 1,
            " Pilot completed" => 2,
            " Live" => 4,
            "inactive" => 3];

        $actualOutput = [
            "concept or white-paper" => 55,
            "early-stage" => 21,
            "pilot" => 17,
            "unkown" => 297,
            "aborted or ended" => 23,
            "live or in production" => 38,
            "proof of concept or demo" => 24,
            "inactive" => 3,
            "production aborted or ended" => 1,
            "pilot completed" => 33,
            "live" => 15];

        $cleanFields = (MetaFields::guessSameFieldsAndMergeValues($fields));
        $this->assertArrayNotHasKey(" Live or in Production", $cleanFields);
        $this->assertArrayNotHasKey(" Pilot completed", $cleanFields);
        $this->assertArrayNotHasKey(" Live", $cleanFields);
        $this->assertIsArray($actualOutput, $cleanFields);
    }

}
