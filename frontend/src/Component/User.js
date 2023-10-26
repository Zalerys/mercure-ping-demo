import React from "react";
import { UserCircle2 } from "lucide-react";

function User({ user, handleClick }) {

  return (
    <div key={user.id}>
        <button
          onClick={() => handleClick(user.id)}
          className="bg-white border-2 rounded-md border-sky-800 w-full mb-2 items-center p-1 flex flex-row gap-2 hover:bg-sky-200"
          type="submit"
          value={user.id}
        >
          <div className="">
            <UserCircle2
              color="#075985"
              size={28}
            />
          </div>
          {user.username}
        </button>
      </div>
  );
}

export default User;
