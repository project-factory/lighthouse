<?php

namespace Tests\Unit\Schema\Types\Scalars;

use Tests\TestCase;
use GraphQL\Error\Error;
use Illuminate\Http\UploadedFile;
use GraphQL\Error\InvariantViolation;
use Nuwave\Lighthouse\Schema\Types\Scalars\Upload;

class UploadTest extends TestCase
{
    /**
     * @test
     */
    public function itThrowsIfSerializing(): void
    {
        $this->expectException(InvariantViolation::class);

        (new Upload)->serialize('');
    }

    /**
     * @test
     */
    public function itThrowsIfParsingLiteral(): void
    {
        $this->expectException(Error::class);

        (new Upload)->parseLiteral('');
    }

    /**
     * @test
     */
    public function itThrowsIfParsingValueNotFile(): void
    {
        $this->expectException(Error::class);

        (new Upload)->parseValue('not a file');
    }

    /**
     * @test
     */
    public function itParsesValidFiles(): void
    {
        $value = UploadedFile::fake()
            ->create('my-file.jpg', 500);
        $parsedValue = (new Upload)->parseValue($value);

        $this->assertEquals($value, $parsedValue);
    }
}
