<?php

declare(strict_types=1);

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
    /**
     * @param array<array-key, mixed> $data
     */
    public static function fromArray(array $data): ValidationV4Response
    {
        $validationV4Response = new ValidationV4Response();

        if (\is_array($data['data'] ?? null)) {
            $validationV4Response->setData(self::mapData($data['data']));
        }

        if (\is_array($data['quality'] ?? null)) {
            $validationV4Response->setQuality(self::mapQuality($data['quality']));
        }

        if (\is_array($data['system'] ?? null)) {
            $validationV4Response->setSystem(self::mapSystem($data['system']));
        }

        return $validationV4Response;
    }

    /**
     * @param array<array-key, mixed> $data
     */
    private static function mapData(array $data): ?ValidationV4Data
    {
        $validationV4Data = new ValidationV4Data();

        if (empty($data['address']) || !\is_array($data['address'])) {
            return null;
        }

        $validationV4Address = new ValidationV4Address();

        if (\is_array($data['address']['standard'] ?? null)) {
            $validationV4Standard = new ValidationV4Standard();
            foreach ($data['address']['standard'] as $k => $v) {
                $k = (string) $k;
                $camelKey = self::snakeToCamel($k);
                if ('adm_code' === $k && \is_array($v)) {
                    $admCodes = [];
                    foreach ($v as $adm) {
                        if (!\is_array($adm)) {
                            continue;
                        }

                        $admObj = new ValidationV4AdmCode();
                        $admObj->setIso3(self::toStringValue($adm['iso3'] ?? ''));
                        $admObj->setType(self::toStringValue($adm['type'] ?? ''));
                        $admObj->setValue(self::toStringValue($adm['value'] ?? ''));
                        $admCodes[] = $admObj;
                    }

                    $validationV4Standard->setAdmCode($admCodes);
                } elseif ('egon_code' === $k && \is_array($v)) {
                    $egon = new ValidationV4EgonCode();
                    $egon->setCity(self::toStringValue($v['city'] ?? ''));
                    $egon->setStreet(self::toStringValue($v['street'] ?? ''));
                    $egon->setHn(self::toStringValue($v['hn'] ?? ''));
                    $validationV4Standard->setEgonCode($egon);
                } else {
                    $method = 'set'.ucfirst($camelKey);
                    if (method_exists($validationV4Standard, $method)) {
                        $validationV4Standard->{$method}($v);
                    }
                }
            }

            $validationV4Address->setStandard($validationV4Standard);
        }

        if (\is_array($data['address']['smart'] ?? null)) {
            $validationV4Smart = new ValidationV4Smart();
            foreach ($data['address']['smart'] as $k => $v) {
                $method = 'set'.ucfirst(self::snakeToCamel((string) $k));
                if (method_exists($validationV4Smart, $method)) {
                    $validationV4Smart->{$method}($v);
                }
            }

            $validationV4Address->setSmart($validationV4Smart);
        }

        $validationV4Data->setAddress($validationV4Address);

        if (\is_array($data['geo'] ?? null)) {
            $validationV4Geo = new ValidationV4Geo();
            foreach ($data['geo'] as $k => $v) {
                $method = 'set'.ucfirst(self::snakeToCamel((string) $k));
                if (method_exists($validationV4Geo, $method)) {
                    $validationV4Geo->{$method}($v);
                }
            }

            $validationV4Data->setGeo($validationV4Geo);
        }

        if (\is_array($data['postal'] ?? null)) {
            $validationV4Postal = new ValidationV4Postal();
            foreach ($data['postal'] as $k => $v) {
                $method = 'set'.ucfirst(self::snakeToCamel((string) $k));
                if (method_exists($validationV4Postal, $method)) {
                    $validationV4Postal->{$method}($v);
                }
            }

            $validationV4Data->setPostal($validationV4Postal);
        }

        return $validationV4Data;
    }

    /**
     * @param array<array-key, mixed> $quality
     */
    private static function mapQuality(array $quality): ValidationV4Quality
    {
        $validationV4Quality = new ValidationV4Quality();

        if (\is_array($quality['address'] ?? null)) {
            $validationV4QualityAddress = new ValidationV4QualityAddress();

            foreach (['locality', 'street', 'hn'] as $field) {
                $fieldData = $quality['address'][$field] ?? null;
                if (\is_array($fieldData)) {
                    $f = new ValidationV4QualityField();
                    $f->setFlag(self::toStringValue($fieldData['flag'] ?? ''));
                    $f->setCode(self::toStringValue($fieldData['code'] ?? ''));
                    $f->setDescription(self::toStringValue($fieldData['description'] ?? ''));
                    $method = 'set'.ucfirst($field);
                    $validationV4QualityAddress->{$method}($f);
                }
            }

            $validationV4Quality->setAddress($validationV4QualityAddress);
        }

        return $validationV4Quality;
    }

    /**
     * @param array<array-key, mixed> $system
     */
    private static function mapSystem(array $system): ValidationV4System
    {
        $validationV4System = new ValidationV4System();
        $validationV4System->setRetCode(isset($system['ret_code']) ? self::toStringValue($system['ret_code']) : null);
        $validationV4System->setDesRetCode(isset($system['des_ret_code']) ? self::toStringValue($system['des_ret_code']) : null);

        return $validationV4System;
    }

    private static function snakeToCamel(string $string): string
    {
        $parts = explode('_', $string);

        return array_shift($parts).implode('', array_map(ucfirst(...), $parts));
    }

    private static function toStringValue(mixed $value): string
    {
        return \is_scalar($value) ? (string) $value : '';
    }
}
