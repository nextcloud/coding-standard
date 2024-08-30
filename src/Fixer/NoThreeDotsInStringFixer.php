<?php

declare(strict_types=1);

namespace Nextcloud\CodingStandard\Fixer;

use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;

final class NoThreeDotsInStringFixer implements FixerInterface {

	public function isCandidate(Tokens $tokens): bool {
		return $tokens->isAnyTokenKindsFound([T_CONSTANT_ENCAPSED_STRING, T_ENCAPSED_AND_WHITESPACE]);
	}

	public function isRisky(): bool {
		return true;
	}

	public function getName(): string {
		return 'Nextcloud/no_three_dots_in_string';
	}

	public function getPriority(): int {
		return 0;
	}

	public function supports(\SplFileInfo $file): bool {
		return true;
	}

	public function getDefinition(): FixerDefinitionInterface {
		return new FixerDefinition(
			'There must be no three dots in strings, instead ellipsis shall be used.',
			[
				new CodeSample(
					"<?php \$a = 'Loading ...';\n"
				),
			],
			null,
			'Changing the characters in strings might affect string comparisons and outputs.'
		);
	}

	public function fix(\SplFileInfo $file, Tokens $tokens): void {
		for ($index = $tokens->count() - 1; $index >= 0; --$index) {
			/** @var Token $token */
			$token = $tokens[$index];

			if (!$token->isGivenKind([T_CONSTANT_ENCAPSED_STRING, T_ENCAPSED_AND_WHITESPACE])) {
				continue;
			}

			$content = str_replace('...', '…', $token->getContent());
			if ($token->getContent() === $content) {
				continue;
			}

			$tokens[$index] = new Token([$tokens[$index]->getId(), $content]);
		}
	}
}
