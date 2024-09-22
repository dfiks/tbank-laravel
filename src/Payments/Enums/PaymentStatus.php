<?php

namespace DFiks\TBank\Payments\Enums;

/**
 * Перечисление статусов платежей.
 */
enum PaymentStatus: string
{
    case New = 'NEW'; // MAPI получил запрос Init. Новый платеж со статусом NEW.
    case FormShowed = 'FORM_SHOWED'; // Клиент был перенаправлен на страницу платежной формы.
    case Authorizing = 'AUTHORIZING'; // Платеж обрабатывается MAPI и платежной системой.
    case ThreeDSChecking = '3DS_CHECKING'; // Платеж проходит проверку 3D-Secure.
    case ThreeDSChecked = '3DS_CHECKED'; // Платеж успешно прошел проверку 3D-Secure.
    case Authorized = 'AUTHORIZED'; // Платеж авторизован, деньги заблокированы на карте клиента.
    case Confirming = 'CONFIRMING'; // Подтверждение платежа обрабатывается.
    case Confirmed = 'CONFIRMED'; // Платеж подтвержден, деньги списаны с карты клиента.
    case Reversing = 'REVERSING'; // Мерчант запросил отмену авторизованного, но неподтвержденного платежа.
    case PartialReversed = 'PARTIAL_REVERSED'; // Частичный возврат по авторизованному платежу завершился успешно.
    case Reversed = 'REVERSED'; // Полный возврат по авторизованному платежу завершился успешно.
    case Refunding = 'REFUNDING'; // Мерчант запросил отмену подтвержденного платежа.
    case PartialRefunded = 'PARTIAL_REFUNDED'; // Частичный возврат по подтвержденному платежу завершился успешно.
    case Refunded = 'REFUNDED'; // Полный возврат по подтвержденному платежу завершился успешно.
    case Canceled = 'CANCELED'; // Мерчант отменил платеж.
    case DeadlineExpired = 'DEADLINE_EXPIRED'; // Платеж не завершен в срок или не прошел 3D-Secure.
    case Rejected = 'REJECTED'; // Банк отклонил платеж.
    case AuthFail = 'AUTH_FAIL'; // Платеж завершился ошибкой или не прошел проверку 3D-Secure.

    /**
     * Получить описание статуса платежа.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::New => 'MAPI получил запрос Init. Новый платеж со статусом NEW.',
            self::FormShowed => 'Клиент был перенаправлен на страницу платежной формы.',
            self::Authorizing => 'Платеж обрабатывается MAPI и платежной системой.',
            self::ThreeDSChecking => 'Платеж проходит проверку 3D-Secure.',
            self::ThreeDSChecked => 'Платеж успешно прошел проверку 3D-Secure.',
            self::Authorized => 'Платеж авторизован, деньги заблокированы на карте клиента.',
            self::Confirming => 'Подтверждение платежа обрабатывается.',
            self::Confirmed => 'Платеж подтвержден, деньги списаны с карты клиента.',
            self::Reversing => 'Мерчант запросил отмену авторизованного, но неподтвержденного платежа.',
            self::PartialReversed => 'Частичный возврат по авторизованному платежу завершился успешно.',
            self::Reversed => 'Полный возврат по авторизованному платежу завершился успешно.',
            self::Refunding => 'Мерчант запросил отмену подтвержденного платежа.',
            self::PartialRefunded => 'Частичный возврат по подтвержденному платежу завершился успешно.',
            self::Refunded => 'Полный возврат по подтвержденному платежу завершился успешно.',
            self::Canceled => 'Мерчант отменил платеж.',
            self::DeadlineExpired => 'Платеж не завершен в срок или не прошел 3D-Secure.',
            self::Rejected => 'Банк отклонил платеж.',
            self::AuthFail => 'Платеж завершился ошибкой или не прошел проверку 3D-Secure.',
        };
    }
}
