<?php

namespace App\Logging;

use Illuminate\Support\Facades\Http;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Formatter\LineFormatter;

class TelegramLogger extends AbstractProcessingHandler
{
    protected function write(\Monolog\LogRecord $record): void

    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        if (!$botToken || !$chatId) {
            return;
        }

        $text = "📢 *New Log Message*\n\n";
        $text .= "🕒 " . now()->format('Y-m-d H:i:s') . "\n";
        $text .= "💬 `" . addslashes($record['message']) . "`";

        try {
            Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'Markdown',
            ]);
        } catch (\Exception $e) {
            // ما تبعتش error من جوه اللوجر نفسه
        }
    }

    public function __invoke(array $config)
    {
        $logger = new Logger('telegram');
        $handler = new self();
        $handler->setFormatter(new LineFormatter(null, null, true, true));
        $logger->pushHandler($handler);
        return $logger;
    }
}
