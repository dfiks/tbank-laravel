<?php

namespace DFiks\TBank\Webhook\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class WebhookRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (!Config::get('tbank.generals.webhook.enabled_allowed_ip_addresses')) {
            return true;
        }

        $allowedIps = array_filter(Config::get('tbank.generals.webhook.allowed_ip_addresses', []));

        foreach ($allowedIps as $ip) {
            if ($this->ipMatches($ip)) {
                return true;
            }
        }

        return false;
    }

    public function rules(): array
    {
        return [
            'TerminalKey' => 'required|string',
            'OrderId' => 'required|string',
            'Success' => 'required|boolean',
            'Status' => 'required|string',
            'PaymentId' => 'required|sometimes',
            'ErrorCode' => 'required|sometimes',
            'Amount' => 'required|sometimes',
            'CardId' => 'required|sometimes',
            'Pan' => 'required|string',
            'ExpData' => 'required|sometimes',
            'Token' => 'required|string',
        ];
    }

    /**
     * Проверяет, соответствует ли IP-адрес клиента указанному IP-адресу или диапазону.
     *
     * @param  string $allowedIp
     * @return bool
     */
    protected function ipMatches(string $allowedIp): bool
    {
        // Если IP-адрес в формате CIDR (например, 91.194.226.0/23)
        if (str_contains($allowedIp, '/')) {
            return $this->isIpInRange($this->ip(), $allowedIp);
        }

        // Если точный IP-адрес
        return $this->ip() === $allowedIp;
    }

    /**
     * Проверяет, находится ли IP-адрес в диапазоне CIDR.
     *
     * @param  string $ip
     * @param  string $range
     * @return bool
     */
    protected function isIpInRange(string $ip, string $range): bool
    {
        [$subnet, $bits] = explode('/', $range);
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask; // Восстановление адреса подсети

        return ($ip & $mask) === $subnet;
    }
}
