<?php

class Zenith_Eccube_PageStorageTest extends PHPUnit_Framework_TestCase
{
    protected $secret_key;

    public function setUp()
    {
        $this->secretKey = 'naishodayo';
    }

    public function testConstructor()
    {
        $init = array(
            'foo' => 'FOO',
            'bar' => 'BAR',
        );
        $context = new Zenith_Eccube_PageStorage($init, $this->secretKey);
        $this->assertEquals($init, $context->getArrayCopy());

        $secret_key = str_rot13($this->secretKey);
        $context = new Zenith_Eccube_PageStorage($init, $secret_key);
        $this->assertEquals('YToyOntzOjM6ImZvbyI7czozOiJGT08iO3M6MzoiYmFyIjtzOjM6IkJBUiI7fQ==--ZTRhYjhiNDYyMThiNWNhMzA2OTQzMWI3YzM5Nzg2YjVjYmQxMWUyYw==', $context->__toString());
    }

    public function testArrayAccess()
    {
        $context = new Zenith_Eccube_PageStorage(array(), $this->secretKey);

        $context['foo'] = 'FOO';
        $this->assertEquals('FOO', $context['foo']);

        $context['bar'] = 'BAR';
        $this->assertEquals('BAR', $context['bar']);
    }

    public function testToString()
    {
        $context = new Zenith_Eccube_PageStorage(array(), $this->secretKey);
        $this->assertEquals('YTowOnt9--YTJiMTJjNzlhNGI2YmM5MDlkYTA0YmY0MjFjZjkxOWVkZGZmY2FlZA==', (string)$context);
    }

    public function testEncode()
    {
        $context = new Zenith_Eccube_PageStorage(array(), $this->secretKey);

        $context['foo'] = 'FOO';
        $this->assertEquals('YToxOntzOjM6ImZvbyI7czozOiJGT08iO30=--MmI4YTIwODk5OGViMTJmNzFhOTBiZTMxMDRkZjIzMDQxOGIyNjEyMw==', $context->encode());

        $context['bar'] = 'BAR';
        $this->assertEquals('YToyOntzOjM6ImZvbyI7czozOiJGT08iO3M6MzoiYmFyIjtzOjM6IkJBUiI7fQ==--NDBjMTNlOWQyNTJhYzY0N2MyZGJkYjcxYzRhY2ZhYjUxNzU1YTk4OA==', $context->encode());
    }

    public function testDecode()
    {
        $context = new Zenith_Eccube_PageStorage(array(), $this->secretKey);
        $expected = array(
            'foo' => 'FOO',
        );
        $actual = $context->decode('YToxOntzOjM6ImZvbyI7czozOiJGT08iO30=--MmI4YTIwODk5OGViMTJmNzFhOTBiZTMxMDRkZjIzMDQxOGIyNjEyMw==');
        $this->assertEquals($expected, $actual);

        $context = new Zenith_Eccube_PageStorage(array(), $this->secretKey);
        $expected = array(
            'foo' => 'FOO',
            'bar' => 'BAR',
        );
        $actual = $context->decode('YToyOntzOjM6ImZvbyI7czozOiJGT08iO3M6MzoiYmFyIjtzOjM6IkJBUiI7fQ==--NDBjMTNlOWQyNTJhYzY0N2MyZGJkYjcxYzRhY2ZhYjUxNzU1YTk4OA==');
        $this->assertEquals($expected, $actual);
    }

    public function testRestore()
    {
        $context = new Zenith_Eccube_PageStorage(array(), $this->secretKey);
        $context->restore('YToxOntzOjM6ImZvbyI7czozOiJGT08iO30=--MmI4YTIwODk5OGViMTJmNzFhOTBiZTMxMDRkZjIzMDQxOGIyNjEyMw==');
        $expected = array(
            'foo' => 'FOO',
        );
        $this->assertEquals($expected, $context->getArrayCopy());

        $context = new Zenith_Eccube_PageStorage(array(), $this->secretKey);
        $context->restore('YToyOntzOjM6ImZvbyI7czozOiJGT08iO3M6MzoiYmFyIjtzOjM6IkJBUiI7fQ==--NDBjMTNlOWQyNTJhYzY0N2MyZGJkYjcxYzRhY2ZhYjUxNzU1YTk4OA==');
        $expected = array(
            'foo' => 'FOO',
            'bar' => 'BAR',
        );
        $this->assertEquals($expected, $context->getArrayCopy());
    }
}
