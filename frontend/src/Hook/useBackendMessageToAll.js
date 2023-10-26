export default function useBackendMessageToAll() {
  return async function (messageContent) {
    console.log(messageContent);
    return await fetch(`http://localhost:8245/send-message-to-all`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        content: messageContent,
      }),
    })
      .then((data) => data.json())
      .then((data) => data.message);
  };
}
