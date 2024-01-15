export default function useGetLastMessage() {
    return async function (conversation_id) {
        return fetch(`http://localhost:8245/get-last-messages/${conversation_id}`, {
            method: 'GET',
            mode: "cors",
        })
            .then(data => data.json())
    }
}