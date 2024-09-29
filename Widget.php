<?php
/*
** Copyright (C) 2001-2024 initMAX s.r.o.
**
** This program is free software: you can redistribute it and/or modify it under the terms of
** the GNU Affero General Public License as published by the Free Software Foundation, version 3.
**
** This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
** without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
** See the GNU Affero General Public License for more details.
**
** You should have received a copy of the GNU Affero General Public License along with this program.
** If not, see <https://www.gnu.org/licenses/>.
**/


namespace Modules\MineMAX;

use Zabbix\Core\CWidget;

class Widget extends CWidget 
{
	public const DEFAULT_ROWS = 15;
	public const DEFAULT_COLUMNS = 15;

	public const DIFFICULTY_BEGINNER = 1;
	public const DIFFICULTY_INTERMEDIATE = 2;
	public const DIFFICULTY_EXPERT = 3;

    public function getDefaultName(): string {
		return _('mineMAX');
	}
}
