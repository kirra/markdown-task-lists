<?php

namespace Kirra\Markdown\Tests;

use cebe\markdown\block\ListTrait;
use cebe\markdown\Markdown;
use cebe\markdown\Parser;
use Kirra\Markdown\TaskListsTrait;

/**
 * Test class for {@see TaskListTrait}.
 * @since 1.0.0
 */
class TaskListsTraitTest extends TestCase {
	/**
	 * Data provider for {@see self::testParse}.
	 * @since 1.0.0
	 * @return mixed[] The provided test data.
	 */
	public function dataProviderForTestParse(): array {
		return [
			'Open checkbox' => ['- [ ] Open', "<ul>\n<li><input type=\"checkbox\" disabled=\"\"> Open</li>\n</ul>\n"],
			'Closed checkbox' => [
				'- [x] Closed',
				"<ul>\n<li><input type=\"checkbox\" disabled=\"\" checked=\"\"> Closed</li>\n</ul>\n",
			],
			'Closed checkbox Captial X' => [
				'- [X] Closed',
				"<ul>\n<li><input type=\"checkbox\" disabled=\"\" checked=\"\"> Closed</li>\n</ul>\n",
			],
			'Invalid checkbox' => ['- [*] Closed', "<ul>\n<li>[*] Closed</li>\n</ul>\n"],
			'with markup' => [
				'- [ ] **Open**',
				"<ul>\n<li><input type=\"checkbox\" disabled=\"\"> <strong>Open</strong></li>\n</ul>\n",
			],
			'with link' => [
				'- [ ] [Open](link)',
				"<ul>\n<li><input type=\"checkbox\" disabled=\"\"> <a href=\"link\">Open</a></li>\n</ul>\n",
			],
			'without a list' => ['[ ] Open', "<p>[ ] Open</p>\n"],
		];
	}

	/**
	 * Test case for parsing checkboxes.
	 * @since 1.0.0
	 * @param string $markdown The markdown to parse.
	 * @param string $result The expected result.
	 * @dataProvider dataProviderForTestParse The data provider.
	 */
	public function testParse(string $markdown, string $result): void {
		$this->assertEquals($result, (new TestParser())->parse($markdown));
	}

	/**
	 * Test case to make sure inline parsing returns the same code.
	 * @since 1.0.0
	 */
	public function testParseParagraph(): void {
		$this->assertEquals('- [ ] Open', (new TestParser())->parseParagraph('- [ ] Open'));
	}

	/**
	 * Test case to make sure a link isn't parsed without the {@see LinkTrait}.
	 * @since 1.0.0
	 */
	public function testLinkless(): void {
		$this->assertEquals(
			"<ul>\n<li>[Open](link)</li>\n</ul>\n",
			(new LinklessParser())->parse('- [Open](link)')
		);
		// Make sure a checkbox IS still parsed.
		$this->assertEquals('- [ ] Open', (new LinklessParser())->parseParagraph('- [ ] Open'));
	}
}

/**
 * Dummy class to test Parser.
 * @since 1.0.0
 */
class TestParser extends Markdown {
	use TaskListsTrait;
}

/**
 * Linkless dummy class to test Parser.
 * @since 1.0.0
 */
class LinklessParser extends Parser {
	use TaskListsTrait, ListTrait;
}
