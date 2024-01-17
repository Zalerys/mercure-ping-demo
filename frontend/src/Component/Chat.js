import { useEffect, useState } from "react";
import useBackendMessage from "../Hook/useBackendMessage";
import { SendHorizontal } from "lucide-react";

function Chat({ user, userList, conversationId, ...props }) {
  const backendMessage = useBackendMessage();
  const currentUser = sessionStorage.getItem("user");
  const [message, setMessage] = useState("");
  const [sentMessages, setSentMessages] = useState({});

  const submitMessagePrivate = async () => {
    const data = { message: message, user: currentUser };
    backendMessage(user, message, currentUser, conversationId).then((data) => {
      setSentMessages((prevMessages) => ({
        ...prevMessages,
        [user]: [...(prevMessages[user] || []), { user: currentUser, message }],
      }));
    });
  };

  const handleMessage = (e) => {
    const data = JSON.parse(e.data);
    if (data.content) {
      const userIdMatch = userList.find(
        (user) => user.username === data.currentUser
      );
      console.log(userIdMatch);
      if (userIdMatch) {
        setSentMessages((prevMessages) => ({
          ...prevMessages,
          [userIdMatch.id]: [
            ...(prevMessages[userIdMatch.id] || []),
            {
              user: data.currentUser,
              message: data.content.message,
            },
          ],
        }));
      }
    }
  };

  useEffect(() => {
    const url = new URL("http://localhost:9090/.well-known/mercure");
    url.searchParams.append("topic", "https://example.com/my-private-topic");

    const eventSource = new EventSource(url, { withCredentials: true });
    eventSource.onmessage = handleMessage;

    return () => {
      eventSource.close();
    };
  }, []);

  return (
    <>
      <div className="w-full h-screen bg-gray-100">
        <div className="bg-gray-100">
          <div key={user.id}>
            {props.historyConversation &&
            props.historyConversation.length > 0 ? (
              <div className="mx-5 mt-5 font-semibold text-center">
                {props.historyConversation.map((data, index) => (
                  <span className="flex" key={index}>
                    {data.sender}: {data.content}
                  </span>
                ))}
              </div>
            ) : null }

            {sentMessages[user] && (
              <div className="mx-5 mb-5 font-semibold text-center">
                {sentMessages[user].map((messageObj, index) => (
                  <span className="flex" key={index}>
                    {messageObj.user}: {messageObj.message}
                  </span>
                ))}
              </div>
            )}
          </div>
        </div>
      </div>
      <div className="fixed bottom-0 w-3/4">
        <div className="flex">
          <input
            value={message}
            onChange={(e) => setMessage(e.target.value)}
            class="form-control"
            placeholder="Écrire un message"
            aria-describedby="basic-addon2"
            className="w-5/6 py-4 pl-2 border-t-2 border-gray-300"
          />
          <div className="flex items-center justify-center w-1/6 p-3 bg-blue-200 hover:bg-blue-400">
            <button
              type="submit"
              className="flex text-center"
              onClick={submitMessagePrivate}
            >
              <SendHorizontal />
            </button>
          </div>
        </div>
      </div>
    </>
  );
}

export default Chat;
