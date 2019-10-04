<?php

namespace Kirra\Markdown;

/**
 * Adds Github's Task Lists support to a parser.
 * @link https://github.blog/2013-01-09-task-lists-in-gfm-issues-pulls-comments
 * @since $ver$
 */
trait TaskListsTrait {
	/**
	 * {@inheritDoc}
	 *
	 * This parses a checkbox first. This is because the marker phpdoc only takes one function.
	 * Make sure to use this trait later then {@see LinkTrait}.
	 *
	 * @since $ver$
	 * @marker [
	 * @return mixed[] The block configuration.
	 */
	protected function parseLink($markdown): array {
		$checkbox = substr($markdown, 0, 4);
		if (!in_array($checkbox, ['[ ] ', '[x] ', '[X] '])) {
			if (\is_callable(['parent', __FUNCTION__])) {
				return parent::parseLink($markdown);
			}

			// keep the tag, as it should not be parsed.
			return [['text', '['], 1];
		}

		return [['checkbox', 'checked' => (stristr($checkbox, 'x') !== false), 'original' => $checkbox], 4];
	}

	/**
	 * Renders a checkbox, but only in a list block.
	 * @since $ver$
	 * @param array $block The block configuration for the checkbox.
	 * @return string The checkbox html.
	 */
	protected function renderCheckbox(array $block): string {
		if (!in_array('list', $this->context)) {
			return (string) $block['original'];
		}

		return sprintf(
			'<input type="checkbox" disabled%s%s> ',
			$block['checked'] ? ' checked' : '',
			$this->html5 ? ' /' : ''
		);
	}
}
