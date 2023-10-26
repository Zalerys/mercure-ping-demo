import React from "react";
import useBackendMessage from "../Hook/useBackendMessage";

function Chat({ user, setSentMessages, message, sentMessages }) {
  
  const backendMessage = useBackendMessage();
  const currentUser = sessionStorage.getItem("user");

  const submitMessagePrivate = async (e) => {
    const message = e.target[0].value;
    const userId = e.target[0].dataset.userid;
    const data = { message: message, user: currentUser };
    backendMessage(userId, data).then((data) => {
      setSentMessages((prevMessages) => ({
        ...prevMessages,
        [userId]: [
          ...(prevMessages[userId] || []),
          { user: currentUser, message },
        ],
      }));
    });

    e.preventDefault();
  };

  return (
    <div>
        <div className="w-1/2 h-screen px-10 bg-gray-100">
            <div key={user.id}>
              {sentMessages[user.id] && (
                <div className="m-5 text-center">
                  {sentMessages[user.id].map((messageObj, index) => (
                    <span key={index}>
                      {messageObj.user}: {messageObj.message}
                    </span>
                  ))}
                </div>
              )}
            </div>
        </div>
        
        <form className="" onSubmit={submitMessagePrivate}>
          <div class="flex">
            <input
              data-userid={user.id}
              value={message}
              onChange={(e) => sentMessages(e.target.value)}
              class="form-control"
              placeholder="Écrire un message"
              aria-describedby="basic-addon2"
              className="w-full mb-2 border-2 rounded-sm border-sky-700"
            />
            <div class="">
              <button type="submit" className="">
                Envoyé
              </button>
            </div>
          </div>
        </form>
      </div>
  );
}

export default Chat;
