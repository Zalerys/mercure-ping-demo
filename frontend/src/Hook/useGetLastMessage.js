export default function useGetLastMessage() {
  return async function (conversation_id) {
    try {
      const response = await fetch(
        `http://localhost:8245/get-last-messages/${conversation_id}`,
        {
          method: "GET",
          mode: "cors",
        }
      );

      return await response.json();
    } catch (error) {
      console.error("Erreur lors de la récupération des données :", error);
    }
  };
}
