<?php

namespace DFiks\TBank\Payments\Enums;

/**
 * Перечисление единиц измерения (тег 2108).
 */
enum MeasurementUnitType: int
{
    /**
     * Штука или единица.
     */
    case Unit = 0;

    /**
     * Грамм.
     */
    case Gram = 10;

    /**
     * Килограмм.
     */
    case Kilogram = 11;

    /**
     * Тонна.
     */
    case Tonne = 12;

    /**
     * Сантиметр.
     */
    case Centimeter = 20;

    /**
     * Дециметр.
     */
    case Decimeter = 21;

    /**
     * Метр.
     */
    case Meter = 22;

    /**
     * Квадратный сантиметр.
     */
    case SquareCentimeter = 30;

    /**
     * Квадратный дециметр.
     */
    case SquareDecimeter = 31;

    /**
     * Квадратный метр.
     */
    case SquareMeter = 32;

    /**
     * Миллилитр.
     */
    case Milliliter = 40;

    /**
     * Литр.
     */
    case Liter = 41;

    /**
     * Кубический метр.
     */
    case CubicMeter = 42;

    /**
     * Киловатт-час.
     */
    case KilowattHour = 50;

    /**
     * Гигакалория.
     */
    case Gigacalorie = 51;

    /**
     * Сутки (день).
     */
    case Day = 70;

    /**
     * Час.
     */
    case Hour = 71;

    /**
     * Минута.
     */
    case Minute = 72;

    /**
     * Секунда.
     */
    case Second = 73;

    /**
     * Килобайт.
     */
    case Kilobyte = 80;

    /**
     * Мегабайт.
     */
    case Megabyte = 81;

    /**
     * Гигабайт.
     */
    case Gigabyte = 82;

    /**
     * Терабайт.
     */
    case Terabyte = 83;

    /**
     * Иная единица измерения.
     */
    case Other = 255;
}
