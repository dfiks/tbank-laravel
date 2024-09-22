<?php

namespace DFiks\TBank\Payments\Enums;

/**
 * Перечисление признаков предмета расчета.
 * Тег ФФД: 1212.
 */
enum PaymentObjectItemType: string
{
    /**
     * Товар.
     */
    case Commodity = 'commodity';

    /**
     * Подакцизный товар.
     */
    case Excise = 'excise';

    /**
     * Работа.
     */
    case Job = 'job';

    /**
     * Услуга.
     */
    case Service = 'service';

    /**
     * Ставка азартной игры.
     */
    case GamblingBet = 'gambling_bet';

    /**
     * Выигрыш азартной игры.
     */
    case GamblingPrize = 'gambling_prize';

    /**
     * Лотерейный билет.
     */
    case Lottery = 'lottery';

    /**
     * Выигрыш лотереи.
     */
    case LotteryPrize = 'lottery_prize';

    /**
     * Предоставление результатов интеллектуальной деятельности.
     */
    case IntellectualActivity = 'intellectual_activity';

    /**
     * Платеж.
     */
    case Payment = 'payment';

    /**
     * Агентское вознаграждение.
     */
    case AgentCommission = 'agent_commission';

    /**
     * Составной предмет расчета.
     */
    case Composite = 'composite';

    /**
     * Выплата.
     */
    case Contribution = 'contribution';

    /**
     * Имущественное право.
     */
    case PropertyRights = 'property_rights';

    /**
     * Внереализационный доход.
     */
    case Unrealization = 'unrealization';

    /**
     * Иные платежи и взносы.
     */
    case TaxReduction = 'tax_reduction';

    /**
     * Торговый сбор.
     */
    case TradeFee = 'trade_fee';

    /**
     * Курортный сбор.
     */
    case ResortTax = 'resort_tax';

    /**
     * Залог.
     */
    case Pledge = 'pledge';

    /**
     * Расход.
     */
    case IncomeDecrease = 'income_decrease';

    /**
     * Взносы на ОПС ИП.
     */
    case IePensionInsuranceWithoutPayments = 'ie_pension_insurance_without_payments';

    /**
     * Взносы на ОПС.
     */
    case IePensionInsuranceWithPayments = 'ie_pension_insurance_with_payments';

    /**
     * Взносы на ОМС ИП.
     */
    case IeMedicalInsuranceWithoutPayments = 'ie_medical_insurance_without_payments';

    /**
     * Взносы на ОМС.
     */
    case IeMedicalInsuranceWithPayments = 'ie_medical_insurance_with_payments';

    /**
     * Взносы на ОСС.
     */
    case SocialInsurance = 'social_insurance';

    /**
     * Платеж казино.
     */
    case CasinoChips = 'casino_chips';

    /**
     * Выдача денежных средств.
     */
    case AgentPayment = 'agent_payment';

    /**
     * АТНМ (акцизные товары без кода маркировки).
     */
    case ExcisableGoodsWithoutMarkingCode = 'excisable_goods_without_marking_code';

    /**
     * АТМ (акцизные товары с кодом маркировки).
     */
    case ExcisableGoodsWithMarkingCode = 'excisable_goods_with_marking_code';

    /**
     * ТНМ (товары без кода маркировки).
     */
    case GoodsWithoutMarkingCode = 'goods_without_marking_code';

    /**
     * ТМ (товары с кодом маркировки).
     */
    case GoodsWithMarkingCode = 'goods_with_marking_code';

    /**
     * Иной предмет расчета.
     */
    case Another = 'another';

    /**
     * Получить описание предмета расчета.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::Commodity => 'Товар',
            self::Excise => 'Подакцизный товар',
            self::Job => 'Работа',
            self::Service => 'Услуга',
            self::GamblingBet => 'Ставка азартной игры',
            self::GamblingPrize => 'Выигрыш азартной игры',
            self::Lottery => 'Лотерейный билет',
            self::LotteryPrize => 'Выигрыш лотереи',
            self::IntellectualActivity => 'Предоставление результатов интеллектуальной деятельности',
            self::Payment => 'Платеж',
            self::AgentCommission => 'Агентское вознаграждение',
            self::Composite => 'Составной предмет расчета',
            self::Contribution => 'Выплата',
            self::PropertyRights => 'Имущественное право',
            self::Unrealization => 'Внереализационный доход',
            self::TaxReduction => 'Иные платежи и взносы',
            self::TradeFee => 'Торговый сбор',
            self::ResortTax => 'Курортный сбор',
            self::Pledge => 'Залог',
            self::IncomeDecrease => 'Расход',
            self::IePensionInsuranceWithoutPayments => 'Взносы на ОПС ИП',
            self::IePensionInsuranceWithPayments => 'Взносы на ОПС',
            self::IeMedicalInsuranceWithoutPayments => 'Взносы на ОМС ИП',
            self::IeMedicalInsuranceWithPayments => 'Взносы на ОМС',
            self::SocialInsurance => 'Взносы на ОСС',
            self::CasinoChips => 'Платеж казино',
            self::AgentPayment => 'Выдача денежных средств',
            self::ExcisableGoodsWithoutMarkingCode => 'АТНМ',
            self::ExcisableGoodsWithMarkingCode => 'АТМ',
            self::GoodsWithoutMarkingCode => 'ТНМ',
            self::GoodsWithMarkingCode => 'ТМ',
            self::Another => 'Иной предмет расчета',
        };
    }

    /**
     * Получить значение по умолчанию.
     *
     * @return self
     */
    public static function default(): self
    {
        return self::Commodity;
    }
}
