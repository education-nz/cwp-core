<?php

namespace Education\Cwp;

use Monolog\Handler\SlackHandler;
use SilverStripe\Control\Director;
use Exception;

class EducationSlackHandler extends SlackHandler
{
    /**
     * @param  string                    $token                  Slack API token
     * @param  string                    $channel                Slack channel (encoded ID or name)
     * @param  string|null               $username               Name of a bot
     * @param  bool                      $useAttachment          Whether the message should be added to Slack as attachment (plain text otherwise)
     * @param  string|null               $iconEmoji              The emoji name to use (or null)
     * @param  int                       $level                  The minimum logging level at which this handler will be triggered
     * @param  bool                      $bubble                 Whether the messages that are handled can bubble up the stack or not
     * @param  bool                      $useShortAttachment     Whether the the context/extra messages added to Slack as attachments are in a short style
     * @param  bool                      $includeContextAndExtra Whether the attachment should include context and extra data
     * @param  array                     $excludeFields          Dot separated list of fields to exclude from slack message. E.g. ['context.field1', 'extra.field2']
     * @throws MissingExtensionException If no OpenSSL PHP extension configured
     */
    public function __construct($token, $channel, $username = null, $useAttachment = true, $iconEmoji = null, $level = Logger::CRITICAL, $bubble = true, $useShortAttachment = false, $includeContextAndExtra = false, array $excludeFields = array())
    {
        $username = Director::absoluteBaseURL();

        parent::__construct($token, $channel, $username, $useAttachment, $iconEmoji, $level, $bubble, $useShortAttachment, $includeContextAndExtra, $excludeFields);
    }

    /**
     * {@inheritdoc}
     *
     * @param array $record
     */
    protected function write(array $record)
    {
        try {
            parent::write($record);
            $this->finalizeWrite();
        } catch (Exception $e) {
            // exception when trying to write the record.
        }
    }
}
