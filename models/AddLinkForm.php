<?php

namespace app\models;

use DateInterval;
use DateTime;
use Yii;
use yii\base\Model;

class AddLinkForm extends Model implements CommandInterface
{
    public $link;
    public $timeout;
    public $limit;

    protected $short;

    public function rules()
    {
        return [
            [['link', 'timeout', 'limit'], 'required'],
            ['link', 'url'],
            ['timeout', 'in', 'range' => [1, 2, 4, 12, 24]],
            ['limit', 'in', 'range' => [0, 1, 2, 4, 10, 40]],
        ];
    }

    public function execute(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $short = $this->generateUniqueShort();
        $timeout = $this->makeTimeout($this->timeout);

        $link = new Link([
            'link' => $this->link,
            'timeout' => $timeout,
            'reverse_counter' => $this->limit,
            'usage_limit' => $this->limit,
            'short' => $short,
        ]);

        if (!$link->insert()) {
            $this->addError('', Yii::t('app', 'Can`t create new link. Error: "{error}".', [
                'error' => current($link->getFirstErrors())
            ]));

            return false;
        }

        $this->short = $short;

        return true;
    }

    public function getShort(): ?string
    {
        return $this->short;
    }

    private function generateUniqueShort(int $wordLength = 8, string $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'): string
    {
        if ($wordLength <= 0) {
            return '';
        }

        if ($wordLength > 100) {
            $wordLength = 100;
        }

        $length = mb_strlen($chars);
        if (0 === $length) {
            return '';
        }

        if ($length > 1000) {
            $chars = mb_substr($chars, 0, 1000);
            $length = 1000;
        }

        $word = '';
        for ($i = 0; $i < $wordLength; $i++) {
            $offset = mt_rand(0, $length);
            $word .= substr($chars, $offset, 1);
        }

        return $word;
    }

    private function makeTimeout(int $limit): ?int
    {
        $time = 'PT' . $limit . 'H';
        $limit = new DateTime();
        $interval = new DateInterval($time);
        $limit->add($interval);

        return $limit->getTimestamp();
    }
}
