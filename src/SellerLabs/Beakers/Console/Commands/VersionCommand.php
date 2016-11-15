<?php

/**
 * Copyright 2016, SellerLabs <sellerlabs-devs@sellerlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Promote package
 */

namespace SellerLabs\Beakers\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use SellerLabs\Beakers\Enums\VersionBumpType;

/**
 * Class VersionCommand.
 *
 * Show/Bump the application version (major, minor, or patch)
 *
 * @author Benjamin Kovach <benjamin@roundsphere.com>
 * @author Mark Vaughn <mark@sellerlabs.com>
 * @package SellerLabs\Snagshout\Console\Commands
 */
class VersionCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'version {--file=VERSION.md} {--bump=}';

    /**
     * @var string
     */
    protected $description = 'Updates the version of the project';

    /**
     * Handle the command.
     */
    public function handle()
    {
        $versionFile = $this->option('file');
        $version = trim(file_get_contents(base_path($versionFile)));

        $this->line(
            'Application version: <comment>v' . $version . '</comment>'
        );
        $this->line(
            'Laravel Framework version: <comment>v' . Application::VERSION . '</comment>'
        );

        $bumpType = $this->option('bump');

        if (!VersionBumpType::isValueValid($bumpType)) {
            return;
        }

        $split = explode('.', $version);

        $newVersion = $this->bump($bumpType, $split);

        $continue = $this->ask(
            'Is the new version: v' . $newVersion . ' OK? [y/n]',
            'y'
        );

        if ($continue !== 'n') {
            file_put_contents($versionFile, $newVersion);

            $this->line('<info>Version bump successful!</info>');
            $this->line(
                'New version is: <comment>v' . $newVersion . '</comment>'
            );
        } else {
            $this->error(
                'User aborted workflow. Version remains unchanged.'
            );
        }
    }

    /**
     * Bump version number based on type.
     *
     * @param $bumpType
     * @param array $version
     *
     * @return string
     */
    protected function bump($bumpType, array $version)
    {
        if (count($version) !== 3) {
            $this->error(
                'Version number is not semantic. Cannot bump version.'
            );
        }

        switch ($bumpType) {
            case VersionBumpType::MAJOR:
                $version[0] = $this->inc($version[0]);
                $version[1] = 0;
                $version[2] = 0;
                break;
            case VersionBumpType::MINOR:
                $version[1] = $this->inc($version[1]);
                $version[2] = 0;
                break;
            default:
                $version[2] = $this->inc($version[2]);
        }

        return $newVersion = implode('.', $version);
    }

    /**
     * Increments anything that can be cast to an integer.
     *
     * @param $n
     *
     * @return int
     */
    protected function inc($n)
    {
        return ((int) $n) + 1;
    }
}
