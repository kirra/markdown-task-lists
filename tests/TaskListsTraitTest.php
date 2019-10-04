<?php

namespace Kirra\Markdown\Tests;

use cebe\markdown\block\ListTrait;
use cebe\markdown\Markdown;
use cebe\markdown\Parser;
use Kirra\Markdown\TaskListsTrait;
use PHPUnit\Framework\TestCase;

class TaskListsTraitTest extends TestCase {
	/**
	 * Data provider for {@see self::testParse}.
	 * @since $ver$
	 * @return array
	 */
	public function dataProviderForTestParse() {
		return [
			'Open checkbox' => ['- [ ] Open', "<ul>\n<li><input type=\"checkbox\" disabled> Open</li>\n</ul>\n"],
			'Closed checkbox' => [
				'- [x] Closed',
				"<ul>\n<li><input type=\"checkbox\" disabled checked> Closed</li>\n</ul>\n"
			],
			'Closed checkbox Captial X' => [
				'- [X] Closed',
				"<ul>\n<li><input type=\"checkbox\" disabled checked> Closed</li>\n</ul>\n"
			],
			'Invalid checkbox' => ['- [*] Closed', "<ul>\n<li>[*] Closed</li>\n</ul>\n"],
			'with markup' => [
				'- [ ] **Open**',
				"<ul>\n<li><input type=\"checkbox\" disabled> <strong>Open</strong></li>\n</ul>\n"
			],
			'with link' => [
				'- [ ] [Open](link)',
				"<ul>\n<li><input type=\"checkbox\" disabled> <a href=\"link\">Open</a></li>\n</ul>\n"
			],
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
		$this->assertEquals($result, (new TestParser())->parse($markdown));
	}

	/**
	 * Test case to make sure inline parseing returns the same code.
	 * @since $ver$
	 */
	public function testParseParagraph() {
		$this->assertEquals('- [ ] Open', (new TestParser())->parseParagraph('- [ ] Open'));
	}

	/**
	 * Test case to make sure a link isn't parsed without the {@see ListTrait}.
	 * @since $ver$
	 */
	public function testLinkless() {
		$this->assertEquals(
			"<ul>\n<li>[Open](link)</li>\n</ul>\n",
			(new LinklessParser())->parse('- [Open](link)')
		);
	}
}

/**
 * Dummy class to test Parser.
 * @since $ver$
 */
class TestParser extends Markdown {
	use TaskListsTrait;
}

/**
 * Linkless dummy class to test Parser.
 * @since $ver$
 */
class LinklessParser extends Parser {
	use TaskListsTrait, ListTrait;
}

