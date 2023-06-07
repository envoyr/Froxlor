<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

namespace Froxlor\UI\Callbacks;

use Froxlor\Database\Database;
use Froxlor\UI\Panel\UI;

class Backup
{
	public static function backupStorageLink(array $attributes)
	{
		$sel_stmt = Database::prepare("SELECT `description` FROM `" . TABLE_PANEL_BACKUPSTORAGES . "` WHERE `id` = :id");
		$backupstorage = Database::pexecute_first($sel_stmt, ['id' => $attributes['data']]);
		if ((int)UI::getCurrentUser()['adminsession'] == 1 && UI::getCurrentUser()['change_serversettings']) {
			$linker = UI::getLinker();
			$result = '<a href="' . $linker->getLink([
					'section' => 'backups',
					'page' => 'storages',
					'searchfield' => 'id',
					'searchtext' => $attributes['data'],
				]) . '">' . $backupstorage['description'] . '</a>';
		} else {
			$result = $backupstorage['description'];
		}
		return $result;
	}
}
