import React from "react";
import { UserCircle2 } from "lucide-react";
import { Link } from "react-router-dom";

function User({ user, handleClick }) {
  return (
    <div key={user.id}>
      <button
        onClick={() => handleClick(user.id)}
        className="flex flex-row items-center w-full gap-2 p-3 text-black text hover:bg-blue-200"
        type="submit"
        value={user.id}
      >
        <div className="">
          <UserCircle2 className="" color="#000000" size={28} />
        </div>
        {user.username}
      </button>
    </div>
  );
}

export default User;
