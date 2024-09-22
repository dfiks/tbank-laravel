<?php

namespace DFiks\TBank\Payments\Enums;

/**
 * Enum TaxationType
 * Тег ФФД: 1055.
 *
 * Система налогообложения. Возможные значения:
 * - osn — общая СН;
 * - usn_income — упрощенная СН (доходы);
 * - usn_income_outcome — упрощенная СН (доходы минус расходы);
 * - envd — единый налог на вмененный доход;
 * - esn — единый сельскохозяйственный налог;
 * - patent — патентная СН.
 */
enum TaxationType: string
{
    case Osn = 'osn';
    case UsnIncome = 'usn_income';
    case UsnIncomeOutcome = 'usn_income_outcome';
    case Envd = 'envd';
    case Ees = 'esn';
    case Patent = 'patent';
}
