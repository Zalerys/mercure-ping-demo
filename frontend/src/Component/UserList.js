import { useEffect, useState, useRef } from "react";
import useGetUserList from "../Hook/useGetUserList";
import useBackendPing from "../Hook/useBackendPing";
import User from "./User";
import Chat from "./Chat";

export default function UserList() {
  const currentUser = sessionStorage.getItem("user");
  const [userList, setUserList] = useState([]);
  const getUserList = useGetUserList();
  const backendPing = useBackendPing();

  const [userMessage, setUserMessage] = useState();

  const handleClick = (user) => {
    backendPing(user).then((data) => console.log(data));
    setUserMessage(user);
  };

  const handleMessage = (e) => {
    const data = JSON.parse(e.data);
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
          <div key={user.id} className="block">
            <User user={user} handleClick={handleClick} />
          </div>
        ))}
      </div>
      <div className="px-10">
        {userMessage ? (
          <>
            <h1 className="w-full py-5 text-2xl font-semibold text-center text-sky-800">
              Speaking with {userMessage}
            </h1>
            <Chat user={userMessage} userList={userList} />
          </>
        ) : null}{" "}
      <div>
        <Link to="/all">
          <button>Chat All Page</button>
        </Link>
      </div>
    </div>
  );
}
