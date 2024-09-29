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


/**
 * mineMAX widget view.
 *
 * @var CView $this
 * @var array $data
 */

for ($i = 0; $i < $data['fields_values']['rows']; $i++) {
    for ($j = 0; $j < $data['fields_values']['columns']; $j++) {
        $cell = (new CDiv())
            ->setAttribute('data-row', $i)
            ->setAttribute('data-column', $j)
        ;
        
        $area[] = $cell;
    }
}

(new CWidgetView($data))
    ->addItem(
        (new CDiv([
            (new CDiv([
            ]))
                ->addClass('minemax__header__left')
            ,
            (new CDiv([
                (new CImg($this->getAssetsPath() . '/img/initmax.svg', 'Logo of initMAX s.r.o.'))
                ,    
            ]))
                ->addClass('minemax__header__center')
            ,
            (new CDiv([
                    (new CSpan(''))
                        ->addClass('minemax__reset')
                    ,
                ]))
                    ->addClass('minemax__header__right')
                ,
            (new CDiv([]))
                    ->addClass('minemax__message')
                ,
            (new CDiv($area))
                ->addClass('minemax__area')
            ,
        ]))
            ->setId('minemax')
            ->addStyle('--minemax-area-columns: ' . $data['fields_values']['columns'] . ';')
            ->addStyle('--minemax-area-rows: ' . $data['fields_values']['rows'] . ';')
        ,
    )
->show();
