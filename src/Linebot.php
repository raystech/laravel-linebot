<?php

namespace Raystech\Linebot;

use Raystech\Linebot\Linebot\Event\Parser\EventRequestParser;
use Raystech\Linebot\Linebot\HTTPClient;
use Raystech\Linebot\Linebot\MessageBuilder;
use Raystech\Linebot\Linebot\MessageBuilder\TextMessageBuilder;
use Raystech\Linebot\Linebot\Response;
use Raystech\Linebot\Linebot\SignatureValidator;
use ReflectionClass;

class Linebot
{
  const DEFAULT_ENDPOINT_BASE = 'https://api.line.me';

  /** @var string */
  private $channelSecret;
  /** @var string */
  private $endpointBase;
  /** @var HTTPClient */
  private $httpClient;

  /**
   * LINEBot constructor.
   *
   * @param HTTPClient $httpClient HTTP client instance to use API calling.
   * @param array $args Configurations.
   */
  public function __construct(HTTPClient $httpClient, array $args)
  {
    $this->httpClient    = $httpClient;
    $this->channelSecret = $args['channelSecret'];

    $this->endpointBase = LINEBot::DEFAULT_ENDPOINT_BASE;
    if (array_key_exists('endpointBase', $args) && !empty($args['endpointBase'])) {
      $this->endpointBase = $args['endpointBase'];
    }
  }

  /**
   * Gets specified user's profile through API calling.
   *
   * @param string $userId The user ID to retrieve profile.
   * @return Response
   */
  public function getProfile($userId)
  {
    return $this->httpClient->get($this->endpointBase . '/v2/bot/profile/' . urlencode($userId));
  }

  /**
   * Gets message content which is associated with specified message ID.
   *
   * @param string $messageId The message ID to retrieve content.
   * @return Response
   */
  public function getMessageContent($messageId)
  {
    return $this->httpClient->get($this->endpointBase . '/v2/bot/message/' . urlencode($messageId) . '/content');
  }

  /**
   * Replies arbitrary message to destination which is associated with reply token.
   *
   * @param string $replyToken Identifier of destination.
   * @param MessageBuilder $messageBuilder Message builder to send.
   * @return Response
   */
  public function replyMessage($replyToken, MessageBuilder $messageBuilder)
  {
    return $this->httpClient->post($this->endpointBase . '/v2/bot/message/reply', [
      'replyToken' => $replyToken,
      'messages'   => $messageBuilder->buildMessage(),
    ]);
  }

  /**
   * Replies text message(s) to destination which is associated with reply token.
   *
   * This method receives variable texts. It can send text(s) message as bulk.
   *
   * Exact signature of this method is <code>replyText(string $replyToken, string $text, string[] $extraTexts)</code>.
   *
   * Means, this method can also receive multiple texts like so;
   *
   * <code>
   * $bot->replyText('reply-text', 'text', 'extra text1', 'extra text2', ...)
   * </code>
   *
   * @param string $replyToken Identifier of destination.
   * @param string $text Text of message.
   * @param string[]|null $extraTexts Extra text of message.
   * @return Response
   */
  public function replyText($replyToken, $text, $extraTexts = null)
  {
    $extra = [];
    if (!is_null($extraTexts)) {
      $args  = func_get_args();
      $extra = array_slice($args, 2);
    }

    /** @var TextMessageBuilder $textMessageBuilder */
    $ref                = new ReflectionClass('Raystech\Linebot\Linebot\MessageBuilder\TextMessageBuilder');
    $textMessageBuilder = $ref->newInstanceArgs(array_merge([$text], $extra));

    return $this->replyMessage($replyToken, $textMessageBuilder);
  }

  /**
   * Sends arbitrary message to destination.
   *
   * @param string $to Identifier of destination.
   * @param MessageBuilder $messageBuilder Message builder to send.
   * @return Response
   */
  public function pushMessage($to, MessageBuilder $messageBuilder)
  {
    return $this->httpClient->post($this->endpointBase . '/v2/bot/message/push', [
      'to'       => $to,
      'messages' => $messageBuilder->buildMessage(),
    ]);
  }

  /**
   * Sends arbitrary message to multi destinations.
   *
   * @param array $tos Identifiers of destination.
   * @param MessageBuilder $messageBuilder Message builder to send.
   * @return Response
   */
  public function multicast(array $tos, MessageBuilder $messageBuilder)
  {
    return $this->httpClient->post($this->endpointBase . '/v2/bot/message/multicast', [
      'to'       => $tos,
      'messages' => $messageBuilder->buildMessage(),
    ]);
  }

  /**
   * Leaves from group.
   *
   * @param string $groupId Identifier of group to leave.
   * @return Response
   */
  public function leaveGroup($groupId)
  {
    return $this->httpClient->post($this->endpointBase . '/v2/bot/group/' . urlencode($groupId) . '/leave', []);
  }

  /**
   * Leaves from room.
   *
   * @param string $roomId Identifier of room to leave.
   * @return Response
   */
  public function leaveRoom($roomId)
  {
    return $this->httpClient->post($this->endpointBase . '/v2/bot/room/' . urlencode($roomId) . '/leave', []);
  }

  /**
   * Parse event request to Event objects.
   *
   * @param string $body Request body.
   * @param string $signature Signature of request.
   * @return LINEBot\Event\BaseEvent[]
   */
  public function parseEventRequest($body, $signature)
  {
    return EventRequestParser::parseEventRequest($body, $this->channelSecret, $signature);
  }

  /**
   * Validate request with signature.
   *
   * @param string $body Request body.
   * @param string $signature Signature of request.
   * @return bool Request is valid or not.
   */
  public function validateSignature($body, $signature)
  {
    return SignatureValidator::validateSignature($body, $this->channelSecret, $signature);
  }
}
