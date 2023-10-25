import React, { useEffect, useState, useRef } from "react";
import useBackendMessageToAll from "../Hook/useBackendMessageToAll";
import useGetUserList from "../Hook/useGetUserList";
import { Link } from "react-router-dom";

export default function UserList() {
  const [receivedMessages, setReceivedMessages] = useState([]);
  const backendMessageAll = useBackendMessageToAll();
  const getUserList = useGetUserList();
  const [newMessage, setNewMessage] = useState("");

  const currentUser = sessionStorage.getItem("user");

  let listUser = useRef([]);

  const submitMessageAll = async (e) => {
    e.preventDefault();
    const message = newMessage;
    const data = { message: message, user: currentUser };
    backendMessageAll(data).then(() => {});
  };

  const HandleMessageAll = (e) => {
    const data = JSON.parse(e.data);
    if (data.message.message) {
      const userIdMatch = listUser.current.find(
        (user) => user.username === data.message.message.user
      );
      if (userIdMatch) {
        setReceivedMessages((prevMessages) => [
          ...prevMessages,
          {
            user: data.message.message.user,
            message: data.message.message.message,
          },
        ]);
      }
    }
  };

  useEffect(() => {
    getUserList().then((data) => {
      const userListArray = Object.values(data.users);
      listUser.current = userListArray;
    });

    const url = new URL("http://localhost:9090/.well-known/mercure");
    url.searchParams.append(
      "topic",
      "https://example.com/my-public-message-all"
    );

    const eventSource = new EventSource(url, { withCredentials: true });
    eventSource.onmessage = HandleMessageAll;

    return () => {
      eventSource.close();
    };
  }, []);

  return (
    <div className="w-75">
      <div>
        <Link to="/">
          <button>Back</button>
        </Link>
      </div>
      <h1 className="m-5 text-center">Chat Général</h1>

      <div className="messages-container">
        <div className="messages">
          {receivedMessages.map((message, index) => (
            <div key={index} className="message">
              <span className="message-user">{message.user}: </span>
              <span className="message-text">{message.message}</span>
            </div>
          ))}
        </div>
      </div>

      <form
        onSubmit={submitMessageAll}
        className="d-flex flex-column w-75 h-50 input-group mx-auto"
      >
        <div className="d-flex">
          <input
            type="text"
            className="form-control"
            placeholder="Écrire un message"
            aria-describedby="basic-addon2"
            value={newMessage}
            onChange={(e) => setNewMessage(e.target.value)}
          />
          <div className="input-group-append">
            <button className="btn btn-outline-secondary" type="submit">
              Envoyer
            </button>
          </div>
        </div>
      </form>
    </div>
  );
}
