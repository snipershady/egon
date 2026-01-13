<?php

/*
 * Copyright (C) 2022 Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Egon\Dto\ResponseValidationV4;

final class ValidationV4Mapper
{
    public static function fromArray(array $data): ValidationV4Response
    {
        $validationV4Response = new ValidationV4Response();

        if (isset($data['data'])) {
            $validationV4Response->setData(self::mapData($data['data']));
        }

        if (isset($data['quality'])) {
            $validationV4Response->setQuality(self::mapQuality($data['quality']));
        }

        if (isset($data['system'])) {
            $validationV4Response->setSystem(self::mapSystem($data['system']));
        }

        return $validationV4Response;
    }

    private static function mapData(array $data): ?ValidationV4Data
    {
        $validationV4Data = new ValidationV4Data();

        if (empty($data['address'])) {
            return null;
        }

        $validationV4Address = new ValidationV4Address();

        if (isset($data['address']['standard'])) {
            $validationV4Standard = new ValidationV4Standard();
            foreach ($data['address']['standard'] as $k => $v) {
                $camelKey = self::snakeToCamel($k);
                if ('adm_code' === $k) {
                    $admCodes = [];
                    foreach ($v as $adm) {
                        $admObj = new ValidationV4AdmCode();
                        $admObj->setIso3($adm['iso3']);
                        $admObj->setType($adm['type']);
                        $admObj->setValue($adm['value']);
                        $admCodes[] = $admObj;
                    }

                    $validationV4Standard->setAdmCode($admCodes);
                } elseif ('egon_code' === $k) {
                    $egon = new ValidationV4EgonCode();
                    $egon->setCity($v['city'] ?? '');
                    $egon->setStreet($v['street'] ?? '');
                    $egon->setHn($v['hn'] ?? '');
                    $validationV4Standard->setEgonCode($egon);
                } else {
                    $method = 'set'.ucfirst($camelKey);
                    if (method_exists($validationV4Standard, $method)) {
                        $validationV4Standard->$method($v);
                    }
                }
            }

            $validationV4Address->setStandard($validationV4Standard);
        }

        if (isset($data['address']['smart'])) {
            $validationV4Smart = new ValidationV4Smart();
            foreach ($data['address']['smart'] as $k => $v) {
                $method = 'set'.ucfirst(self::snakeToCamel($k));
                if (method_exists($validationV4Smart, $method)) {
                    $validationV4Smart->$method($v);
                }
            }

            $validationV4Address->setSmart($validationV4Smart);
        }

        $validationV4Data->setAddress($validationV4Address);

        if (isset($data['geo'])) {
            $validationV4Geo = new ValidationV4Geo();
            foreach ($data['geo'] as $k => $v) {
                $method = 'set'.ucfirst(self::snakeToCamel($k));
                if (method_exists($validationV4Geo, $method)) {
                    $validationV4Geo->$method($v);
                }
            }

            $validationV4Data->setGeo($validationV4Geo);
        }

        if (isset($data['postal'])) {
            $validationV4Postal = new ValidationV4Postal();
            foreach ($data['postal'] as $k => $v) {
                $method = 'set'.ucfirst(self::snakeToCamel($k));
                if (method_exists($validationV4Postal, $method)) {
                    $validationV4Postal->$method($v);
                }
            }

            $validationV4Data->setPostal($validationV4Postal);
        }

        return $validationV4Data;
    }

    private static function mapQuality(array $quality): ValidationV4Quality
    {
        $validationV4Quality = new ValidationV4Quality();

        if (isset($quality['address'])) {
            $validationV4QualityAddress = new ValidationV4QualityAddress();

            foreach (['locality', 'street', 'hn'] as $field) {
                if (isset($quality['address'][$field])) {
                    $f = new ValidationV4QualityField();
                    $f->setFlag($quality['address'][$field]['flag']);
                    $f->setCode($quality['address'][$field]['code']);
                    $f->setDescription($quality['address'][$field]['description']);
                    $method = 'set'.ucfirst($field);
                    $validationV4QualityAddress->$method($f);
                }
            }

            $validationV4Quality->setAddress($validationV4QualityAddress);
        }

        return $validationV4Quality;
    }

    private static function mapSystem(array $system): ValidationV4System
    {
        $validationV4System = new ValidationV4System();
        $validationV4System->setRetCode($system['ret_code']);
        $validationV4System->setDesRetCode($system['des_ret_code']);

        return $validationV4System;
    }

    private static function snakeToCamel(string $string): string
    {
        $parts = explode('_', $string);

        return array_shift($parts).implode('', array_map(ucfirst(...), $parts));
    }
}
