<?php

namespace  App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\ConversationRepository;
use App\Http\Requests\StoreMessageRequest;



class ConversationsController extends Controller
{
    /**
     *
     * @var ConversationRepository
     */
    private $conversationRepository;

    /**
     *
     *
     * @param ConversationRepository $conversationRepository
     */
    public function __construct(ConversationRepository $conversationRepository)
    {
        $this->conversationRepository = $conversationRepository;
    }

    /**
     *
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $conversations = $this->conversationRepository->getConversations($request->user()->id);
        $unread = $this->conversationRepository->unreadCount($request->user()->id);
        foreach ($conversations as $conversation) {
            if (isset($unread[$conversation->id])) {
                $conversation->unread = $unread[$conversation->id];
            } else {
                $conversation->unread = 0;
            }
        }
        return [
            'conversations' => $conversations
        ];
    }

    /**
     *
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function show(Request $request, User $user)
    {
        $messagesQuery = $this->conversationRepository
            ->getMessagesFor($request->user()->id, $user->id);
        $count = null;
        if ($request->get('before')) {
            $messagesQuery = $messagesQuery->where('created_at', '<', $request->get('before'));
        } else {
            $count = $messagesQuery->count();
        }
        $messages = $messagesQuery->limit(10)->get();
        foreach ($messages as $message) {
            if ($messages->read_at === null && $message->to_id === $request->user()->id) {
                $this->conversationRepository->readAllFrom($message->from_id, $message->to_id);
                break;
            }
        }
        return [
            'messages' => array_reverse($messages->toArray()),
            'count'    => $count
        ];
    }

    /**
     *
     *
     * @param User $user
     * @param StoreMessageRequest $request
     * @return void
     */
    public function store(User $user, StoreMessageRequest $request)
    {
        $message = $this->conversationRepository->createMessage(
            $request->get('content'),
            $request->user()->id,
            $user->id
        );
        return [
            'message'->$message
        ];
    }
}
