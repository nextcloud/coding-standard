<?php

declare(strict_types=1);

namespace ChristophWurst\Nextcloud\CodingStandard;

use PhpCsFixer\Config as Base;

class Config extends Base
{

	public function getRules()
	{
		return [
			'array_syntax' => [
				'syntax' => 'short',
			],
			'no_unused_imports' => true,
		];
	}

}
