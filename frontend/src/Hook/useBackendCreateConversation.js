export default function useBackendCreateConversation() {
  return async function (userIds) {
    try {
      const response = await fetch(
        "http://localhost:8245/conversation/create",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            users: userIds,
          }),
        }
      );

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(
          errorData.error ||
            "Une erreur s'est produite lors de la création de la conversation."
        );
      }

      const data = await response.json();
      return data;
    } catch (error) {
      console.error(
        "Erreur lors de l'appel à l'API pour la création de la conversation :",
        error.message
      );
      throw error;
    }
  };
}
