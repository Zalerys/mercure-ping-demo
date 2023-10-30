import { useEffect, useState, useRef } from "react";
import useGetUserList from "../Hook/useGetUserList";
import useBackendPing from "../Hook/useBackendPing";
import { Link } from "react-router-dom";
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
    console.log("user: ", user);
    setUserMessage(user);
  };

  const handleMessage = (e) => {
    const data = JSON.parse(e.data);
    const userName = data.user;
    document
      .querySelector("h1")
      .insertAdjacentHTML(
        "afterend",
        `<div className="alert alert-success w-75 mx-auto">Ping ${userName}</div>`
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
    url.searchParams.append(
      "topic",
      "https://example.com/my-private-topic-ping"
    );

    const eventSource = new EventSource(url, { withCredentials: true });
    eventSource.onmessage = handleMessage;

    return () => {
      eventSource.close();
    };
  }, []);

  return (
    <div className="flex w-full">
      <div className="w-1/4 h-screen bg-white">
        <h1 className="w-full py-5 text-2xl font-semibold text-center text-gray">
          Hello {currentUser}
        </h1>

        <div className="w-full pb-5 text-center">
          <Link to="/all">
            <button className="p-3 bg-blue-200 rounded-sm hover:bg-blue-400">Chat All Page</button>
          </Link>
        </div>

        {userList.map((user) => (
          <div key={user.id} className="block">
            <User user={user} handleClick={handleClick} />
          </div>
        ))}
      </div>
      <div className="w-3/4 bg-gray-100">
        {userMessage ? (
          <>
            <h1 className="w-full p-5 text-2xl font-semibold text-center text-black bg-blue-200">
              {userMessage}
            </h1>
            <Chat user={userMessage} userList={userList} />
          </>
        ) : null}{" "}
        <div></div>
      </div>
    </div>
  );
}
