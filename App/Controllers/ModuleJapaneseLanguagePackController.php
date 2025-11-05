<?php
/*
 * MikoPBX - free phone system for small business
 * Copyright © 2017-2025 Alexey Portnov and Nikolay Beketov
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program.
 * If not, see <https://www.gnu.org/licenses/>.
 */

namespace Modules\ModuleJapaneseLanguagePack\App\Controllers;

use MikoPBX\AdminCabinet\Controllers\BaseController;
use MikoPBX\Modules\PbxExtensionUtils;

/**
 * ModuleJapaneseLanguagePackController
 *
 * Controller for Japanese Language Pack module information page
 */
class ModuleJapaneseLanguagePackController extends BaseController
{
    private string $moduleUniqueID = 'ModuleJapaneseLanguagePack';
    private string $moduleDir;

    /**
     * Basic initialization
     */
    public function initialize(): void
    {
        $this->moduleDir = PbxExtensionUtils::getModuleDir($this->moduleUniqueID);
        parent::initialize();
    }

    /**
     * Renders the information page for the module
     *
     * This page displays information about the Language Pack:
     * - What it does
     * - What files it provides
     * - How to use it
     *
     * @return void
     */
    public function indexAction(): void
    {
        // Get module info
        $this->view->moduleUniqueID = $this->moduleUniqueID;
        $this->view->moduleDir = $this->moduleDir;

        // Count sound files
        $soundsDir = $this->moduleDir . '/Sounds/ja-jp';
        $soundFileCount = 0;
        if (is_dir($soundsDir)) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($soundsDir, \RecursiveDirectoryIterator::SKIP_DOTS)
            );
            foreach ($files as $file) {
                if ($file->isFile()) {
                    $soundFileCount++;
                }
            }
        }
        $this->view->soundFileCount = $soundFileCount;

        // Count translation files
        $messagesDir = $this->moduleDir . '/Messages/ja';
        $translationFileCount = 0;
        if (is_dir($messagesDir)) {
            $files = scandir($messagesDir);
            $translationFileCount = count(array_filter($files, function($file) use ($messagesDir) {
                return is_file($messagesDir . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'php';
            }));
        }
        $this->view->translationFileCount = $translationFileCount;

        // Set view path (Modules/ModuleJapaneseLanguagePack/ModuleJapaneseLanguagePack/index)
        $this->view->pick('Modules/' . $this->moduleUniqueID . '/' . $this->moduleUniqueID . '/index');
    }
}
