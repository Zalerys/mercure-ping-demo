import { useEffect, useState } from "react";
import useBackendMessage from "../Hook/useBackendMessage";

function Chat({ user, userList }) {
  const backendMessage = useBackendMessage();
  const currentUser = sessionStorage.getItem("user");
  const [message, setMessage] = useState("");
  const [sentMessages, setSentMessages] = useState({});

  const submitMessagePrivate = async () => {
    const data = { message: message, user: currentUser };
    backendMessage(user, data).then((data) => {
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
        (user) => user.username === data.content.message.user
      );

      if (userIdMatch) {
        setSentMessages((prevMessages) => ({
          ...prevMessages,
          [userIdMatch.id]: [
            ...(prevMessages[userIdMatch.id] || []),
            {
              user: data.content.message.user,
              message: data.content.message.message,
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
    <div className="h-screen px-10">
      <div className=" bg-gray-100">
        <div key={user.id}>
          {sentMessages[user] && (
            <div className="m-5 text-center">
              {sentMessages[user].map((messageObj, index) => (
                <span key={index}>
                  {messageObj.user}: {messageObj.message}
                </span>
              ))}
            </div>
          )}
        </div>
      </div>

      <div className="flex">
        <input
          value={message}
          onChange={(e) => setMessage(e.target.value)}
          placeholder="Écrire un message"
          aria-describedby="basic-addon2"
          className="w-full mb-2 border-2 rounded-sm border-sky-700"
        />
        <div>
          <button type="submit" onClick={submitMessagePrivate}>
            Envoyé
          </button>
        </div>
      </div>
    </div>
  );
}

export default Chat;
