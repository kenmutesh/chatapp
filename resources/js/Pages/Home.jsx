
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import ChatLayout from "@/Layouts/ChatLayout.jsx";
import { useEffect, useRef, useState } from "react";
import { ChatBubbleLeftRightIcon } from "@heroicons/react/24/outline/index.js";
import ConversationHeader from "@/Components/App/ConversationHeader.jsx";
import MessageInput from "@/Components/App/MessageInput.jsx";
import MessageItem from "@/Components/App/MessageItem.jsx";

function Home({ messages, selectedConversation }) { // Ensure props are passed
    const [localMessages, setLocalMessages] = useState([]);
    const messagesCtrRef = useRef(null);

    useEffect(() => {
        if (messages) {
            setLocalMessages(messages);
        }
    }, [messages]);

    return (
        <>
            {!messages && (
                <div className="flex flex-col gap-8 justify-center items-center text-center h-full">
                    <div className="text-2xl md:text-4xl p-16 text-slate-200">
                        Please select a conversation to start a chat
                    </div>
                    <ChatBubbleLeftRightIcon className="w-32 h-32 inline-block" />
                </div>
            )}
            {messages && (
                <>
                    <h2>rrr</h2>
                    <ConversationHeader
                        selectedConversation={selectedConversation}
                    />
                    {/*<div*/}
                    {/*    className="flex-1 overflow-y-auto p-5"*/}
                    {/*    ref={messagesCtrRef}*/}
                    {/*>*/}
                    {/*    {localMessages.length === 0 && (*/}
                    {/*        <div className="flex flex-col gap-8 justify-center items-center text-center h-full">*/}
                    {/*            <div className="text-2xl md:text-4xl p-16 text-slate-200">*/}
                    {/*                No messages found*/}
                    {/*            </div>*/}
                    {/*            <ChatBubbleLeftRightIcon className="w-32 h-32 inline-block" />*/}
                    {/*        </div>*/}
                    {/*    )}*/}
                    {/*    {localMessages.length > 0 && (*/}
                    {/*        <div className="flex-1 flex flex-col">*/}
                    {/*            {localMessages.map((message) => (*/}
                    {/*                <MessageItem*/}
                    {/*                    key={message.id}*/}
                    {/*                />*/}
                    {/*            ))}*/}
                    {/*        </div>*/}
                    {/*    )}*/}
                    {/*</div>*/}
                    {/*<MessageInput conversation = {selectedConversation} />*/}
                    <div className="message-list" ref={messagesCtrRef}>
                        {localMessages.map((message, index) => (
                            <MessageItem key={index} message={message} />
                        ))}
                    </div>
                    <MessageInput />
                </>
            )}
        </>
    );
}

Home.layout = (page) => {
    return (
        <AuthenticatedLayout user={page.props.auth.user}>
            <ChatLayout>
                {page}
            </ChatLayout>
        </AuthenticatedLayout>
    );
}

export default Home;
