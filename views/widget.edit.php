<?php declare(strict_types = 0);
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


/**
 * mineMAX widget form view.
 *
 * @var CView $this
 * @var array $data
 */

(new CWidgetFormView($data))
    ->addField(
        new CWidgetFieldTextBoxView($data['fields']['player_name'])
    )
    ->addField(
        new CWidgetFieldSelectView($data['fields']['difficulty'])
    )
    ->addField(
        new CWidgetFieldIntegerBoxView($data['fields']['rows'])
    )
    ->addField(
        new CWidgetFieldIntegerBoxView($data['fields']['columns'])
    )

    ->includeJsFile('widget.edit.js.php')
    ->addJavaScript('widget_minemax_form.init();')
	->show();
