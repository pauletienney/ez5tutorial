<?php
/**
 * File contains: eZ\Publish\Core\Persistence\Legacy\Tests\Content\SearchHandler\TransformationProcessorPreprocessedBasedTest class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\Persistence\Legacy\Tests\Content\SearchHandler;

use eZ\Publish\Core\Persistence\Legacy\Tests\TestCase;
use eZ\Publish\Core\Persistence\Legacy\Content\Search;
use eZ\Publish\Core\Persistence\Legacy\Content\Search\TransformationProcessor\PreprocessedBased;

/**
 * Test case for LocationHandlerTest
 */
class TransformationProcessorPreprocessedBasedTest extends TestCase
{
    public function getProcessor()
    {
        $installDir = self::getInstallationDir();
        $rules = array();
        foreach ( glob( __DIR__ . '/_fixtures/transformations/*.tr.result' ) as $file )
        {
            $rules[] = str_replace( $installDir, '', $file );
        }

        return new PreprocessedBased(
            new Search\TransformationProcessor\PcreCompiler( new Search\Utf8Converter() ),
            $installDir,
            $rules
        );
    }

    public function testSimpleNormalizationLowercase()
    {
        $processor = $this->getProcessor();

        $this->assertSame(
            'hello world!',
            $processor->transform( 'Hello World!', array( 'ascii_lowercase' ) )
        );
    }

    public function testSimpleNormalizationUppercase()
    {
        $processor = $this->getProcessor();

        $this->assertSame(
            'HELLO WORLD!',
            $processor->transform( 'Hello World!', array( 'ascii_uppercase' ) )
        );
    }

    /**
     * The main point of this test is, that it shows that all normalizations
     * available can be compiled without errors. The actual expectation is not
     * important.
     */
    public function testAllNormalizations()
    {
        $processor = $this->getProcessor();

        $this->assertSame(
            'HELLO WORLD.',
            $processor->transform( 'Hello World!' )
        );
    }
}

