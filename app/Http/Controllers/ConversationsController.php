<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthManager;
use App\Notifications\MessageReceived;
use App\Http\Requests\StoreMessageRequest;
use App\Repository\ConversationRepository;



class ConversationsController extends Controller
{

    private $repo;
    private $auth;

    /**
     *
     * @param ConversationRepository $conversationRepository
     * @param AuthManager $auth
     */
    public function __construct(ConversationRepository $conversationRepository, AuthManager $auth)
    {
        $this->middleware('auth');
        $this->repo = $conversationRepository;
        $this->auth = $auth;
    }

    /**
     *
     * @return void
     */
    public function index()
    {
        return view('conversations/index');
    }

    /**
     *
     * @param User $user
     * @return void
     *
     */
    public function show(User $user)
    {
        $me = $this->auth->user();
        $messages = $this->repo->getMessagesFor($me->id, $user->id)->paginate(6);
        $unread = $this->repo->unreadCount($me->id);

        if (isset($unread[$user->id])) {
            $this->repo->readAllFrom($user->id, $me->id);
            unset($unread[$user->id]);
        }

        return view('conversations/show', [
            'users' => $this->repo->getConversations($me->id),
            'user' => $user,
            'messages' => $messages,
            'unread' => $unread
        ]);
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
