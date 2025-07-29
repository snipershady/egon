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

final class ValidationV4Mapper {

    public static function fromArray(array $data): ValidationV4Response {
        $response = new ValidationV4Response();

        if (isset($data['data'])) {
            $response->setData(self::mapData($data['data']));
        }

        if (isset($data['quality'])) {
            $response->setQuality(self::mapQuality($data['quality']));
        }

        if (isset($data['system'])) {
            $response->setSystem(self::mapSystem($data['system']));
        }

        return $response;
    }

    private static function mapData(array $data): ?ValidationV4Data {
        $obj = new ValidationV4Data();

        if (empty($data['address'])) {
            return null;
        }

        $address = new ValidationV4Address();

        if (isset($data['address']['standard'])) {
            $std = new ValidationV4Standard();
            foreach ($data['address']['standard'] as $k => $v) {
                $camelKey = self::snakeToCamel($k);
                if ($k === 'adm_code') {
                    $admCodes = [];
                    foreach ($v as $adm) {
                        $admObj = new ValidationV4AdmCode();
                        $admObj->setIso3($adm['iso3']);
                        $admObj->setType($adm['type']);
                        $admObj->setValue($adm['value']);
                        $admCodes[] = $admObj;
                    }
                    $std->setAdmCode($admCodes);
                } elseif ($k === 'egon_code') {
                    $egon = new ValidationV4EgonCode();
                    $egon->setCity($v['city']);
                    $egon->setStreet($v['street']);
                    $egon->setHn($v['hn']);
                    $std->setEgonCode($egon);
                } else {
                    $method = 'set' . ucfirst($camelKey);
                    if (method_exists($std, $method)) {
                        $std->$method($v);
                    }
                }
            }
            $address->setStandard($std);
        }

        if (isset($data['address']['smart'])) {
            $smart = new ValidationV4Smart();
            foreach ($data['address']['smart'] as $k => $v) {
                $method = 'set' . ucfirst(self::snakeToCamel($k));
                if (method_exists($smart, $method)) {
                    $smart->$method($v);
                }
            }
            $address->setSmart($smart);
        }

        $obj->setAddress($address);

        if (isset($data['geo'])) {
            $geo = new ValidationV4Geo();
            foreach ($data['geo'] as $k => $v) {
                $method = 'set' . ucfirst(self::snakeToCamel($k));
                if (method_exists($geo, $method)) {
                    $geo->$method($v);
                }
            }
            $obj->setGeo($geo);
        }

        if (isset($data['postal'])) {
            $postal = new ValidationV4Postal();
            foreach ($data['postal'] as $k => $v) {
                $method = 'set' . ucfirst(self::snakeToCamel($k));
                if (method_exists($postal, $method)) {
                    $postal->$method($v);
                }
            }
            $obj->setPostal($postal);
        }

        return $obj;
    }

    private static function mapQuality(array $quality): ValidationV4Quality {
        $q = new ValidationV4Quality();

        if (isset($quality['address'])) {
            $qa = new ValidationV4QualityAddress();

            foreach (['locality', 'street', 'hn'] as $field) {
                if (isset($quality['address'][$field])) {
                    $f = new ValidationV4QualityField();
                    $f->setFlag($quality['address'][$field]['flag']);
                    $f->setCode($quality['address'][$field]['code']);
                    $f->setDescription($quality['address'][$field]['description']);
                    $method = 'set' . ucfirst($field);
                    $qa->$method($f);
                }
            }

            $q->setAddress($qa);
        }

        return $q;
    }

    private static function mapSystem(array $system): ValidationV4System {
        $s = new ValidationV4System();
        $s->setRetCode($system['ret_code']);
        $s->setDesRetCode($system['des_ret_code']);
        return $s;
    }

    private static function snakeToCamel(string $string): string {
        $parts = explode('_', $string);
        return array_shift($parts) . implode('', array_map('ucfirst', $parts));
    }
}
