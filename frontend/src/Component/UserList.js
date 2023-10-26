import { useEffect, useState } from "react";
import useGetUserList from "../Hook/useGetUserList";
import useBackendPing from "../Hook/useBackendPing";
import User from "./User";
import Chat from "./Chat";

export default function UserList({ submitMessagePrivate, currentUser, user }) {
  const [userList, setUserList] = useState([]);
  const [isOpen, setIsOpen] = useState({});
  const [sentMessages, setSentMessages] = useState({});
  const getUserList = useGetUserList();
  const backendPing = useBackendPing();

  const handleClick = (userId) => {
    backendPing(userId).then((data) => console.log(data));

    setIsOpen((prevState) => ({
      ...prevState,
      [userId]: !prevState[userId],
    }));
  };

  const handleMessage = (e) => {
    const data = JSON.parse(e.data);
    if (data.content) {
      const userIdMatch = userList.find(
        (user) => user.username === data.content.message.user
      );
      console.log("out", userIdMatch);

      if (userIdMatch) {
        console.log("int", userIdMatch);
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
    } else {
      console.log("ping");

      const userName = data.user;
      document
        .querySelector("h1")
        .insertAdjacentHTML(
          "afterend",
          `<div class="alert alert-success w-75 mx-auto">Ping ${userName}</div>`
        );
      window.setTimeout(() => {
        const $alert = document.querySelector(".alert");
        $alert.parentNode.removeChild($alert);
      }, 2000);
    }
  };

  useEffect(() => {
    getUserList().then((data) => {
      const userListArray = Object.values(data.users);
      const filteredUserList = userListArray.filter(
        (user) => user.username !== currentUser
      );

      setUserList(filteredUserList);
    });
    const url = new URL("http://localhost:9090/.well-known/mercure");
    url.searchParams.append("topic", "https://example.com/my-private-topic");

    const eventSource = new EventSource(url, { withCredentials: true });
    eventSource.onmessage = handleMessage;

    return () => {
      eventSource.close();
    };
  }, []);

  return (
    <div className="flex">
      <div className="w-1/2 h-screen px-10 bg-gray-100">
        <h1 className="w-full py-5 text-2xl font-semibold text-center text-sky-800">
          Hello {currentUser}
        </h1>
        {userList.map((user) => (
          <div key={user.id}>
            <User
              user={user}
              handleClick={handleClick}
              isOpen={isOpen}
              submitMessagePrivate={submitMessagePrivate}
            />
          </div>
        ))}
      </div>
      
      <Chat
        sentMessages={sentMessages}
        setSentMessages={setSentMessages}
        user={user}
      />
    </div>
  );
}
