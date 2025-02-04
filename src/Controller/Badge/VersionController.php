<?php

/*
 * This file is part of the badge-poser package.
 *
 * (c) PUGX <http://pugx.github.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Badge;

use App\Badge\Model\UseCase\CreateVersionBadge;
use App\Badge\Service\ImageFactory;
use PUGX\Poser\Badge;
use PUGX\Poser\Poser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Version action for badges.
 */
final class VersionController extends AbstractBadgeController
{
    /**
     * @throws \InvalidArgumentException
     */
    public function version(
        Request $request,
        Poser $poser,
        ImageFactory $imageFactory,
        CreateVersionBadge $createVersionBadge,
        string $repository,
        string $latest,
        string $format = 'svg',
        string $style = 'flat',
    ): Response {
        if (!\in_array($request->query->get('style'), $poser->validStyles(), true)) {
            $style = Badge::DEFAULT_STYLE;
        }

        var_dump($style);
        die;

        $function = 'create'.\ucfirst($latest).'Badge';

        return $this->serveBadge(
            $imageFactory,
            $createVersionBadge->{$function}($repository, $format, $style)
        );
    }
}
