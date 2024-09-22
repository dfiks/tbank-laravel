<?php

namespace DFiks\TBank\Payments\Enums;

/**
 * Перечисление признаков агента.
 */
enum AgentSignType: string
{
    case BankPayingAgent = 'bank_paying_agent';  // Банковский платежный агент
    case BankPayingSubagent = 'bank_paying_subagent';  // Банковский платежный субагент
    case PayingAgent = 'paying_agent';  // Платежный агент
    case PayingSubagent = 'paying_subagent';  // Платежный субагент
    case Attorney = 'attorney';  // Поверенный
    case CommissionAgent = 'commission_agent';  // Комиссионер
    case Another = 'another';  // Другой тип агента
}
