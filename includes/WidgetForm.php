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


namespace Modules\MineMAX\Includes;

use Modules\MineMAX\Widget;
use Zabbix\Widgets\CWidgetField;
use Zabbix\Widgets\CWidgetForm;
use Zabbix\Widgets\Fields\CWidgetFieldIntegerBox;
use Zabbix\Widgets\Fields\CWidgetFieldSelect;
use Zabbix\Widgets\Fields\CWidgetFieldTextBox;

/**
 * mineMAX widget form.
 */

class WidgetForm extends CWidgetForm
{
    public function addFields(): self {
        return $this
            ->addField(
                (new CWidgetFieldIntegerBox('rows', _('Rows')))
                    ->setDefault(Widget::DEFAULT_ROWS)
                    ->setFlags(CWidgetField::FLAG_LABEL_ASTERISK)
            )
            ->addField(
                (new CWidgetFieldIntegerBox('columns', _('Columns')))
                    ->setDefault(Widget::DEFAULT_COLUMNS)
                    ->setFlags(CWidgetField::FLAG_LABEL_ASTERISK)
            )
            ->addField(
                (new CWidgetFieldSelect('difficulty', _('Difficulty'), [
                    Widget::DIFFICULTY_BEGINNER => _('Beginner'),
                    Widget::DIFFICULTY_INTERMEDIATE => _('Intermediate'),
                    Widget::DIFFICULTY_EXPERT => _('Expert'),
                ]))
                    ->setDefault(Widget::DIFFICULTY_BEGINNER)
                    ->setFlags(CWidgetField::FLAG_LABEL_ASTERISK)
            )
            ->addField(
                (new CWidgetFieldTextBox('player_name', _('Player name')))
                    ->setDefault(0)
                    ->setFlags(CWidgetField::FLAG_LABEL_ASTERISK)
            )
        ;
    }
}
