<?php

namespace Kirra\Markdown\Tests;

use cebe\markdown\Markdown;
use Kirra\Markdown\TaskListsTrait;
use PHPUnit\Framework\TestCase;

class TaskListsTraitTest extends TestCase {
	/**
	 * A parser using the trait.
	 * @since $ver$
	 * @var TestParser
	 */
	private $parser;

	/**
	 * {@inheritDoc}
	 */
	protected function setUp() {
		parent::setUp();
		$this->parser = new TestParser();
	}

	/**
	 * Data provider for {@see self::testParse}.
	 * @since $ver$
	 * @return array
	 */
	public function dataProviderForTestParse() {
		return [
			'Open checkbox' => ['- [ ] Open', "<ul>\n<li><input type=\"checkbox\"> Open</li>\n</ul>\n"],
			'Closed checkbox' => ['- [x] Closed', "<ul>\n<li><input type=\"checkbox\" checked> Closed</li>\n</ul>\n"],
			'Closed checkbox Captial X' => ['- [X] Closed', "<ul>\n<li><input type=\"checkbox\" checked> Closed</li>\n</ul>\n"],
			'Invalid checkbox' => ['- [*] Closed', "<ul>\n<li>[*] Closed</li>\n</ul>\n"],
			'with markup' => ['- [ ] **Open**', "<ul>\n<li><input type=\"checkbox\"> <strong>Open</strong></li>\n</ul>\n"],
			'with link' => ['- [ ] [Open](link)', "<ul>\n<li><input type=\"checkbox\"> <a href=\"link\">Open</a></li>\n</ul>\n"],
			'without a list' => ['[ ] Open', "<p>[ ] Open</p>\n"],
		];
	}

	/**
	 * Test case for parsing checkboxes.
	 * @since $ver$
	 * @param string $markdown
	 * @param string $result
	 * @dataProvider dataProviderForTestParse
	 */
	public function testParse($markdown, $result) {
		$this->assertEquals($result, $this->parser->parse($markdown));
	}

	/**
	 * Test case to make sure inline parseing returns the same code.
	 * @since $ver$
	 */
	public function testParseParagraph() {
		$this->assertEquals('- [ ] Open', $this->parser->parseParagraph('- [ ] Open'));
	}
}

/**
 * Dummy class to test Parser.
 * @since $ver$
 */
class TestParser extends Markdown {
	use TaskListsTrait;
}
