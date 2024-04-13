export default function useBackendMessage() {
  return async function (
    toUserId,
    messageContent,
    currentUser,
    conversationId
  ) {
    return await fetch(`http://localhost:8245/send-message/${toUserId}`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        content: messageContent,
        conversation_id: conversationId,
        currentUser: currentUser,
      }),
    })
      .then((data) => data.json())
      .then((data) => data.message);
  };
}
