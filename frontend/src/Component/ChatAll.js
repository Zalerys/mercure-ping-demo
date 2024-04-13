import React, { useEffect, useState, useRef } from "react";
import useBackendMessageToAll from "../Hook/useBackendMessageToAll";
import useGetUserList from "../Hook/useGetUserList";
import { Link } from "react-router-dom";
import { SendHorizontal } from "lucide-react";

export default function UserList() {
  const [receivedMessages, setReceivedMessages] = useState([]);
  const backendMessageAll = useBackendMessageToAll();
  const getUserList = useGetUserList();
  const [newMessage, setNewMessage] = useState("");
  const currentUser = sessionStorage.getItem("id");

  let listUser = useRef([]);

  const submitMessageAll = async (e) => {
    e.preventDefault();
    const message = newMessage;
    backendMessageAll(message, currentUser).then((response) => {
      // Optionally reset newMessage here if needed
      // setNewMessage("");
    });
  };

  const handleMessageAll = (event) => {
    const { content, from } = JSON.parse(event.data);
    setReceivedMessages((prevMessages) => [
      ...prevMessages,
      { user: from, message: content },
    ]);
  };

  useEffect(() => {
    getUserList().then((data) => {
      listUser.current = Object.values(data.users);
    });

    const url = new URL("http://localhost:9090/.well-known/mercure");
    url.searchParams.append("topic", "https://example.com/conversations/1");

    const eventSource = new EventSource(url.toString(), {
      withCredentials: true,
    });
    eventSource.onmessage = handleMessageAll;

    return () => {
      eventSource.close();
    };
  }, []);

  return (
    <div className="w-75">
      <Link to="/">
        <div className="p-5 bg-gray-100">
          <button className="p-3 bg-blue-200 rounded-sm hover:bg-blue-400">
            Back
          </button>
        </div>
      </Link>
      <h1 className="p-5 text-xl font-semibold text-center border-y-4">
        Chat Général
      </h1>
      <div className="w-full h-screen overflow-y-scroll bg-gray-100">
        <div className="pb-16">
          {receivedMessages.map((message, index) => (
            <div key={index} className="p-2 text-center">
              <span className="flex">
                {message.user}: {message.message}
              </span>
            </div>
          ))}
        </div>
      </div>
      <form
        onSubmit={submitMessageAll}
        className="mx-auto d-flex flex-column w-75 h-50"
      >
        <div className="fixed bottom-0 w-full">
          <div className="flex">
            <input
              type="text"
              className="w-5/6 py-4 pl-2 border-t-2 border-gray-300 form-control"
              placeholder="Écrire un message"
              value={newMessage}
              onChange={(e) => setNewMessage(e.target.value)}
            />
            <div className="flex items-center justify-center w-1/6 p-3 bg-blue-200 hover:bg-blue-400">
              <button type="submit">
                <SendHorizontal />
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  );
}
