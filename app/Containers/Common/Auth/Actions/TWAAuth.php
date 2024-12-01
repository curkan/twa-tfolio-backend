<?php

declare(strict_types=1);

namespace App\Containers\Common\Auth\Actions;

class TWAAuth
{
    public string $initData;
    public string $token;

    public function __construct(string $initData)
    {
        $this->initData = $initData;
        $this->token = config('bot.bot_token');
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        [$checksum, $sortedInitData] = self::convertInitData($this->initData);
        $secretKey                   = hash_hmac('sha256', $this->token, 'WebAppData', true);
        $hash                        = bin2hex(hash_hmac('sha256', $sortedInitData, $secretKey, true));

        return 0 === strcmp($hash, $checksum);
    }

    /**
     * convert init data to `key=value` and sort it `alphabetically`.
     *
     * @param string $initData init data from Telegram (`Telegram.WebApp.initData`)
     *
     * @return string[] return hash and sorted init data
     */
    public function convertInitData(string $initData): array
    {
        $initDataArray = explode('&', rawurldecode($initData));
        $needle        = 'hash=';
        $hash          = '';

        foreach ($initDataArray as &$data) {
            if (substr($data, 0, \strlen($needle)) === $needle) {
                $hash = substr_replace($data, '', 0, \strlen($needle));
                $data = null;
            }
        }
        $initDataArray = array_filter($initDataArray);
        sort($initDataArray);

        return [$hash, implode("\n", $initDataArray)];
    }

    public function toArray(): array
    {
        return [];
    }
}
